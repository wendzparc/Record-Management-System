<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	if (!function_exists('create_date_folder')) {
		function create_date_folder($path)
		{
			$year_folder = $path . date('Y') . '/';
			$month_folder = $year_folder . date('m') . '/';
			$day_folder = $month_folder . date('d') . '/';

			if (!file_exists($year_folder)) {
				mkdir($year_folder, 0777, true);
			}
			if (!file_exists($month_folder)) {
				mkdir($month_folder, 0777, true);
			}
			if (!file_exists($day_folder)) {
				mkdir($day_folder, 0777, true);
			}

			$folder['year'] = $year_folder;
			$folder['month'] = $month_folder;
			$folder['day'] = $day_folder;

			return $folder;
		}
	}
	if(!function_exists('response')) {
		function response($response = null,$type = '',$msg = ''){
			$_response = array();
			if(is_array($response)){
				$_response['response'] 	= !empty($response['response']) ? $response['response'] : null;
				$_response['type'] 		= !empty($response['type']) ? $response['type'] : null;
				$_response['msg'] 		= !empty($response['msg']) ? $response['msg'] : null;
			} else {
				$_response['response'] 	= $response;
				$_response['type'] 		= $type;
				$_response['msg'] 		= $msg;
			}
			json($_response);
	    }
	}

	//Query Builder

	if(!function_exists('last_query')) {
		function last_query(){
			$ci =& get_instance();
	        echo $ci->db->last_query();
	    }
	}

	if(!function_exists('raw')) {
		function raw($query,$result = 'array'){
			$ci =& get_instance();
	        return $ci->MY_Model->raw($query,$result);
	    }
	}

	if(!function_exists('getrow')) {
		function getrow($table,$options = array(),$result = 'array'){
			$ci =& get_instance();
			return $ci->MY_Model->getRows($table,$options,$result);
		}
	}

	if(!function_exists('rowpagination')) {
		function rowpagination($table,$options = array()){
			$ci =& get_instance();
			return $ci->MY_Model->getRowsPagination($table,$options);
		}
	}

	if(!function_exists('datatables')){
		function datatables($table, $column_order, $select = "*", $where = "", $join = array(), $limit, $offset, $search, $order,$group = ''){
			$ci =& get_instance();
			return $ci->MY_Model->get_datatables($table, $column_order, $select, $where, $join, $limit, $offset, $search, $order,$group);
	    }
	}

	if(!function_exists('insert')) {
		function insert($table,$data){
			$ci =& get_instance();
	        return $ci->MY_Model->insert($table,$data);
	    }
	}

	if(!function_exists('batch_insert')) {
		function batch_insert($table,$data){
			global $ci;
	        $ci->MY_Model->batch_insert($table, $data);
	        return true;
	    }
	}

	if(!function_exists('update')) {
		function update($table,$set,$where){
			$ci =& get_instance();
	        $ci->MY_Model->update($table,$set,$where);
	        return true;
	    }
	}

	if(!function_exists('delete')) {
		function delete($table,$where){
			$ci =& get_instance();
	        $ci->MY_Model->delete($table,$where);
	        return true;
	    }
	}

	//End of Query Builder

	if(!function_exists('post')) {
		function post($key,$xss_filter = false){
	        $ci =& get_instance();
			return ($ci->input->post($key)) ? $ci->input->post($key, $xss_filter) : $ci->input->post();
	    }
	}

	if(!function_exists('json')) {
		function json($data,$isJson = true){
			if($isJson){
				echo json_encode($data);
			} else {
				echo "<pre>";
				print_r($data);
				echo "</pre>";
			}
		}
	}

	if (!function_exists('session')) {
		function session($session_key){
			$ci =& get_instance();
			return (!empty($ci->session->$session_key)) ? $ci->session->$session_key : "Session named {$session_key} is not set";
		}
	}

	if(!function_exists('fetch_class')) {
		function fetch_class(){
	        $ci =& get_instance();
			return $ci->router->fetch_class();
	    }
	}

	if(!function_exists('fetch_method')) {
		function fetch_method(){
	        $ci =& get_instance();
			return $ci->router->fetch_method();
	    }
	}

	if(!function_exists('__load_assets__')) {
		function __load_assets__($assets,$type){
	        $ci =& get_instance();
			echo "\r\n";
			foreach ($assets[$ci->router->fetch_class()][$type] as $key => $value) {
				if($type == 'css'){
					echo "<link rel='stylesheet' href='". base_url('assets/modules/' . $ci->router->fetch_class() . '/'.$type.'/') . $value . "' />";
				} else {
					echo "<script type='text/javascript' src='" . base_url('assets/modules/' . $ci->router->fetch_class() . '/' . $type . '/') . $value . "' ></script>";
				}
				echo "\r\n";
			}
	    }
	}
?>
