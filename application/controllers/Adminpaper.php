<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminpaper extends CI_Controller {
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
		$this->load->view('adminpaper.html', $data);
		return;
	}

	public function paper() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$currentPage = $postdata['currentPage'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$data['total'] = $this->Paper->adminindextotal();
			$data['index'] = $this->Paper->adminindex($currentPage);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function searchpaper() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$currentPage = $postdata['currentPage'];
		$select = $postdata['select'];
		$keywords = $postdata['keywords'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$data['total'] = $this->Paper->adminsearchtotal($select, $keywords);
			$data['index'] = $this->Paper->adminsearch($currentPage, $select, $keywords);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function author() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$paper_id = $postdata['paper_id'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$data['index'] = $this->Author->index($paper_id);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function download() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$file = $postdata['file'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {

			force_download('./application/uploads/' . $file, NULL);

			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}
}
