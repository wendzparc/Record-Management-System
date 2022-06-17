<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	public $assets_ = array(
		'login' => array(
			'css' => array(),
			'js' => array('login.min.js'),
		),
		'users' => array(
			'css' => array(),
			'js' => array('users.min.js'),
		),
		'documents' => array(
			'css' => array('documents.min.css'),
			'js' => array('documents.min.js'),
		),
		'historylogs' => array(
			'css' => array(),
			'js' => array('historylogs.min.js'),
		),
	);

	public function __construct(){
		$route = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$exclusions = array();
		if(!in_array($route,$exclusions)) {
			if($route == 'login'){
				if($this->session->has_userdata('user_id')){
					if($_SESSION['user_type'] != 3) {
						redirect(base_url('users'));
					} else {
						redirect(base_url('documents'));
					}
				}
			} else {
				if(!$this->session->has_userdata('user_id')){
					redirect(base_url('login'));
				}
			}
		}
	}

	public function load_page($page, $data = array()){
		$data['route'] = $this->router->fetch_class();
		$data['__assets__'] = $this->assets_;
		$data['profile'] = $this->get_profile();
      	$this->load->view('includes/head',$data);
      	$this->load->view($page,$data);
      	$this->load->view('includes/footer',$data);
    }

	public function login_page($page, $data = array()){
		$data['__assets__'] = $this->assets_;
		$this->load->view('includes/login_head',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/login_footer',$data);
  	}

	public function get_profile(){
		$data['select'] = "CONCAT(firstname, ' ', lastname) as fullname";
		$data['join']	= array('rms_usermeta as meta' => "meta.fk_user_id = user.user_id");
		$data['where']	= "user_id = {$_SESSION['user_id']}";
		$query = $this->MY_Model->getRows('rms_users as user',$data,'row');
		return $query;
	}

	public function saveLogs($msg = '') {
		$user_id	= $_SESSION['user_id'];
		$fullname	= $this->get_profile()->fullname;

		$data['fk_user_id'] = $user_id;
		$data['log_message'] = "{$fullname} {$msg}";
		$query = insert('rms_logs',$data);
		return $query;
	}

	protected function generate_code($strength = 20) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
	}
	protected function generate_num($strength = 4) {
        $permitted_chars = '0123456789';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
	}

	protected function generate_barcode($code = 12345) {
		$this->zend->load('Zend/Barcode');
		$imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
		imagepng($imageResource, './assets/uploads/barcodes/'.$code.'.png');
		$barcode = './assets/uploads/barcodes/'.$code.'.png';
		
		return $barcode;
	}
}
