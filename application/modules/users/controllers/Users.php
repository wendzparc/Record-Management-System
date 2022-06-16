<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function index(){
		if($_SESSION['user_type'] != 3) {
			$data = array(
				'title' => 'Users'
			);
			$this->load_page('index',$data);
		} else {
			redirect(base_url('login'));
		}
	}

	// Fetch Data for Datatable
	public function getUsersList(){
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		$order = $this->input->post('order');
		$draw = $this->input->post('draw');
		$select = "user.user_id, user.username, user.user_type, user.user_status, meta.firstname, CONCAT(meta.firstname, ' ', meta.lastname) as fullname,";
		$select .= "meta.office, meta.division, meta.phone";
		$column_order = array('firstname','username','office','division','phone','user_type','user_status');
		$join = array('rms_usermeta as meta' => 'meta.fk_user_id = user.user_id');
		$where = "user_type != 1";
		$list = datatables('rms_users as user',$column_order, $select, $where, $join, $limit, $offset ,$search, $order);
		$new_array = array();
        foreach ($list['data'] as $key => $value) {
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

	public function addManager() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

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
				$username		= trim($this->input->post('username'));
				$password		= trim($this->input->post('password'));

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
						'email'			=> 'manager@system.com',
						'password'		=> password_hash($password,PASSWORD_DEFAULT),
						'user_type'		=> 2,
						'user_status'	=> 1,
					);
					$insertUser = insert('rms_users',$saveUserData);
					if($insertUser) {
						$saveMetaData = array(
							'fk_user_id'	=> $insertUser,
							'firstname'		=> 'Manager',
							'lastname'		=> 'User',
							'phone'			=> 'N / A',
							'address'		=> 'N / A',
							'phone'			=> 'N / A',
							'office'		=> 'N / A',
							'division'		=> 'N / A',
						);
						$inserMeta = insert('rms_usermeta',$saveMetaData);
						if($inserMeta) {
							$respond['status'] = "success";
							$respond['msg'] = "Manager added Successfully";
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

	// Fetch User Information
	public function getUserInfo(){
		$user_id = $_POST['user_id'];
		$parameters['select']	= "user.user_id,user.username,user.user_type,user.email,meta.firstname,meta.middlename,meta.lastname,meta.phone,meta.address,meta.office,meta.division";
		$parameters['join']		= array('rms_usermeta as meta' => 'meta.fk_user_id = user.user_id');
		$parameters['where']	= array('user_id' => $user_id);
		$data = getrow('rms_users as user', $parameters, 'row');
		json($data);
	}

	public function updateUser() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

			$user_id	= trim($this->input->post('user_id'));
			$user_type	= trim($this->input->post('user_type'));
			$username	= trim($this->input->post('username'));
			$email		= trim($this->input->post('email'));
			$password 	= trim($this->input->post('password'));
			$firstname	= trim($this->input->post('firstname'));
			$middlename	= trim($this->input->post('middlename'));
			$lastname	= trim($this->input->post('lastname'));
			$phone		= trim($this->input->post('phone'));
			$address	= trim($this->input->post('address'));
			$office		= trim($this->input->post('office'));
			$division	= trim($this->input->post('division'));

			if (empty($middlename)) {
				unset($_POST['middlename']);
			}
			if (empty($address)) {
				unset($_POST['address']);
			}
			if (empty($phone)) {
				unset($_POST['phone']);
			}
			if (empty($email)) {
				unset($_POST['email']);
			}
			if (empty($password)) {
				unset($_POST['password']);
			}
			if ($user_type != 3) {
				unset($_POST['office']);
				unset($_POST['division']);
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
					'where'		=> "username = '$username' AND user_id != '$user_id'",
				);
				$chkUsername = getrow('rms_users',$chkUsernameData);
				if($chkUsername) {
					$respond['username'] = 'Username already Exists';
					$ctr += 1;
				} else {
					$saveData = array(
						'set'	=> array(
							'username'	=> $username,
						),
						'where' => "user_id = '$user_id'",
					);
					if (isset($password) || !empty($password)) {
						$saveData['set']['password'] = password_hash($password, PASSWORD_DEFAULT);
					}
					$updateUser = update('rms_users',$saveData['set'],$saveData['where']);
					if ($updateUser) {
						$saveMetaData = array(
							'set'	=> array(
								'firstname'	=> $firstname,
								'lastname'	=> $lastname,
							),
							'where' => "fk_user_id = '$user_id'",
						);

						if (!empty($middlename)) {
							$saveMetaData['set']['middlename'] = $middlename;
						}
						if (!empty($address)) {
							$saveMetaData['set']['address'] = $address;
						}
						if (!empty($phone)) {
							$saveMetaData['set']['phone'] = $phone;
						}

						$updateMeta = update('rms_usermeta',$saveMetaData['set'],$saveMetaData['where']);
						if($updateMeta) {
							$respond['status'] = "success";
							$respond['msg'] = "User updated Successfully";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = "Something went wrong";
						}
					} else {
						$respond['status'] = "error";
						$respond['msg'] = "Something went wrong";
					}
				} // End of CheckUsername
			} // End of ctr
			json($respond);
		}
	}

	public function updateMyProfile() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

			$user_id	= trim($this->input->post('puser_id'));
			$user_type	= trim($this->input->post('puser_type'));
			$username	= trim($this->input->post('pusername'));
			$email		= trim($this->input->post('pemail'));
			$password 	= trim($this->input->post('ppassword'));
			$firstname	= trim($this->input->post('pfirstname'));
			$middlename	= trim($this->input->post('pmiddlename'));
			$lastname	= trim($this->input->post('plastname'));
			$phone		= trim($this->input->post('pphone'));
			$address	= trim($this->input->post('paddress'));
			$office		= trim($this->input->post('poffice'));
			$division	= trim($this->input->post('pdivision'));

			if (empty($middlename)) {
				unset($_POST['pmiddlename']);
			}
			if (empty($address)) {
				unset($_POST['paddress']);
			}
			if (empty($phone)) {
				unset($_POST['pphone']);
			}
			if (empty($email)) {
				unset($_POST['pemail']);
			}
			if (empty($password)) {
				unset($_POST['ppassword']);
			}
			if ($user_type != 3) {
				unset($_POST['poffice']);
				unset($_POST['pdivision']);
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
					'where'		=> "username = '$username' AND user_id != '$user_id'",
				);
				$chkUsername = getrow('rms_users',$chkUsernameData);
				if($chkUsername) {
					$respond['username'] = 'Username already Exists';
					$ctr += 1;
				} else {
					$saveData = array(
						'set'	=> array(
							'username'	=> $username,
						),
						'where' => "user_id = '$user_id'",
					);
					if (!empty($email)) {
						$saveData['set']['email'] = $email;
					}
					if (isset($password) || !empty($password)) {
						$saveData['set']['password'] = password_hash($password, PASSWORD_DEFAULT);
					}
					$updateUser = update('rms_users',$saveData['set'],$saveData['where']);
					if ($updateUser) {
						$saveMetaData = array(
							'set'	=> array(
								'firstname'	=> $firstname,
								'lastname'	=> $lastname,
							),
							'where' => "fk_user_id = '$user_id'",
						);

						if (!empty($middlename)) {
							$saveMetaData['set']['middlename'] = $middlename;
						}
						if (!empty($address)) {
							$saveMetaData['set']['address'] = $address;
						}
						if (!empty($phone)) {
							$saveMetaData['set']['phone'] = $phone;
						}
						if (!empty($office)) {
							$saveMetaData['set']['office'] = $office;
						}
						if (!empty($division)) {
							$saveMetaData['set']['division'] = $division;
						}

						$updateMeta = update('rms_usermeta',$saveMetaData['set'],$saveMetaData['where']);
						if($updateMeta) {
							$respond['status'] = "success";
							$respond['msg'] = "Profile updated Successfully";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = "Something went wrong";
						}
					} else {
						$respond['status'] = "error";
						$respond['msg'] = "Something went wrong";
					}
				} // End of CheckUsername
			} // End of ctr
			json($respond);
		}
	}

	public function userStatus() {
		$user_id = $_POST['user_id'];
		$status = $_POST['user_status'];
		$stat = ($status == 1)?2:1 ;
		($status == 1)?$infomsg = 'Deactivated':$infomsg = 'Activated';
		$data = array(
			'set'   => array( 'user_status' => $stat ),
			'where' => array( 'user_id' => $user_id ),
		);
		$query = update('rms_users', $data['set'], $data['where']);
		if ($query) {
			$respond['status'] = "success";
			$respond['msg']    = "User ".$infomsg;
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error'.$infomsg.' User';
		}
		json($respond);
	}

	public function updateProfile() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;

			$user_id	= $_SESSION['user_id'];
			$username	= trim($this->input->post('upusername'));
			$email		= trim($this->input->post('upemail'));
			$password 	= trim($this->input->post('uppassword'));

			if (!isset($password) || empty($password)) {
				unset($_POST['uppassword']);
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
					'where'		=> "username = '$username' AND user_id != '$user_id'",
				);
				$chkUsername = getrow('pti_users',$chkUsernameData);
				if($chkUsername) {
					$respond['upusername'] = 'Username already Exists';
					$ctr += 1;
				} else {
					$chkEmailData = array(
						'select'	=> 'username',
						'where'		=> "email = '$email' AND user_id != '$user_id'",
					);
					$chkEmail = getrow('pti_users',$chkEmailData);
					if($chkEmail) {
						$respond['upemail'] = 'Email already Exists';
						$ctr += 1;
					} else {
						$saveData = array(
							'set'	=> array(
								'username'	=> $username,
								'email' 	=> $email,
							),
							'where' => "user_id = '$user_id'",
						);
		
						if (isset($password) || !empty($password)) {
							$saveData['set']['password'] = password_hash($password, PASSWORD_DEFAULT);
						}
		
						$updateUser = update('pti_users',$saveData['set'],$saveData['where']);
						if ($updateUser) {
							$respond['status'] = "success";
							$respond['msg'] = "User updated Successfully";
						} else {
							$respond['status'] = "error";
							$respond['msg'] = "Something went wrong";
						}
					} // End of Check Email
				} // End of CheckUsername
			} // End of ctr
			json($respond);
		}
	}

	public function removeUser() {
		$user_id = $_POST['user_id'];
		$data = array(
			'set'   => array( 'user_status' => 0 ),
			'where' => array( 'user_id' => $user_id ),
		);
		$query = update('rms_users', $data['set'], $data['where']);
		if ($query) {
			$respond['status'] = "success";
			$respond['msg']    = "User Removed";
		} else {
			$respond['status'] = "error";
			$respond['msg'] = 'Error removing User';
		}
		json($respond);
	}

} // End of Class

