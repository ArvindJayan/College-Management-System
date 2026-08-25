<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function register()
    {
        if ($this->session->userdata('is_authenticated')) {
            $this->_redirect_authenticated_user();
            return;
        }

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric|callback_valid_role');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            try {
                $data['roles'] = $this->User_model->get_non_admin_roles();
                $this->load->view('auth/register', $data);
            } catch (Exception $e) {
                log_message('error', 'Registration error: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                redirect('auth/register');
            }
            return;
        }

        $selected_role_id = (int) $this->input->post('role_id', TRUE);

        $user_data = array(
            'name' => $this->input->post('name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'role_id' => $selected_role_id,
            'password' => $this->input->post('password', TRUE)
        );

        try {
            $new_user_id = $this->User_model->register_user($user_data);

            if (!$new_user_id) {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                redirect('auth/register');
                return;
            }

            $registered_user = $this->User_model->get_user_by_id($new_user_id);

            if (!$registered_user) {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                redirect('auth/register');
                return;
            }

            $session_data = array(
                'user_id' => $registered_user->id,
                'name' => $registered_user->name,
                'email' => $registered_user->email,
                'role_id' => $registered_user->role_id,
                'role_name' => $registered_user->role_name,
                'is_authenticated' => TRUE
            );

            $this->session->set_userdata($session_data);
            $this->session->set_flashdata('success', 'Account created successfully');
            redirect('dashboard');
        } catch (Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
            redirect('auth/register');
        }
    }

    public function login()
    {
        if ($this->session->userdata('is_authenticated')) {
            redirect('dashboard');
            return;
        }

        if (!$this->input->post()) {
            $this->load->view('auth/login');
            return;
        }

        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);

        try {
            $user = $this->User_model->login($email, $password);

            if (!$user) {
                $this->session->set_flashdata('error', 'Invalid email or password.');
                redirect('auth/login');
                return;
            }

            $session_data = array(
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role_name,
                'is_authenticated' => TRUE
            );

            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } catch (Exception $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
            redirect('auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function valid_role($role_id)
    {
        if ($role_id == 1) {
            $this->session->set_flashdata('error', 'Principal registration is restricted.');            return FALSE;
        }

        if (!$this->User_model->role_exists($role_id)) {
            $this->session->set_flashdata('error', 'Invalid role selected.');
            return FALSE;
        }

        return TRUE;
    }

    private function _redirect_authenticated_user()
    {
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');

        $this->load->model('Teacher_model');
        $this->load->model('Student_model');

        if ($role_id == 1) {
            redirect('dashboard');
        } else if ($role_id == 2 || $role_id == 3) {
            if ($this->Teacher_model->profile_exists($user_id)) {
                redirect('dashboard');
            } else {
                redirect('onboarding');
            }
        } else if ($role_id == 4) {
            if ($this->Student_model->profile_exists($user_id)) {
                redirect('dashboard');
            } else {
                redirect('onboarding');
            }
        } else {
            redirect('auth/login');
        }
    }
}