<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');
        $this->load->model('Department_model');
    }

    public function index()
    {
        $data['departments'] = $this->Department_model->get_all_departments();

        $this->load->view('departments/index', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules(
            'name',
            'Department Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'code',
            'Department Code',
            'required|trim|max_length[20]'
        );

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('departments/create');

            return;
        }

        $name = $this->input->post('name', TRUE);
        $code = $this->input->post('code', TRUE);

        if ($this->Department_model->name_exists($name)) {
            $this->session->set_flashdata(
                'error',
                'A department with this name already exists.'
            );

            redirect('/departments/create');
        }

        if ($this->Department_model->code_exists($code)) {
            $this->session->set_flashdata(
                'error',
                'A department with this code already exists.'
            );

            redirect('/departments/create');
        }

        $data = array(
            'name' => $name,
            'code' => $code
        );

        if ($this->Department_model->create_department($data)) {

            $this->session->set_flashdata(
                'success',
                'Department created successfully.'
            );

            redirect('/departments');
        }

        $this->session->set_flashdata(
            'error',
            'Unable to create department.'
        );

        redirect('/departments/create');
    }

    public function edit($id)
    {
        $department = $this->Department_model->get_department($id);

        if (!$department) {
            show_404();
        }

        $this->form_validation->set_rules(
            'name',
            'Department Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'code',
            'Department Code',
            'required|trim|max_length[20]'
        );

        if ($this->form_validation->run() === FALSE) {

            $data['department'] = $department;

            $this->load->view('departments/edit', $data);

            return;
        }

        $name = $this->input->post('name', TRUE);
        $code = $this->input->post('code', TRUE);

        if ($this->Department_model->name_exists($name, $id)) {
            $this->session->set_flashdata(
                'error',
                'A department with this name already exists.'
            );

            redirect('/departments/edit/' . $id);
        }

        if ($this->Department_model->code_exists($code, $id)) {
            $this->session->set_flashdata(
                'error',
                'A department with this code already exists.'
            );

            redirect('/departments/edit/' . $id);
        }

        $data = array(
            'name' => $name,
            'code' => $code
        );

        if ($this->Department_model->update_department($id, $data)) {

            $this->session->set_flashdata(
                'success',
                'Department updated successfully.'
            );

            redirect('/departments');
        }

        $this->session->set_flashdata(
            'error',
            'Unable to update department.'
        );

        redirect('/departments/edit/' . $id);
    }

    public function delete($id)
    {
        $department = $this->Department_model->get_department($id);

        if (!$department) {
            show_404();
        }

        if ($this->Department_model->delete_department($id)) {

            $this->session->set_flashdata(
                'success',
                'Department deleted successfully.'
            );
        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to delete department.'
            );
        }

        redirect('/departments');
    }
}