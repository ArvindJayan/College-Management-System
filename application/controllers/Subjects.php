<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->model('Subject_model');
    }

    public function index()
    {
        $user_id = (int) $this->session->userdata('user_id');

        $data['subjects'] =
            $this->Subject_model->get_student_subjects($user_id);

        $this->load->view('subjects/index', $data);
    }
}