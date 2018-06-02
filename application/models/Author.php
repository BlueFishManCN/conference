<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Author extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function index($paper_id) {
		$this->db->select('*');
		$this->db->from('author');
		$this->db->where('paper_id', $paper_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
}