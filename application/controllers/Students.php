<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('student_model');
        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 3) {
            $this->session->set_flashdata('error', 'Access denied. students cannot access student management.');
            redirect('dashboard');
        }
    }

    public function index() {
        $search = $this->input->get('search', TRUE);
        $data['search']   = $search;
        $data['students'] = $this->student_model->get_all_students($search);

        $this->load->view('students/index', $data);
    }

    public function view_ajax($id) {
        $student = $this->student_model->get_student_by_id($id);
        if ($student) {
            // Calculate age dynamically
            $dob = new DateTime($student->dob);
            $now = new DateTime();
            $student->age = $dob->diff($now)->y;

            echo json_encode(['status' => 'success', 'data' => $student]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'student record not found.']);
        }
    }

    public function edit($id) {
        $student = $this->student_model->get_student_by_id($id);

        if (!$student) {
            $this->session->set_flashdata('error', 'student not found.');
            redirect('students');
        }

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['student'] = $student;
            $this->load->view('students/edit', $data);
        } else {
            $student_data = [
                'phone'  => $this->input->post('phone', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'dob'    => $this->input->post('dob', TRUE)
            ];

            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->student_model->update_student($id, $student_data, $user_data)) {
                $this->session->set_flashdata('success', 'student profile updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update student profile.');
            }

            redirect('students');
        }
    }
}