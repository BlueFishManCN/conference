<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Paper');
		$this->load->model('Author');
		$this->load->model('Attendee');
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

		if ($this->Paper->checkaccept($data['id'])) {
			$this->load->view('registration.html', $data);
			return;
		} else {
			redirect('/submission/index');
			return;
		}
	}

	public function addattendee() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];

		$attendeefirstname = $postdata['attendeefirstname'];
		$lastname = $postdata['lastname'];
		$email = $postdata['email'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$this->Attendee->insert($user_id, $attendeefirstname, $lastname, $email);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function deleteattendee() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];

		$attendee_id = $postdata['attendee_id'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$this->Attendee->removeattendee($attendee_id);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function edit() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];

		$attendee_id = $postdata['attendee_id'];
		$attendeefirstname = $postdata['attendeefirstname'];
		$lastname = $postdata['lastname'];
		$email = $postdata['email'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$this->Attendee->update($attendee_id, $attendeefirstname, $lastname, $email);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}

	public function uploadfile() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];
		$attendee_id = $postdata['attendee_id'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$config['upload_path'] = './application/uploads/attendee/';
			$config['allowed_types'] = 'zip|rar|pdf|jpg|png';
			$config['file_name'] = $attendee_id;
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
				$this->Attendee->upload($attendee_id);
				$this->output
					->set_output(json_encode(array('status' => false)));
			}
			return;
		}
	}

	public function attendee() {
		$postdata = $this->input->post();
		$user_id = $postdata['id'];
		$firstname = $postdata['firstname'];

		$s_id = $this->session->userdata('id');
		$s_firstname = $this->session->userdata('firstname');

		if ($user_id == $s_id && $firstname == $s_firstname) {
			$data['index'] = $this->Attendee->index($user_id);
			$data['status'] = true;
			echo json_encode($data);
			return;
		}
	}
}
