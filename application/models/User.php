<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class User
 */
class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $id
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $country
     * @param $organization
     * @param $password_hash
     */
    public function insert($id, $firstname, $lastname, $email, $country, $organization, $password_hash)
    {
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

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEmailById($id)
    {
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query[0]->email;
    }

    /**
     * @param $email
     * @param $password_hash
     */
    public function resetPassword($email, $password_hash)
    {
        $data = array(
            'password_hash' => $password_hash,
        );
        $this->db->where('email', $email);
        $this->db->where('is_delete', 0);
        $this->db->update('user', $data);
    }
}