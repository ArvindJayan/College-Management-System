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
        $per_page = 10;

        $page = (int)$this->input->get('page');

        if ($page < 1) {
            $page = 1;
        }

        $total_logs = $this->Audit_model->get_log_count();

        $total_pages = (int)ceil(
            $total_logs / $per_page
        );

        if ($total_pages > 0 && $page > $total_pages) {
            $page = $total_pages;
        }

        $offset = ($page - 1) * $per_page;

        $data['logs'] = $this->Audit_model->get_logs(
            $per_page,
            $offset
        );

        $data['total_logs'] = $total_logs;
        $data['current_page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['per_page'] = $per_page;

        $this->load->view(
            'audit/index',
            $data
        );
    }
}