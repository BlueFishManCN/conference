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
			$this->db->order_by('created_at', 'ASC');
			$author = $this->db->get()->result_array();
			$key['author'] = $author;
		}

		return $query;
	}

	public function adminindextotal() {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		return $this->db->count_all_results();
	}

	public function adminindex($currentPage) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$this->db->limit(5, ($currentPage - 1) * 5);
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

	public function adminsearchtotal($status, $select, $keywords) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('is_delete', 0);
		if ($status == "Uncheck") {
			$this->db->where_not_in('is_accept', array('Accept', 'Poster', 'Reject'));
		} elseif ($status != "") {
			$this->db->where('is_accept', $status);
		}
		if ($select != "") {
			$this->db->where('topic', $select);
		}
		if ($keywords != "") {
			$this->db->like('id', $keywords);
			$this->db->or_like('title', $keywords);
			$this->db->or_like('keywords', $keywords);
		}
		$this->db->order_by('updated_at', 'DESC');
		return $this->db->count_all_results();
	}

	public function adminsearch($currentPage, $status, $select, $keywords) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('is_delete', 0);
		if ($status == "Uncheck") {
			$this->db->where_not_in('is_accept', array('Accept', 'Poster', 'Reject'));
		} elseif ($status != "") {
			$this->db->where('is_accept', $status);
		}
		if ($select != "") {
			$this->db->where('topic', $select);
		}
		if ($keywords != "") {
			$this->db->like('id', $keywords);
			$this->db->or_like('title', $keywords);
			$this->db->or_like('keywords', $keywords);

		}
		$this->db->order_by('updated_at', 'DESC');
		$this->db->limit(5, ($currentPage - 1) * 5);
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

	public function getPercentageByid($id) {
		$this->db->select('percentage');
		$this->db->from('paper');
		$this->db->where('id', $id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return (int) $query[0]->percentage;
	}

	public function addPercentageByid($paper_id, $sum) {
		$data = array(
			'percentage' => $sum,
		);
		$this->db->where('id', $paper_id);
		$this->db->where('is_delete', 0);
		$this->db->update('paper', $data);
	}

	public function getFileByid($id) {
		$this->db->select('file');
		$this->db->from('paper');
		$this->db->where('id', $id);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query[0]->file;
	}

	public function checkaccept($user_id) {
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('user_id', $user_id);
		$this->db->where_in('is_accept', array('Accept', 'Poster'));
		$this->db->where('is_delete', 0);

		$query = $this->db->get()->result_array();

		if (empty($query)) {
			return false;
		} else {
			return true;
		}
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

	public function upload($paper_id, $file) {
		$data = array(
			'file' => $file,
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

	public function accept($paper_id, $is_accept) {
		$data = array(
			'is_accept' => $is_accept,
		);
		$this->db->where('id', $paper_id);
		$this->db->where('is_delete', 0);
		$this->db->update('paper', $data);
	}

	public function addindex($user_id) {
		$this->db->select('id');
		$this->db->from('paper');
		$this->db->where('user_id', $user_id);
		$this->db->where_in('is_accept', array('Accept', 'Poster'));
		$this->db->where('is_delete', 0);
		$query = $this->db->get()->result_array();

		$paperid = array();
		foreach ($query as $row) {
			array_push($paperid, $row['id']);
		}

		$this->db->select('author_id');
		$this->db->from('attendee');
		$this->db->where('user_id', $user_id);
		$this->db->where_in('paper_id', $paperid);
		$this->db->where('is_delete', 0);
		$query = $this->db->get()->result_array();

		$authorid = array();
		foreach ($query as $row) {
			array_push($authorid, $row['author_id']);
		}

		$this->db->select('*');
		$this->db->from('author');
		$this->db->where_in('paper_id', $paperid);
		if (!empty($authorid)) {
			$this->db->where_not_in('id', $authorid);
		}
		$this->db->where('is_delete', 0);
		$query = $this->db->get()->result_array();

		return $query;
	}
}