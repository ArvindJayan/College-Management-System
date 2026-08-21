<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }
    }

    public function index() {
        $data['name']      = $this->session->userdata('name');
        $data['role_id']   = $this->session->userdata('role_id');

        $this->load->view('dashboard/index', $data);
    }
}