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
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result_array();

		foreach ($query as &$key) {
			$this->db->select('*');
			$this->db->from('author');
			$this->db->where('paper_id', $key['id']);
			$this->db->where('is_delete', 0);
			$this->db->order_by('updated_at', 'DESC');
			$author = $this->db->get()->result_array();
			$key['author'] = $author;
		}

		return $query;
	}

	public function getPaperById($id) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('id', $id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function insert($id, $user_id, $topic, $title, $abstract, $keywords) {
		$data = array(
			'id' => $id,
			'user_id' => $user_id,
			'topic' => $topic,
			'title' => $title,
			'abstract' => $abstract,
			'keywords' => $keywords,
		);
		$this->db->insert("paper", $data);
	}

	public function upload($paper_id) {
		$data = array(
			'file' => $paper_id . '.pdf',
		);
		$this->db->where('id', $paper_id);
		$this->db->where('is_delete', 0);
		$this->db->update('paper', $data);
	}

	public function update($paper_id, $topic, $title, $abstract, $keywords) {
		$data = array(
			'topic' => $topic,
			'title' => $title,
			'abstract' => $abstract,
			'keywords' => $keywords,
		);
		$this->db->where('id', $paper_id);
		$this->db->where('is_delete', 0);
		$this->db->update('paper', $data);
	}
}