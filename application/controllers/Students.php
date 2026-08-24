<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Student_model');

        if (!$this->session->userdata('is_authenticated')) {
            redirect('auth/login');
        }

        $role_id = (int)$this->session->userdata('role_id');

        if ($role_id === 4) {
            $this->session->set_flashdata(
                'error',
                'Access denied. Students cannot access student directory management.'
            );
            redirect('dashboard');
        }
    }

    public function index() {

        $search = $this->input->get('search', TRUE);
        $course_id = $this->input->get('course_id', TRUE);

        $data['search'] = $search;
        $data['course_id'] = $course_id;

        $this->load->model('Course_model');

        $data['courses'] = $this->Course_model->get_all_courses();

        $data['students'] = $this->Student_model->get_all_students(
            $search
        );

        if (!empty($course_id)) {

            $filtered_students = [];

            foreach ($data['students'] as $student) {

                if ((int)$student->course_id === (int)$course_id) {
                    $filtered_students[] = $student;
                }
            }

            $data['students'] = $filtered_students;
        }

        $this->load->view('students/index', $data);
    }

    public function view_ajax($id) {

        $student = $this->Student_model->get_student_by_id($id);

        if ($student) {

            echo json_encode([
                'status' => 'success',
                'data'   => $student
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Student record not found.'
            ]);
        }
    }

    public function edit($id) {
        if ((int)$this->session->userdata('role_id') !== 1) {

            $this->session->set_flashdata(
                'error',
                'Only Principals can edit student records.'
            );

            redirect('students');
        }

        $student = $this->Student_model->get_student_by_id($id);

        if (!$student) {

            $this->session->set_flashdata(
                'error',
                'Student not found.'
            );

            redirect('students');
        }

        $this->form_validation->set_rules(
            'name',
            'Full Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'student_code',
            'Student Code',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'course_id',
            'Course',
            'required|integer'
        );

        $this->form_validation->set_rules(
            'dob',
            'Date of Birth',
            'required'
        );

        $this->form_validation->set_rules(
            'gender',
            'Gender',
            'required|in_list[male,female,other]'
        );

        $this->form_validation->set_rules(
            'phone',
            'Phone Number',
            'trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'admission_date',
            'Admission Date',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $data['student'] = $student;

            $this->load->model('Course_model');
            $data['courses'] = $this->Course_model->get_all_courses();

            $this->load->view('students/edit', $data);

        } else {

            $student_data = [
                'student_code'   => $this->input->post('student_code', TRUE),
                'course_id'      => $this->input->post('course_id', TRUE),
                'dob'            => $this->input->post('dob', TRUE),
                'gender'         => $this->input->post('gender', TRUE),
                'phone'          => $this->input->post('phone', TRUE),
                'admission_date' => $this->input->post('admission_date', TRUE)
            ];

            $user_data = [
                'name' => $this->input->post('name', TRUE)
            ];

            if ($this->Student_model->update_student(
                $id,
                $student_data,
                $user_data,
                (int)$this->session->userdata('user_id')
            )) {

                $this->session->set_flashdata(
                    'success',
                    'Student profile updated successfully.'
                );

            } else {

                $this->session->set_flashdata(
                    'error',
                    'Failed to update student profile.'
                );
            }

            redirect('students');
        }
    }

    public function change_status($id) {
        if ((int)$this->session->userdata('role_id') !== 1) {

            $this->session->set_flashdata(
                'error',
                'Only Principals can change student status.'
            );

            redirect('students');
            return;
        }

        if (!$this->input->post()) {

            $this->session->set_flashdata(
                'error',
                'Invalid request.'
            );

            redirect('students');
            return;
        }

        $status = $this->input->post('status', TRUE);

        if (!in_array($status, ['active', 'inactive'], TRUE)) {

            $this->session->set_flashdata(
                'error',
                'Invalid status.'
            );

            redirect('students');
            return;
        }

        $actor_user_id =
            (int)$this->session->userdata('user_id');

        $result = $this->Student_model->change_status(
            $id,
            $status,
            $actor_user_id
        );

        if ($result) {

            $message = $status === 'active'
                ? 'Student activated successfully.'
                : 'Student deactivated successfully.';

            $this->session->set_flashdata(
                'success',
                $message
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Failed to change student status.'
            );
        }

        redirect('students');
    }
}