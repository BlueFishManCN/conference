<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Paper
 */
class Paper extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function index($user_id)
    {
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

    /**
     * @return mixed
     */
    public function adminIndexTotal()
    {
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        return $this->db->count_all_results();
    }

    /**
     * @param $currentPage
     * @return mixed
     */
    public function adminIndex($currentPage)
    {
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

    /**
     * @param $status
     * @param $select
     * @param $keywords
     * @return mixed
     */
    public function adminSearchTotal($status, $select, $keywords)
    {
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

    /**
     * @param $currentPage
     * @param $status
     * @param $select
     * @param $keywords
     * @return mixed
     */
    public function adminSearch($currentPage, $status, $select, $keywords)
    {
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

    /**
     * @param $status
     * @param $select
     * @param $keywords
     * @return mixed
     */
    public function expertSearchTotal($status, $select, $keywords)
    {
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->where('is_delete', 0);
        if ($status == "Uncheck") {
            $this->db->where_not_in('reviewers_comments', array('Accept', 'Poster', 'Reject'));
        } elseif ($status != "") {
            $this->db->where('reviewers_comments', $status);
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

    /**
     * @param $currentPage
     * @param $status
     * @param $select
     * @param $keywords
     * @return mixed
     */
    public function expertSearch($currentPage, $status, $select, $keywords)
    {
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->where('is_delete', 0);
        if ($status == "Uncheck") {
            $this->db->where_not_in('reviewers_comments', array('Accept', 'Poster', 'Reject'));
        } elseif ($status != "") {
            $this->db->where('reviewers_comments', $status);
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

    /**
     * @param $id
     * @return mixed
     */
    public function getPaperByID($id)
    {
        $this->db->select('*');
        $this->db->from('paper');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $id
     * @return int
     */
    public function getPercentageByID($id)
    {
        $this->db->select('percentage');
        $this->db->from('paper');
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
        $this->db->update('paper', $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFileByID($id)
    {
        $this->db->select('file');
        $this->db->from('paper');
        $this->db->where('id', $id);
        $this->db->where('is_delete', 0);
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get()->result();
        return $query[0]->file;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function checkAccept($user_id)
    {
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

    /**
     * @param $id
     * @param $user_id
     * @param $topic
     * @param $title
     * @param $abstract
     * @param $keywords
     */
    public function insert($id, $user_id, $topic, $title, $abstract, $keywords)
    {
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

    /**
     * @param $paper_id
     * @param $file
     */
    public function upload($paper_id, $file)
    {
        $data = array(
            'file' => $file,
        );
        $this->db->where('id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->update('paper', $data);
    }

    /**
     * @param $paper_id
     * @param $topic
     * @param $title
     * @param $abstract
     * @param $keywords
     */
    public function update($paper_id, $topic, $title, $abstract, $keywords)
    {
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

    /**
     * @param $paper_id
     * @param $is_accept
     */
    public function accept($paper_id, $is_accept)
    {
        $data = array(
            'is_accept' => $is_accept,
        );
        $this->db->where('id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->update('paper', $data);
    }

    /**
     * @param $paper_id
     * @param $reviewers_comments
     */
    public function expertAccept($paper_id, $reviewers_comments)
    {
        $data = array(
            'reviewers_comments' => $reviewers_comments,
        );
        $this->db->where('id', $paper_id);
        $this->db->where('is_delete', 0);
        $this->db->update('paper', $data);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function addIndex($user_id)
    {
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