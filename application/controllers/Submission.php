<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {
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
			$data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
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
			$data['paper_id'] = $id;
			$data['paper_percentage'] = 30;
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function edit() {
		$postdata = $this->input->post();

		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$paper_id = $topic = $postdata['paper_id'];
		$topic = $postdata['topic'];
		$title = $postdata['title'];
		$abstract = $postdata['abstract'];
		$keywords = $postdata['keywords'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$this->Paper->update($paper_id, $topic, $title, $abstract, $keywords);

			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function addauthor() {
		$postdata = $this->input->post();

		$id = rand(1, 9999999);
		while (!empty($this->Author->getAuthorById($id))) {
			$id = rand(1, 9999999);
		}

		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$paper_id = $postdata['paper_id'];
		$authorfirstname = $postdata['authorfirstname'];
		$authorlastname = $postdata['authorlastname'];
		$email = $postdata['email'];
		$country = $postdata['country'];
		$organization = $postdata['organization'];
		$corresponding = $postdata['corresponding'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			if (empty($this->Author->index($paper_id))) {
				$sum = $this->Paper->getPercentageByid($paper_id);
				$this->Paper->addPercentageByid($paper_id, $sum + 30);
			}
			$this->Author->insert($id, $paper_id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding);

			$data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function deleteauthor() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$paper_id = $postdata['paper_id'];
		$author_id = $postdata['author_id'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$this->Author->deleteauthor($author_id);
			if (empty($this->Author->index($paper_id))) {
				$sum = $this->Paper->getPercentageByid($paper_id);
				$this->Paper->addPercentageByid($paper_id, $sum - 30);
			}
			$data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function uploadfile() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$paper_id = $postdata['paper_id'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$config['upload_path'] = './application/uploads/';
			$config['allowed_types'] = 'pdf|zip';
			$config['file_name'] = $paper_id;
			$config['file_ext_tolower'] = TRUE;
			$config['overwrite'] = true;
			$config['max_size'] = '2048';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('file')) {
				$this->output
					->set_content_type('application/json')
					->set_status_header(400)
					->set_output($this->upload->display_errors('', ''));
			} else {
				if (empty($this->Paper->getFileById($paper_id))) {
					$sum = $this->Paper->getPercentageByid($paper_id);
					$this->Paper->addPercentageByid($paper_id, $sum + 40);
				}
				$paper_percentage = $this->Paper->getPercentageByid($paper_id);
				$this->Paper->upload($paper_id);
				$this->output
					->set_output(json_encode(array('status' => false, 'paper_percentage' => $paper_percentage)));
			}
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
