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
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getUserByUsername($username) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $username);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getUserByEmail($email) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$this->db->where('is_delete', 0);
		$this->db->order_by('updated_at', 'DESC');
		$query = $this->db->get()->result();
		return $query;
	}

	public function resetPassword($email, $password_hash) {
		$data = array(
			'password_hash' => $password_hash,
		);
		$this->db->where('email', $email);
		$this->db->where('is_delete', 0);
		$this->db->update('user', $data);
	}

}