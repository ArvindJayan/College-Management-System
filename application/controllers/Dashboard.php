<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->model('Teacher_model');
        $this->load->model('Student_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $role_id = (int) $this->session->userdata('role_id');

        if ($role_id === 1) {
            $this->_show_dashboard();
            return;
        }

        if ($role_id === 2) {
            $this->_show_dashboard();
            return;
        }

        if ($role_id === 3) {

            if (!$this->Teacher_model->profile_exists($user_id)) {
                redirect('/onboarding');
                return;
            }

            $this->_show_dashboard();
            return;
        }

        if ($role_id === 4) {

            if (!$this->Student_model->profile_exists($user_id)) {
                redirect('/onboarding');
                return;
            }

            $this->_show_dashboard();
            return;
        }

        $this->session->sess_destroy();

        redirect('/auth/login');
    }

    private function _show_dashboard()
    {
        $data['name'] = $this->session->userdata('name');
        $data['role_id'] = (int) $this->session->userdata('role_id');

        $this->load->view('dashboard/index', $data);
    }
}