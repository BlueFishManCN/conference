<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Paper');
		$this->load->model('Author');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->helper('url_helper');
	}

	public function index() {
		if (!$this->session->has_userdata('id')) {
			$data['id'] = 0;
			$data['firstname'] = "Sign In or Sign Up";
			$data['is_login'] = false;
			$this->load->view('submission.html', $data);
			return;
		}
		$data['id'] = $this->session->userdata('id');
		$data['firstname'] = $this->session->userdata('firstname');
		$data['is_login'] = true;
		$this->load->view('submission.html', $data);
		return;
	}

	public function paper() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$data['index'] = $this->Paper->index($user_id);
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

	public function submit() {
		$postdata = $this->input->post();
		$id = rand(1, 9999999);
		while (!empty($this->Paper->getPaperById($id))) {
			$id = rand(1, 9999999);
		}
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$topic = $postdata['topic'];
		$title = $postdata['title'];
		$abstract = $postdata['abstract'];
		$keywords = $postdata['keywords'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {

			$this->Paper->insert($id, $user_id, $topic, $title, $abstract, $keywords);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}
}
