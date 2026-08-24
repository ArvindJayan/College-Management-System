<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');

        $this->load->model('User_model');
    }

    public function index()
    {
        $user_id =
            (int) $this->session->userdata('user_id');

        $data['user'] =
            $this->User_model->get_profile($user_id);

        if (!$data['user']) {
            show_404();
        }

        $this->load->view(
            'profile/index',
            $data
        );
    }

    public function edit()
    {
        $user_id =
            (int) $this->session->userdata('user_id');

        $user =
            $this->User_model->get_profile($user_id);

        if (!$user) {
            show_404();
        }

        $this->form_validation->set_rules(
            'name',
            'Full Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'email',
            'Email Address',
            'required|trim|valid_email|max_length[100]'
        );


        if ($user->student) {

            $this->form_validation->set_rules(
                'dob',
                'Date of Birth',
                'trim'
            );

            $this->form_validation->set_rules(
                'gender',
                'Gender',
                'trim|in_list[male,female,other]'
            );

            $this->form_validation->set_rules(
                'phone',
                'Phone',
                'trim|max_length[20]'
            );
        }

        if ($user->teacher) {

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
                'teacher_phone',
                'Phone',
                'trim|max_length[20]'
            );
        }

        if ($this->form_validation->run() === FALSE) {

            $data['user'] = $user;

            $this->load->view(
                'profile/edit',
                $data
            );

            return;
        }

        $name =
            $this->input->post(
                'name',
                TRUE
            );

        $email =
            $this->input->post(
                'email',
                TRUE
            );

        if (
            $this->User_model->email_exists(
                $email,
                $user_id
            )
        ) {

            $this->session->set_flashdata(
                'error',
                'An account with this email address already exists.'
            );

            redirect('/profile/edit');

            return;
        }

        $user_data = array(
            'name' => $name,
            'email' => $email
        );


        if ($user->student) {

            $student_data = array(
                'dob' => $this->input->post(
                    'dob',
                    TRUE
                ) ?: NULL,

                'gender' => $this->input->post(
                    'gender',
                    TRUE
                ) ?: NULL,

                'phone' => $this->input->post(
                    'phone',
                    TRUE
                ) ?: NULL
            );
        }

        if ($user->teacher) {

            $teacher_data = array(
                'first_name' => $this->input->post(
                    'first_name',
                    TRUE
                ),

                'last_name' => $this->input->post(
                    'last_name',
                    TRUE
                ) ?: NULL,

                'phone' => $this->input->post(
                    'teacher_phone',
                    TRUE
                ) ?: NULL
            );
        }

        $this->db->trans_start();

        $this->User_model->update_user(
            $user_id,
            $user_data
        );

        if ($user->student) {

            $this->User_model->update_student(
                $user_id,
                $student_data
            );
        }

        if ($user->teacher) {

            $this->User_model->update_teacher(
                $user_id,
                $teacher_data
            );
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->session->set_flashdata(
                'error',
                'Unable to update your profile.'
            );

            redirect('/profile/edit');

            return;
        }


        $this->session->set_userdata(
            'name',
            $name
        );

        $this->session->set_flashdata(
            'success',
            'Your profile has been updated successfully.'
        );

        redirect('/profile');
    }
}