<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendee extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function insert($user_id, $attendeefirstname, $lastname, $email) {
		$data = array(
			'user_id' => $user_id,
			'firstname' => $attendeefirstname,
			'lastname' => $lastname,
			'email' => $email,
		);
		$this->db->insert("attendee", $data);
	}

	public function removeattendee($attendee_id) {
		$data = array(
			'is_delete' => 1,
		);
		$this->db->where('id', $attendee_id);
		$this->db->where('is_delete', 0);
		$this->db->update('attendee', $data);
	}

	public function update($attendee_id, $attendeefirstname, $lastname, $email) {
		$data = array(
			'firstname' => $attendeefirstname,
			'lastname' => $lastname,
			'email' => $email,
		);
		$this->db->where('id', $attendee_id);
		$this->db->where('is_delete', 0);
		$this->db->update("attendee", $data);
	}

	public function accept($attendee_id, $is_check, $is_accept) {
		$data = array(
			'is_check' => $is_check,
			'is_accept' => $is_accept,
		);
		$this->db->where('id', $attendee_id);
		$this->db->where('is_delete', 0);
		$this->db->update('attendee', $data);
	}

	public function upload($attendee_id, $filename) {
		$data = array(
			'file' => $filename,
		);
		$this->db->where('id', $attendee_id);
		$this->db->where('is_delete', 0);
		$this->db->update("attendee", $data);
	}

	public function index($user_id) {
		$this->db->select('*');
		$this->db->from('attendee');
		$this->db->where('user_id', $user_id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function adminindextotal() {
		$this->db->select('*');
		$this->db->from('attendee');
		$this->db->where('is_delete', 0);
		return $this->db->count_all_results();
	}

	public function adminindex($currentPage) {
		$this->db->select('*');
		$this->db->from('attendee');
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$this->db->limit(5, ($currentPage - 1) * 5);
		$query = $this->db->get()->result_array();

		return $query;
	}

	public function adminsearchtotal($keywords) {
		$this->db->select('*');
		$this->db->from('attendee');
		$this->db->where('is_delete', 0);

		if ($keywords != "") {
			$this->db->like('id', $keywords);
			$this->db->or_like('firstname', $keywords);
			$this->db->or_like('lastname', $keywords);
			$this->db->or_like('email', $keywords);

		}
		return $this->db->count_all_results();
	}

	public function adminsearch($currentPage, $keywords) {
		$this->db->select('*');
		$this->db->from('attendee');
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');

		if ($keywords != "") {
			$this->db->like('id', $keywords);
			$this->db->or_like('firstname', $keywords);
			$this->db->or_like('lastname', $keywords);
			$this->db->or_like('email', $keywords);

		}

		$this->db->limit(5, ($currentPage - 1) * 5);
		$query = $this->db->get()->result_array();

		return $query;
	}
}