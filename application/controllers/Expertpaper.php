<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Expertpaper
 */
class Expertpaper extends CI_Controller
{
    /**
     * Expertpaper constructor.
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
            $this->load->view('expertpaper.html', $data);
            return;
        } elseif ($this->session->userdata('id') == 2) {
            redirect('/adminpaper/index');
            return;
        } else {
            redirect('/home/index');
            return;
        }
    }
}
