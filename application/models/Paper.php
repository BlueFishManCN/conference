<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paper extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function index($user_id) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
}