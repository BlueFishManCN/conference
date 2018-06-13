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

	public function upload($attendee_id) {
		$data = array(
			'file' => $attendee_id,
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
}