<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function insert($id, $firstname, $lastname, $email, $country, $organization, $password_hash) {
		$data = array(
			'id' => $id,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'email' => $email,
			'country' => $country,
			'organization' => $organization,
			'password_hash' => $password_hash,
		);
		$this->db->insert("user", $data);
	}

	public function getUserById($id) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id', $id);
		$query = $this->db->get()->result();
		return $query;
	}

	public function getUserByUsername($username) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $username);
		$query = $this->db->get()->result();
		return $query;
	}

	public function getUserByEmail($email) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this->db->get()->result();
		return $query;
	}

}