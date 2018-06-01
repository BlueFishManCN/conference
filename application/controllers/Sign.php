<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('url_helper');
	}

	public function signup() {
		$postdata = $this->input->post();

		$id = rand(1, 9999999);
		while (!empty($this->User->getUserById($id))) {
			$id = rand(1, 9999999);
		}

		$username = $postdata['username'];
		$email = $postdata['email'];
		$phone = $postdata['phone'];
		$country = $postdata['country'];
		$organization = $postdata['organization'];
		$password = $postdata['password'];
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		if (!empty($this->User->getUserByUsername($username))) {
			$data["status"] = false;
			$data["message"] = "This username has already been registered";
			echo json_encode($data);
			return;
		}

		if (!empty($this->User->getUserByEmail($email))) {
			$data["status"] = false;
			$data["message"] = "This email has already been registered";
			echo json_encode($data);
			return;
		}

		$this->User->insert($id, $username, $email, $phone, $country, $organization, $password_hash);

		$sessiondata = array(
			'id' => $id,
			'username' => $username,
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

		$user = $this->User->getUserByUsername($username);
		if (empty($user)) {
			$user = $this->User->getUserByEmail($username);
		}
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
			'username' => $user[0]->username,
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