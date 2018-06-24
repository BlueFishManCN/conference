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
		$this->db->where('is_delete', 0);
		$this->db->order_by('created_at', 'ASC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function getAuthorById($id) {
		$this->db->select('*');
		$this->db->from('author');
		$this->db->where('id', $id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getAuthorByPaperid($paper_id) {
		$this->db->select('*');
		$this->db->from('author');
		$this->db->where('paper_id', $paper_id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function insert($id, $paper_id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding) {
		$data = array(
			'id' => $id,
			'paper_id' => $paper_id,
			'firstname' => $authorfirstname,
			'lastname' => $authorlastname,
			'email' => $email,
			'country' => $country,
			'organization' => $organization,
			'corresponding' => $corresponding,
		);
		$this->db->insert("author", $data);
	}

	public function deleteauthor($author_id) {
		$data = array(
			'is_delete' => 1,
		);
		$this->db->where('id', $author_id);
		$this->db->where('is_delete', 0);
		$this->db->update('author', $data);
	}
}