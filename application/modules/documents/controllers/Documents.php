<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends MY_Controller {

	public function index(){
		$data = array(
			'title' => 'Documents'
		);
		$this->load_page('index',$data);
	}

	public function scanBarcode() {
		$data = array(
			'title'	=> 'Scan Barcode',
		);
		$this->load_page('scanbarcode',$data);
	}

	// Fetch Data for Datatable
	public function getDocumentList(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');

		$select = "files.file_id, files.file_name, files.file_division, files.file_type, files.file_path, files.barcode, files.date_added, bc.barcode_path, bc.barcode_id";
		$column_order = array('file_name','file_type');
		$join = array('rms_barcodes as bc' => 'bc.fk_file_id = files.file_id');
		$where = "";
		$list = datatables('rms_files as files',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
        foreach ($list['data'] as $key => $value) {
			$value->date_added = date('M d, Y', strtotime($value->date_added));
            $new_array[] = $value;
        }
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $list['count_all'],
			"recordsFiltered" => $list['count'],
			"data" => $new_array,
		);
		echo json_encode($output);
	}

	// Add Document
	public function addDocument(){
        $respond = array();
        $file_path = "./assets/uploads/credentials/";
        if (isset($_POST) || isset($_FILES)) {
            $ctr = 0;
            $files_key = "";
            //getting the key for upload file
            foreach ($_FILES as $key => $value) {
                $files_key = $key;
			}
			// Assign Original File name
			$orig_filename = $_FILES[$files_key]['name'];

			//validation for inputs
			if (empty($orig_filename) ) {
				$_POST['docfile'] = '';
			}

			$title			= trim($this->input->post('title'));
			$division		= trim($this->input->post('division'));
			$category		= trim($this->input->post('category'));

			if ($category == 'Reports') {
				$reports = trim($this->input->post('reports'));
				if($reports == 'Others') {
					$others = trim($this->input->post('others'));
					$category = $category.' - '.$reports.' - '.$others;
				} else {
					$category = $category.' - '.$reports;
				}
			}

			$codequery = 1;
			for ($i=0; $codequery > 0 ; $i++) {
				$code 	   = $this->generate_num(6);
				$codequery = $this->MY_Model->getRows('rms_files',array('where' => array('barcode' => $code )),'count');
			}

			$barcodepath = $this->generate_barcode($code);

			foreach ($_POST as $key => $value) {
				$name = ucfirst(str_replace('_', ' ', $key));
				$this->form_validation->set_rules($key, $name, 'trim|required', array('required' => '{field} is required'));
				if (!$this->form_validation->run()) {
					if ($value == '') {
						$respond[$key] = form_error($key);
						$ctr += 1;
					}
				}
			}
			if ($ctr == 0) {
				$chkfile = array(
					'select'	=> 'file_name',
					'where'		=> array('file_name' => $orig_filename),
				);
				$chkfilename = getrow('rms_files',$chkfile);
				if($chkfilename) {
					$respond['docfile'] = 'Title exists. Please rename';
					$ctr += 1;
				} else {
					

					// Document File Saving configuration
					$config['upload_path']		= $file_path;
					$config["allowed_types"]	= 'doc|docx|pdf|xls|zip|png|jpg|jpeg';
					$config['max_size']			= 0;
					$config['encrypt_name']		= FALSE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($files_key)) {
						$respond['status'] = 'error';
						$respond[$files_key] = $this->upload->display_errors();
					}else{
						//upload to db
						$filename = $this->upload->data('file_name');
						$allfilepath = $file_path . $filename;
						$data= array(
							'file_name'     	=> $title,
							'file_path'     	=> $allfilepath,
							'file_division'     => $division,
							'file_type'     	=> $category,
							'barcode'     		=> $code,
						);
						$query = insert('rms_files',$data);
						if ($query) {
							$barcodeData = array(
								'fk_file_id'	=> $query,
								'barcode_path'	=> $barcodepath,
							);
							$saveBarcode = insert('rms_barcodes',$barcodeData);
							if($saveBarcode) {
								$respond['status']	= "success";
								$respond['msg'] 	= "Document Added Successfully";
							} else {
								$respond['status']	= "error";
								$respond['msg'] 	= "Something went wrong";
							}
						} else {
							$respond['status']	= "error";
							$respond['msg'] 	= "Something went wrong";
						}
					}
				}
			}	
        }
        json($respond);
	}

	// Remove Document
	public function removeDocument(){
		$file_id		= $_POST['file_id'];
		$file_path		= $_POST['file_path'];
		$barcode_path	= $_POST['barcode_path'];
		$data = array('file_id' => $file_id);
		$query = delete('rms_files',$data);
		if ($query) {
			unlink($file_path);
			$data2 = array('fk_file_id' => $file_id);
			$query2 = delete('rms_barcodes', $data2);
			if($query2) {
				unlink($barcode_path);
				response('success', 'success', 'Document File has been removed');
			} else {
				response('error', 'danger', 'Something went wrong');
			}
		} else {
			response('error', 'danger', 'Something went wrong');
		}
	}

	public function fetchBarcodeScan() {
		$barcode = trim($this->input->post('barcode'));

		$data['select'] = "file.file_id,file.file_path,file.file_name,file.file_division,file.file_type";
		$data['join']	= array('rms_barcodes as br' => 'br.fk_file_id = file.file_id');
		$data['where']	= "file.barcode = '$barcode'";
		$query = getrow('rms_files as file',$data,'row');
		json($query);
	}

} // End of Class