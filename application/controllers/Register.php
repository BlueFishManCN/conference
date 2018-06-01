<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('url_helper');
	}

	public function index() {
		if (!$this->session->has_userdata('id')) {
			$data['id'] = 0;
			$data['username'] = "Sign In or Sign Up";
			$data['is_login'] = false;
			$this->load->view('register.html', $data);
			return;
		}
		$data['id'] = $this->session->userdata('id');
		$data['username'] = $this->session->userdata('username');
		$data['is_login'] = true;
		$this->load->view('register.html', $data);
		return;
	}
}
