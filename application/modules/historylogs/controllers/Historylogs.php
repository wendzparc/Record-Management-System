<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historylogs extends MY_Controller {
    public function index() {
        $data = array(
			'title' => 'History Logs'
		);
		$this->load_page('index',$data);
    }

    // Fetch Data for Datatable
	public function getLogs(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');

		$select = "*";
		$column_order = array('log_message','date_added');
		$join = array();
		$where = "";
		$list = datatables('rms_logs',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
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

} // End of Class