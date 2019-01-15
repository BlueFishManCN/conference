<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        $this->load->model('Paper');
        $this->load->model('Author');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->helper('cookie');
        $this->load->helper('download');
        $this->load->helper('url_helper');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.163.com';
        $config['smtp_user'] = 'jerrychangcn@163.com';
        $config['smtp_pass'] = 'Wyzjy897833204';
        $config['smtp_port'] = '465';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['priority'] = 5;

        $this->email->initialize($config);
    }

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
            redirect('/adminpaper/index');
            return;
        } else {
            $this->load->view('submission.html', $data);
            return;
        }
    }

    public function paper()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['index'] = $this->Paper->index($user_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

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
            $data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function submit()
    {
        $postdata = $this->input->post();
        $id = rand(1, 9999999);
        while (!empty($this->Paper->getPaperById($id))) {
            $id = rand(1, 9999999);
        }
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $topic = $postdata['topic'];
        $title = $postdata['title'];
        $abstract = $postdata['abstract'];
        $keywords = $postdata['keywords'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Paper->insert($id, $user_id, $topic, $title, $abstract, $keywords);

            $data['paper_id'] = $id;
            $data['paper_percentage'] = 30;
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function edit()
    {
        $postdata = $this->input->post();

        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $topic = $postdata['paper_id'];
        $topic = $postdata['topic'];
        $title = $postdata['title'];
        $abstract = $postdata['abstract'];
        $keywords = $postdata['keywords'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Paper->update($paper_id, $topic, $title, $abstract, $keywords);

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function addauthor()
    {
        $postdata = $this->input->post();

        $id = rand(1, 9999999);
        while (!empty($this->Author->getAuthorById($id))) {
            $id = rand(1, 9999999);
        }

        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];
        $authorfirstname = $postdata['authorfirstname'];
        $authorlastname = $postdata['authorlastname'];
        $email = $postdata['email'];
        $country = $postdata['country'];
        $organization = $postdata['organization'];
        $corresponding = $postdata['corresponding'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            if (empty($this->Author->index($paper_id))) {
                $sum = $this->Paper->getPercentageByid($paper_id);
                $this->Paper->addPercentageByid($paper_id, $sum + 30);
            }
            $this->Author->insert($id, $paper_id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding);

            $data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function saveeditauthor()
    {
        $postdata = $this->input->post();

        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $author_id = $postdata['author_id'];
        $authorfirstname = $postdata['authorfirstname'];
        $authorlastname = $postdata['authorlastname'];
        $email = $postdata['email'];
        $country = $postdata['country'];
        $organization = $postdata['organization'];
        $corresponding = $postdata['corresponding'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Author->updateauthor($author_id, $authorfirstname, $authorlastname, $email, $country, $organization, $corresponding);

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function deleteauthor()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];
        $author_id = $postdata['author_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Author->deleteauthor($author_id);
            if (empty($this->Author->index($paper_id))) {
                $sum = $this->Paper->getPercentageByid($paper_id);
                $this->Paper->addPercentageByid($paper_id, $sum - 30);
            }
            $data['paper_percentage'] = $this->Paper->getPercentageByid($paper_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function email()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $email = $this->User->getEmailById($user_id);
            $this->email->from('jerrychangcn@163.com', 'GEG2018');
            $this->email->to($email);
            $this->email->subject('GEG2018: Submission message');
            $this->email->message('<h3>Dear ' . $firstname . '</h3><p>Your abstract submission is successful!</p><p>Please submit your full paper at your earliest convenience.</p><p>Thank you for your cooperation!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
            $this->email->send();

            $emails = $this->Author->getAuthorByPaperid($paper_id);
            foreach ($emails as $item) {
                $this->email->from('jerrychangcn@163.com', 'GEG2018');
                $this->email->to($item->email);
                $this->email->subject('GEG2018: Submission message');
                $this->email->message('<h3>Dear ' . $item->firstname . '</h3><p>Your abstract submission is successful!</p><p>Please submit your full paper at your earliest convenience.</p><p>Thank you for your cooperation!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                $this->email->send();
            }

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function uploadfile()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $config['upload_path'] = './application/uploads/';
            $config['allowed_types'] = 'pdf|zip';
            $config['file_name'] = $paper_id;
            $config['file_ext_tolower'] = TRUE;
            $config['overwrite'] = true;
            $config['max_size'] = '2048';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output($this->upload->display_errors('', ''));
            } else {
                if (empty($this->Paper->getFileById($paper_id))) {
                    $sum = $this->Paper->getPercentageByid($paper_id);
                    $this->Paper->addPercentageByid($paper_id, $sum + 40);
                }
                $paper_percentage = $this->Paper->getPercentageByid($paper_id);
                $data = array('upload_data' => $this->upload->data());
                $this->Paper->upload($paper_id, $data['upload_data']['file_name']);
                $this->output
                    ->set_output(json_encode(array('status' => false, 'paper_percentage' => $paper_percentage)));

                $email = $this->User->getEmailById($user_id);
                $this->email->from('jerrychangcn@163.com', 'GEG2018');
                $this->email->to($email);
                $this->email->subject('GEG2018: Submission message');
                $this->email->message('<h3>Dear ' . $firstname . '</h3><p>Your paper submission is successful!</p><p>You will be informed soon whether the paper is accepted or not.</p><p>Thank you for your cooperation!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                $this->email->send();

                $emails = $this->Author->getAuthorByPaperid($paper_id);
                foreach ($emails as $item) {
                    $this->email->from('jerrychangcn@163.com', 'GEG2018');
                    $this->email->to($item->email);
                    $this->email->subject('GEG2018: Submission message');
                    $this->email->message('<h3>Dear ' . $item->firstname . '</h3><p>Your paper submission is successful!</p><p>You will be informed soon whether the paper is accepted or not.</p><p>Thank you for your cooperation!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
                    $this->email->send();
                }
            }
            return;
        }
    }

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

    public function posterpaper()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $paper_id = $postdata['paper_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {

            $this->Paper->accept($paper_id, 'Poster');

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }
}
