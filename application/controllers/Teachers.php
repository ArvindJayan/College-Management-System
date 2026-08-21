<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teachers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('teacher_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 2) {
            $this->session->set_flashdata('error', 'Access denied. teachers cannot access teacher directory management.');
            redirect('dashboard');
        }
    }

    public function index() {
        $search    = $this->input->get('search', TRUE);
        $specialty = $this->input->get('specialty', TRUE);

        $data['search']          = $search;
        $data['specialty']       = $specialty;
        $data['specializations'] = $this->teacher_model->get_specializations();
        $data['teachers']         = $this->teacher_model->get_all_teachers($search, $specialty);

        $this->load->view('teachers/index', $data);
    }

    public function view_ajax($id) {
        $teacher = $this->teacher_model->get_teacher_by_id($id);
        if ($teacher) {
            echo json_encode(['status' => 'success', 'data' => $teacher]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'teacher record not found.']);
        }
    }

    public function edit($id) {
        if ((int)$this->session->userdata('role_id') !== 1) {
            $this->session->set_flashdata('error', 'Only System Administrators can edit teacher records.');
            redirect('teachers');
        }

        $teacher = $this->teacher_model->get_teacher_by_id($id);

        if (!$teacher) {
            $this->session->set_flashdata('error', 'teacher not found.');
            redirect('teachers');
        }

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('specialization', 'Specialization', 'required|trim');
        $this->form_validation->set_rules('consultation_fee', 'Consultation Fee', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['teacher'] = $teacher;
            $this->load->view('teachers/edit', $data);
        } else {
            $teacher_data = [
                'specialization'   => $this->input->post('specialization', TRUE),
                'fee' => $this->input->post('consultation_fee', TRUE)
            ];

            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->teacher_model->update_teacher($id, $teacher_data, $user_data)) {
                $this->session->set_flashdata('success', 'teacher profile updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update teacher profile.');
            }

            redirect('teachers');
        }
    }
}