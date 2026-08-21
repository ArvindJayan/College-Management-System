<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Teacher_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 3) {
            $this->session->set_flashdata(
                'error',
                'Access denied. Teachers cannot access teacher directory management.'
            );
            redirect('dashboard');
        }
    }

    public function index() {

        $search       = $this->input->get('search', TRUE);
        $department_id = $this->input->get('department_id', TRUE);

        $data['search'] = $search;
        $data['department_id'] = $department_id;

        $data['departments'] = $this->Teacher_model->get_departments();

        $data['teachers'] = $this->Teacher_model->get_all_teachers(
            $search,
            $department_id
        );

        $this->load->view('teachers/index', $data);
    }

    public function view_ajax($id) {

        $teacher = $this->Teacher_model->get_teacher_by_id($id);

        if ($teacher) {

            echo json_encode([
                'status' => 'success',
                'data'   => $teacher
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Teacher record not found.'
            ]);
        }
    }

    public function edit($id) {
        if ((int)$this->session->userdata('role_id') !== 1) {

            $this->session->set_flashdata(
                'error',
                'Only Principals can edit teacher records.'
            );

            redirect('teachers');
        }

        $teacher = $this->Teacher_model->get_teacher_by_id($id);

        if (!$teacher) {

            $this->session->set_flashdata(
                'error',
                'Teacher not found.'
            );

            redirect('teachers');
        }

        $this->form_validation->set_rules(
            'name',
            'Full Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'employee_code',
            'Employee Code',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'department_id',
            'Department',
            'required|integer'
        );

        $this->form_validation->set_rules(
            'first_name',
            'First Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'last_name',
            'Last Name',
            'trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'phone',
            'Phone Number',
            'trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'joining_date',
            'Joining Date',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $data['teacher'] = $teacher;
            $data['departments'] = $this->Teacher_model->get_departments();

            $this->load->view('teachers/edit', $data);

        } else {

            $teacher_data = [
                'employee_code' => $this->input->post('employee_code', TRUE),
                'department_id' => $this->input->post('department_id', TRUE),
                'first_name'    => $this->input->post('first_name', TRUE),
                'last_name'     => $this->input->post('last_name', TRUE),
                'phone'         => $this->input->post('phone', TRUE),
                'joining_date'  => $this->input->post('joining_date', TRUE)
            ];
            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->Teacher_model->update_teacher(
                $id,
                $teacher_data,
                $user_data
            )) {

                $this->session->set_flashdata(
                    'success',
                    'Teacher profile updated successfully.'
                );

            } else {

                $this->session->set_flashdata(
                    'error',
                    'Failed to update teacher profile.'
                );
            }

            redirect('teachers');
        }
    }
}


