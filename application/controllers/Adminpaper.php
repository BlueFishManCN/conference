<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Adminpaper
 */
class Adminpaper extends CI_Controller
{
    /**
     * Adminpaper constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Paper');
        $this->load->model('Author');
    }

    /**
     *
     */
    public function index()
    {
        if (!$this->session->has_userdata('id')) {
            redirect('/home/index');
            return;
        }

        $data['id'] = $this->session->userdata('id');
        $data['firstname'] = $this->session->userdata('firstname');
        $data['is_login'] = true;

        if ($this->session->userdata('id') == 1) {
            redirect('/expertpaper/index');
            return;
        } elseif ($this->session->userdata('id') == 2) {
            $this->load->view('adminpaper.html', $data);
            return;
        } else {
            redirect('/home/index');
            return;
        }
    }

    /**
     *
     */
    public function paper()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $currentPage = $postdata['currentPage'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['total'] = $this->Paper->adminIndexTotal();
            $data['index'] = $this->Paper->adminIndex($currentPage);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function searchPaper()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $currentPage = $postdata['currentPage'];
        $status = $postdata['status'];
        $select = $postdata['select'];
        $keywords = $postdata['keywords'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['total'] = $this->Paper->adminSearchTotal($status, $select, $keywords);
            $data['index'] = $this->Paper->adminSearch($currentPage, $status, $select, $keywords);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function expertSearchPaper()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $currentPage = $postdata['currentPage'];
        $status = $postdata['status'];
        $select = $postdata['select'];
        $keywords = $postdata['keywords'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['total'] = $this->Paper->expertSearchTotal($status, $select, $keywords);
            $data['index'] = $this->Paper->expertSearch($currentPage, $status, $select, $keywords);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function author()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['index'] = $this->Author->index($paper_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function download()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $file = $postdata['file'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {

            force_download('./application/uploads/' . $file, NULL);

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function accept()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];
        $is_accept = $postdata['is_accept'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Paper->accept($paper_id, $is_accept);

            $emails = $this->Author->getAuthorByPaperID($paper_id);
            foreach ($emails as $item) {
                $this->email->from('jerrychangcn@163.com', 'GEG2018');
                $this->email->to($item->email);
                $this->email->subject('GEG2018: Submission message');
                if ($is_accept == 'Accept') {
                    $this->email->message('<h3>Dear ' . $item->firstname . '</h3><p>Congratulations!</p><p>I am glad to inform you that your paper is accepted by 2018 GEG conference.You are invited to give a presentation at the conference.</p><p>Please register for the conference at your earliest convenience before 30th September 2018.</p><p>If you will not be able to attend the conference, you can choose to post your paper at the conference.</p><p>Hope to see you in Shanghai!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                } else if ($is_accept == 'Poster') {
                    $this->email->message('<h3>Dear ' . $item->firstname . '</h3><p>Thank you for submitting your paper to the conference!</p><p>I am glad to inform you that your paper was selected to post at the conference.</p><p>Please register for the poster at your earliest convenience before 30th September 2018.</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                } else {

                    $this->email->message('<h3>Dear ' . $item->firstname . '</h3><p>Thank you for submitting your paper to the conference!</p><p>We received a large number of good papers this year and your paper is relatively competitive. However, we only have limited space for the conference and I am sorry that your paper was not accepted by the conference.</p><p>Welcome to submit your paper again next year!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                }
                $this->email->send();
            }

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    /**
     *
     */
    public function expertAccept()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];
        $reviewers_comments = $postdata['reviewers_comments'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Paper->expertAccept($paper_id, $reviewers_comments);

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }
}
