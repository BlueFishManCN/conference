<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Attendee
 */
class Attendee extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $user_id
     * @param $paper_id
     * @param $author_id
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $country
     * @param $organization
     */
    public function insert($user_id, $paper_id, $author_id, $firstname, $lastname, $email, $country, $organization)
    {
        $data = array(
            'user_id' => $user_id,
            'paper_id' => $paper_id,
            'author_id' => $author_id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'country' => $country,
            'organization' => $organization,
        );
        $this->db->insert("attendee", $data);
    }

    /**
     * @param $attendee_id
     */
    public function removeAttendee($attendee_id)
    {
        $data = array(
            'is_delete' => 1,
        );
        $this->db->where('id', $attendee_id);
        $this->db->where('is_delete', 0);
        $this->db->update('attendee', $data);
    }

    /**
     * @param $attendee_id
     * @param $attendeefirstname
     * @param $lastname
     * @param $email
     * @param $country
     * @param $organization
     */
    public function update($attendee_id, $attendeefirstname, $lastname, $email, $country, $organization)
    {
        $data = array(
            'firstname' => $attendeefirstname,
            'lastname' => $lastname,
            'email' => $email,
            'country' => $country,
            'organization' => $organization,
        );
        $this->db->where('id', $attendee_id);
        $this->db->where('is_delete', 0);
        $this->db->update("attendee", $data);
    }

    /**
     * @param $attendee_id
     * @param $is_accept
     */
    public function accept($attendee_id, $is_accept)
    {
        $data = array(
            'is_accept' => $is_accept,
        );
        $this->db->where('id', $attendee_id);
        $this->db->where('is_delete', 0);
        $this->db->update('attendee', $data);
    }

    /**
     * @param $attendee_id
     * @param $filename
     */
    public function upload($attendee_id, $filename)
    {
        $data = array(
            'file' => $filename,
        );
        $this->db->where('id', $attendee_id);
        $this->db->where('is_delete', 0);
        $this->db->update("attendee", $data);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function index($user_id)
    {
        $this->db->select('*');
        $this->db->from('attendee');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    /**
     * @return mixed
     */
    public function adminIndexTotal()
    {
        $this->db->select('*');
        $this->db->from('attendee');
        $this->db->where('is_delete', 0);
        return $this->db->count_all_results();
    }

    /**
     * @param $currentPage
     * @return mixed
     */
    public function adminIndex($currentPage)
    {
        $this->db->select('*');
        $this->db->from('attendee');
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $this->db->limit(5, ($currentPage - 1) * 5);
        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * @param $status
     * @param $keywords
     * @return mixed
     */
    public function adminSearchTotal($status, $keywords)
    {
        $this->db->select('*');
        $this->db->from('attendee');
        $this->db->where('is_delete', 0);

        if ($status == "Uncheck") {
            $this->db->where_not_in('is_accept', array('Accept', 'Reject'));
        } elseif ($status != "") {
            $this->db->where('is_accept', $status);
        }

        if ($keywords != "") {
            $this->db->like('id', $keywords);
            $this->db->or_like('firstname', $keywords);
            $this->db->or_like('lastname', $keywords);
            $this->db->or_like('email', $keywords);
            $this->db->or_like('country', $keywords);
            $this->db->or_like('organization', $keywords);
        }
        return $this->db->count_all_results();
    }

    /**
     * @param $currentPage
     * @param $status
     * @param $keywords
     * @return mixed
     */
    public function adminSearch($currentPage, $status, $keywords)
    {
        $this->db->select('*');
        $this->db->from('attendee');
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        // var_dump($status);
        // die();

        if ($status == "Uncheck") {
            $this->db->where_not_in('is_accept', array('Accept', 'Reject'));
        } elseif ($status != "") {
            $this->db->where('is_accept', $status);
        }

        if ($keywords != "") {
            $this->db->like('id', $keywords);
            $this->db->or_like('firstname', $keywords);
            $this->db->or_like('lastname', $keywords);
            $this->db->or_like('email', $keywords);
            $this->db->or_like('country', $keywords);
            $this->db->or_like('organization', $keywords);
        }

        $this->db->limit(5, ($currentPage - 1) * 5);
        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFileByID($id)
    {
        $this->db->select('file');
        $this->db->from('attendee');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query[0]->file;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEmailByID($id)
    {
        $this->db->select('email');
        $this->db->from('attendee');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query[0]->email;
    }

    /**
     * @param $id
     * @return int
     */
    public function getPercentageByID($id)
    {
        $this->db->select('percentage');
        $this->db->from('attendee');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return (int)$query[0]->percentage;
    }

    /**
     * @param $paper_id
     * @param $sum
     */
    public function addPercentageByID($paper_id, $sum)
    {
        $data = array(
            'percentage' => $sum,
        );
        $this->db->where('id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->update('attendee', $data);
    }
}