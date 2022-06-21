<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index(){
		$data = array(
            'title' => 'Login | Record Management System'
        );
        $this->login_page('index',$data);
	}
	public function auth(){
		$title = array('title' => 'Login | Record Management System');

		$this->form_validation->set_rules('uname', 'Username', 'trim|required');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
	        $this->login_page('index',$title);
        }else{
			$user = trim($this->input->post('uname'));
			$pass = trim($this->input->post('pass'));

			$data = array(
				'select' => 'username,password,user_id,user_type,user_status',
				'where' => array('username' => $user),
			 );
			$query = $this->MY_Model->getRows('rms_users',$data,'row');
			if (!$query) {
				$this->session->set_flashdata('error', 'No record found');
				$this->login_page('index',$title);
			}else{
				if($query->user_status == 3) {
					$this->session->set_flashdata('error', 'Account is still waiting for Approval');
					$this->login_page('index',$title);
				} else if($query->user_status == 2) {
					$this->session->set_flashdata('error', 'Account Deactivated');
					$this->login_page('index',$title);
				} else {
					$verifypass = password_verify($pass, $query->password);
					if ($verifypass) {
						$arr_session = array(
							'user_id'		=> $query->user_id,
							'user_type'		=> $query->user_type,
						);
						$this->session->set_userdata($arr_session);
						if($query->user_type == 3) {
							redirect(base_url('documents'));
						} else {
							redirect(base_url('users'));
						}
					} else {
						$this->session->set_flashdata('error', 'Invalid Credentials');
						$this->login_page('index',$title);
					} // End of Password Checking
				} // End of User Status Checking
			} // End of Record Checking
        }
	}

	// Registration
	public function register() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

			$firstname	= trim($this->input->post('firstname'));
			$middlename	= trim($this->input->post('middlename'));
			$lastname	= trim($this->input->post('lastname'));
			$address	= trim($this->input->post('address'));
			$username	= trim($this->input->post('username'));
			$email		= trim($this->input->post('email'));
			$phone		= trim($this->input->post('phone'));
			$password	= trim($this->input->post('password'));
			$office		= trim($this->input->post('office'));
			$division	= trim($this->input->post('division'));

			if (empty($middlename)) {
				unset($_POST['middlename']);
			}
			if (empty($email)) {
				unset($_POST['email']);
			}
			if (empty($phone)) {
				unset($_POST['phone']);
			}

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
				$chkUsernameData = array(
					'select'	=> 'username',
					'where'		=> "username = '$username'",
				);
				$chkUsername = getrow('rms_users',$chkUsernameData);
				if($chkUsername) {
					$respond['username'] = 'Username already Exists';
					$ctr += 1;
				} else {
					$saveUserData = array(
						'username'		=> $username,
						'password'		=> password_hash($password,PASSWORD_DEFAULT),
						'user_type'		=> 3,
						'user_status'	=> 3,
					);
					
					$saveUserData['email'] = (!empty($email)) ? $email : '-' ;

					$insertUser = insert('rms_users',$saveUserData);
					if($insertUser) {
						$saveMetaData = array(
							'fk_user_id'	=> $insertUser,
							'firstname'		=> $firstname,
							'lastname'		=> $lastname,
							'address'		=> $address,
							'office'		=> $office,
							'division'		=> $division,
						);

						$saveMetaData['middlename'] = (!empty($middlename)) ? $middlename : '-' ;
						$saveMetaData['phone'] = (!empty($phone)) ? $phone : '-' ;

						$inserMeta = insert('rms_usermeta',$saveMetaData);
						if($inserMeta) {
							$respond['status'] = "success";
							$respond['msg'] = "Registered Successfully. Wait for Admin Approval";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = "Something went wrong";
						}
					} else {
						$respond['status'] = "error";
						$respond['msg'] = "Something went wrong";
					}
				} // End of Check Username
			} // End of ctr
			json($respond);
		}
	}

} // End of Class


