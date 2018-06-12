<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Paper');
		$this->load->model('Author');
		$this->load->library('session');
		$this->load->library('upload');
		$this->load->helper('cookie');
		$this->load->helper('download');
		$this->load->helper('url_helper');
	}

	public function index() {
		if (!$this->session->has_userdata('id')) {
			redirect('/home/index');
			return;
		}
		$data['id'] = $this->session->userdata('id');
		$data['firstname'] = $this->session->userdata('firstname');
		$data['is_login'] = true;
		$this->load->view('submission.html', $data);
		return;
	}
}