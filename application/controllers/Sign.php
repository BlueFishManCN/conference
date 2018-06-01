<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User');
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('url_helper');

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.163.com';
		$config['smtp_user'] = 'jerrychangcn@163.com';
		$config['smtp_pass'] = 'zjy897833204';
		$config['smtp_port'] = '25';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';

		$this->email->initialize($config);
	}

	public function step1() {
		$postdata = $this->input->post();

		$firstname = $postdata['firstname'];
		$lastname = $postdata['lastname'];
		$email = $postdata['email'];

		if (!empty($this->User->getUserByEmail($email))) {
			$data["status"] = false;
			$data["message"] = "This email has already been registered";
			echo json_encode($data);
			return;
		}

		$token = random_string('alnum', 8);

		$sessiondata = array(
			'token' => $token,
		);
		$this->session->set_userdata($sessiondata);

		$this->email->from('jerrychangcn@163.com', 'GEG2018');
		$this->email->to($email);
		$this->email->subject('Verification code');
		$this->email->message('Verification code:' . $token);
		$this->email->send();

		$data['status'] = true;
		echo json_encode($data);
		return;
	}

	public function step2() {
		$postdata = $this->input->post();
		$code = $postdata['code'];

		if (!$this->session->has_userdata('token')) {
			$data['status'] = false;
			echo json_encode($data);
			return;
		}

		if ($code != $this->session->userdata('token')) {
			$data['status'] = false;
			echo json_encode($data);
			return;
		}

		$data['status'] = true;
		echo json_encode($data);
		return;
	}

	public function signup() {
		$postdata = $this->input->post();

		$id = rand(1, 9999999);
		while (!empty($this->User->getUserById($id))) {
			$id = rand(1, 9999999);
		}

		$firstname = $postdata['firstname'];
		$lastname = $postdata['lastname'];
		$email = $postdata['email'];
		$country = $postdata['country'];
		$organization = $postdata['organization'];
		$password = $postdata['password'];
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		if (!empty($this->User->getUserByEmail($email))) {
			$data["status"] = false;
			$data["message"] = "This email has already been registered";
			echo json_encode($data);
			return;
		}

		$this->User->insert($id, $firstname, $lastname, $email, $country, $organization, $password_hash);

		$sessiondata = array(
			'id' => $id,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'is_login' => true,
		);
		$this->session->set_userdata($sessiondata);

		$data['status'] = true;
		echo json_encode($data);
		return;
	}

	public function signin() {
		$postdata = $this->input->post();
		$username = $postdata['username'];
		$password = $postdata['password'];

		$user = $this->User->getUserByEmail($username);
		if (empty($user)) {
			$data["status"] = false;
			$data["message"] = "This user does not exist";
			echo json_encode($data);
			return;
		}
		if (!password_verify($password, $user[0]->password_hash)) {
			$data["status"] = false;
			$data["message"] = "Wrong password";
			echo json_encode($data);
			return;
		};

		$sessiondata = array(
			'id' => $user[0]->id,
			'firstname' => $user[0]->firstname,
			'is_login' => true,
		);
		$this->session->set_userdata($sessiondata);

		$data['status'] = true;
		echo json_encode($data);
		return;
	}

	public function signout() {
		$postdata = $this->input->post();
		$id = $postdata['id'];
		$username = $postdata['username'];

		$s_id = $this->session->userdata('id');
		$s_username = $this->session->userdata('username');

		if ($id == $s_id && $username == $s_username) {
			session_destroy();
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}
}