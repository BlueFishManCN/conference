<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('url_helper');
	}

	public function index() {
		if (!$this->session->has_userdata('id')) {
			$data['id'] = 0;
			$data['firstname'] = "Login or Create account";
			$data['is_login'] = false;
			$this->load->view('home.html', $data);
			return;
		}
		if ($this->session->userdata('id') == 1) {
			redirect('/adminpaper/index');
			return;
		}
		$data['id'] = $this->session->userdata('id');
		$data['firstname'] = $this->session->userdata('firstname');
		$data['is_login'] = true;
		$this->load->view('home.html', $data);
		return;
	}
}
