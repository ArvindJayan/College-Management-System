<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');

        $this->load->model('Course_model');
        $this->load->model('Department_model');
    }

    private function require_principal()
    {
        if ((int) $this->session->userdata('role_id') !== 1) {
            show_error(
                'You are not authorized to perform this action.',
                403
            );
        }
    }

    public function index()
    {
        $data['courses'] =
            $this->Course_model->get_all_courses();

        $role_id =
            (int) $this->session->userdata('role_id');

        /*
         * Only students need their enrolled course.
         * Role ID 4 = student.
         */
        if ($role_id === 4) {

            $user_id =
                (int) $this->session->userdata('user_id');

            $data['student_course'] =
                $this->Course_model->get_student_course($user_id);
        }

        $this->load->view('courses/index', $data);
    }

    public function create()
    {
        $this->require_principal();

        $this->form_validation->set_rules(
            'department_id',
            'Department',
            'required|integer'
        );

        $this->form_validation->set_rules(
            'name',
            'Course Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'code',
            'Course Code',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'duration_years',
            'Duration',
            'required|integer|greater_than[0]|less_than_equal_to[255]'
        );

        if ($this->form_validation->run() === FALSE) {

            $data['departments'] =
                $this->Department_model->get_all_departments();

            $this->load->view(
                'courses/create',
                $data
            );

            return;
        }

        $name =
            $this->input->post('name', TRUE);

        $code =
            $this->input->post('code', TRUE);

        if ($this->Course_model->name_exists($name)) {

            $this->session->set_flashdata(
                'error',
                'A course with this name already exists.'
            );

            redirect('/courses/create');

            return;
        }

        if ($this->Course_model->code_exists($code)) {

            $this->session->set_flashdata(
                'error',
                'A course with this code already exists.'
            );

            redirect('/courses/create');

            return;
        }

        $course_data = array(
            'department_id' => $this->input->post(
                'department_id',
                TRUE
            ),

            'name' => $name,

            'code' => $code,

            'duration_years' => $this->input->post(
                'duration_years',
                TRUE
            )
        );

        if ($this->Course_model->create_course($course_data)) {

            $this->session->set_flashdata(
                'success',
                'Course created successfully.'
            );

            redirect('/courses');

            return;
        }

        $this->session->set_flashdata(
            'error',
            'Unable to create course.'
        );

        redirect('/courses/create');
    }

    public function edit($id)
    {
        $this->require_principal();

        $course =
            $this->Course_model->get_course($id);

        if (!$course) {
            show_404();
        }

        $this->form_validation->set_rules(
            'department_id',
            'Department',
            'required|integer'
        );

        $this->form_validation->set_rules(
            'name',
            'Course Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'code',
            'Course Code',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'duration_years',
            'Duration',
            'required|integer|greater_than[0]|less_than_equal_to[255]'
        );

        if ($this->form_validation->run() === FALSE) {

            $data['course'] =
                $course;

            $data['departments'] =
                $this->Department_model->get_all_departments();

            $this->load->view(
                'courses/edit',
                $data
            );

            return;
        }

        $name =
            $this->input->post('name', TRUE);

        $code =
            $this->input->post('code', TRUE);

        if (
            $this->Course_model->name_exists(
                $name,
                $id
            )
        ) {

            $this->session->set_flashdata(
                'error',
                'A course with this name already exists.'
            );

            redirect('/courses/edit/' . $id);

            return;
        }

        if (
            $this->Course_model->code_exists(
                $code,
                $id
            )
        ) {

            $this->session->set_flashdata(
                'error',
                'A course with this code already exists.'
            );

            redirect('/courses/edit/' . $id);

            return;
        }

        $course_data = array(
            'department_id' => $this->input->post(
                'department_id',
                TRUE
            ),

            'name' => $name,

            'code' => $code,

            'duration_years' => $this->input->post(
                'duration_years',
                TRUE
            )
        );

        if (
            $this->Course_model->update_course(
                $id,
                $course_data
            )
        ) {

            $this->session->set_flashdata(
                'success',
                'Course updated successfully.'
            );

            redirect('/courses');

            return;
        }

        $this->session->set_flashdata(
            'error',
            'Unable to update course.'
        );

        redirect('/courses/edit/' . $id);
    }

    public function delete($id)
    {
        $this->require_principal();

        $course =
            $this->Course_model->get_course($id);

        if (!$course) {
            show_404();
        }

        if (
            $this->Course_model->delete_course($id)
        ) {

            $this->session->set_flashdata(
                'success',
                'Course deleted successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to delete course. The course may already be in use.'
            );
        }

        redirect('/courses');
    }
}