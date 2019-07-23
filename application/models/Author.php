<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Author
 */
class Author extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $paper_id
     * @return mixed
     */
    public function index($paper_id)
    {
        $this->db->select('*');
        $this->db->from('author');
        $this->db->where('paper_id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAuthorByID($id)
    {
        $this->db->select('*');
        $this->db->from('author');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $paper_id
     * @return mixed
     */
    public function getAuthorByPaperID($paper_id)
    {
        $this->db->select('*');
        $this->db->from('author');
        $this->db->where('paper_id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $id
     * @param $paper_id
     * @param $authorfirstname
     * @param $authorlastname
     * @param $email
     * @param $country
     * @param $organization
     * @param $corresponding
     */
    public function insert($id, $paper_id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding)
    {
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

    /**
     * @param $id
     * @param $authorfirstname
     * @param $authorlastname
     * @param $email
     * @param $country
     * @param $organization
     * @param $corresponding
     */
    public function updateAuthor($id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding)
    {
        $data = array(
            'firstname' => $authorfirstname,
            'lastname' => $authorlastname,
            'email' => $email,
            'country' => $country,
            'organization' => $organization,
            'corresponding' => $corresponding,
        );
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->update('author', $data);
    }

    /**
     * @param $author_id
     */
    public function deleteAuthor($author_id)
    {
        $data = array(
            'is_delete' => 1,
        );
        $this->db->where('id', $author_id);
        $this->db->where('is_delete', 0);
        $this->db->update('author', $data);
    }
}