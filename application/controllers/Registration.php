<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Paper');
        $this->load->model('Author');
        $this->load->model('Attendee');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->helper('cookie');
        $this->load->helper('download');
        $this->load->helper('url_helper');
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
            if ($this->Paper->checkaccept($data['id'])) {
                $this->load->view('registration.html', $data);
                return;
            } else {
                redirect('/submission/index');
                return;
            }
        }
    }

    public function addattendee()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $author_id = $postdata['author_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {

            foreach ($author_id as $item) {
                $author = $this->Author->getAuthorById($item)[0];
                $this->Attendee->insert($user_id, $author->paper_id, $author->id, $author->firstname, $author->lastname, $author->email, $author->country, $author->organization);
            }

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function deleteattendee()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];

        $attendee_id = $postdata['attendee_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Attendee->removeattendee($attendee_id);
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

        $attendee_id = $postdata['attendee_id'];
        $attendeefirstname = $postdata['attendeefirstname'];
        $lastname = $postdata['lastname'];
        $email = $postdata['email'];
        $country = $postdata['country'];
        $organization = $postdata['organization'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Attendee->update($attendee_id, $attendeefirstname, $lastname, $email, $country, $organization);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function accept()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $attendee_id = $postdata['attendee_id'];
        $is_accept = $postdata['is_accept'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $this->Attendee->accept($attendee_id, $is_accept);

            if ($is_accept == 'Yes') {
                $email = $this->Attendee->getEmailById($attendee_id);
                $this->email->from('jerrychangcn@163.com', 'GEG2018');
                $this->email->to($email);
                $this->email->subject('GEG2018: Registration message');
                $this->email->message('<h3>Dear ' . $firstname . '</h3><p>Your conference registration is successful!</p><p>Thank you for your cooperation!</p><p>Hope to see you in Shanghai!</p><h3>Sincerely,<br/>2018 GEG Conference Organizing Committee </h3>');
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
        $attendee_id = $postdata['attendee_id'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $config['upload_path'] = './application/uploads/attendee/';
            $config['allowed_types'] = 'zip|pdf|jpg|png';
            $config['file_name'] = $attendee_id;
            $config['file_ext_tolower'] = TRUE;
            $config['overwrite'] = true;
            $config['max_size'] = '10240';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output($this->upload->display_errors('', ''));
            } else {
                if (empty($this->Attendee->getFileById($attendee_id))) {
                    $sum = $this->Attendee->getPercentageByid($attendee_id);
                    $this->Attendee->addPercentageByid($attendee_id, $sum + 50);
                }
                $percentage = $this->Attendee->getPercentageByid($attendee_id);
                $filename = $this->upload->data()['file_name'];
                $this->Attendee->upload($attendee_id, $filename);
                $this->output
                    ->set_output(json_encode(array('status' => false, 'percentage' => $percentage)));
            }
            return;
        }
    }

    public function attendee()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['index'] = $this->Attendee->index($user_id);
            $data['addindex'] = $this->Paper->addindex($user_id);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function adminattendee()
    {
        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $currentPage = $postdata['currentPage'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['total'] = $this->Attendee->adminindextotal();
            $data['index'] = $this->Attendee->adminindex($currentPage);
            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }

    public function searchattendee()
    {

        $postdata = $this->input->post();
        $user_id = $postdata['id'];
        $firstname = $postdata['firstname'];
        $currentPage = $postdata['currentPage'];
        $status = $postdata['status'];
        $keywords = $postdata['keywords'];

        $s_id = $this->session->userdata('id');
        $s_firstname = $this->session->userdata('firstname');

        if ($user_id == $s_id && $firstname == $s_firstname) {
            $data['total'] = $this->Attendee->adminsearchtotal($status, $keywords);
            $data['index'] = $this->Attendee->adminsearch($currentPage, $status, $keywords);
            $data['status'] = true;
            echo json_encode($data);
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

            force_download('./application/uploads/attendee/' . $file, NULL);

            $data['status'] = true;
            echo json_encode($data);
            return;
        }
    }
}
