<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Audit_model');

        if (!$this->session->userdata('is_authenticated')) {

            redirect('auth/login');

            return;
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id !== 1) {

            $this->session->set_flashdata(
                'error',
                'Access denied. Only Principals can view audit logs.'
            );

            redirect('dashboard');

            return;
        }
    }

    public function index()
    {
        $data['logs'] = $this->Audit_model->get_all_logs();

        $this->load->view(
            'audit/index',
            $data
        );
    }
}