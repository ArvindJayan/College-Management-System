<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboarding extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');

        $this->load->model('Teacher_model');
        $this->load->model('Student_model');
        $this->load->model('Department_model');
        $this->load->model('Course_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $role_id = (int) $this->session->userdata('role_id');


        if ($role_id === 1) {
            redirect('/dashboard');
        }

        if ($role_id === 2) {
            redirect('/dashboard');
        }


        if ($role_id === 3) {

            if ($this->Teacher_model->profile_exists($user_id)) {
                redirect('/dashboard');
            }

            $this->_handle_teacher_onboarding($user_id);

            return;
        }

        if ($role_id === 4) {

            if ($this->Student_model->profile_exists($user_id)) {
                redirect('/dashboard');
            }

            $this->_handle_student_onboarding($user_id);

            return;
        }

        redirect('/dashboard');
    }

    private function _handle_teacher_onboarding($user_id)
    {
        $this->form_validation->set_rules(
            'employee_code',
            'Employee Code',
            'required|trim|max_length[20]|is_unique[teachers.employee_code]'
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

        if ($this->form_validation->run() === FALSE) {

            $data = array(
                'role_id'     => 3,
                'departments' => $this->Department_model->get_all_departments()
            );

            $this->load->view('onboarding/index', $data);

            return;
        }

        $teacher_data = array(
            'user_id'       => $user_id,
            'department_id' => $this->input->post('department_id', TRUE),
            'employee_code' => $this->input->post('employee_code', TRUE),
            'first_name'    => $this->input->post('first_name', TRUE),
            'last_name'     => $this->input->post('last_name', TRUE),
            'phone'         => $this->input->post('phone', TRUE),
            'joining_date'  => $this->input->post('joining_date', TRUE)
        );

        if ($this->Teacher_model->create_teacher($teacher_data)) {

            $this->session->set_flashdata(
                'success',
                'Teacher profile completed!'
            );

            redirect('/dashboard');

            return;
        }

        $data = array(
            'role_id'     => 3,
            'departments' => $this->Department_model->get_all_departments()
        );

        $this->session->set_flashdata(
            'error',
            'Unable to complete teacher profile. Please try again.'
        );

        $this->load->view('onboarding/index', $data);
    }

    private function _handle_student_onboarding($user_id)
    {
        $this->form_validation->set_rules(
            'student_code',
            'Student Code',
            'required|trim|max_length[20]|is_unique[students.student_code]'
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

        if ($this->form_validation->run() === FALSE) {

            $data = array(
                'role_id' => 4,
                'courses' => $this->Course_model->get_all_courses()
            );

            $this->load->view('onboarding/index', $data);

            return;
        }

        $student_data = array(
            'user_id'        => $user_id,
            'course_id'      => $this->input->post('course_id', TRUE),
            'student_code'   => $this->input->post('student_code', TRUE),
            'dob'            => $this->input->post('dob', TRUE),
            'gender'         => $this->input->post('gender', TRUE),
            'phone'          => $this->input->post('phone', TRUE),
            'admission_date' => $this->input->post('admission_date', TRUE)
        );

        if ($this->Student_model->create_student($student_data)) {

            $this->session->set_flashdata(
                'success',
                'Student profile completed!'
            );

            redirect('/dashboard');

            return;
        }

        $data = array(
            'role_id' => 4,
            'courses' => $this->Course_model->get_all_courses()
        );

        $this->session->set_flashdata(
            'error',
            'Unable to complete student profile. Please try again.'
        );

        $this->load->view('onboarding/index', $data);
    }
}