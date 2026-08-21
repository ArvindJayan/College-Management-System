<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function register() {
        if ($this->session->userdata('is_authenticated')) {
            $this->_redirect_authenticated_user();
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data['roles'] = $this->User_model->get_non_admin_roles();
            $this->load->view('auth/register', $data);
        } else {
            $selected_role_id = (int)$this->input->post('role_id', TRUE);

            if ($selected_role_id === 1) {
                $this->session->set_flashdata('error', 'Principal registration is restricted.');
                redirect('auth/register');
                return;
            }

            $user_data = array(
                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'role_id' => $selected_role_id,
                'password' => $this->input->post('password', TRUE),
            );

            $new_user_id = $this->User_model->register_user($user_data);

            if ($new_user_id) {
                $registered_user = $this->User_model->get_user_by_id($new_user_id);
                
                $session_data = array(
                    'user_id'          => $registered_user->id,
                    'username'             => $registered_user->username,
                    'email'            => $registered_user->email,
                    'role_id'          => $registered_user->role_id,
                    'is_authenticated' => TRUE
                );

                $this->session->set_userdata($session_data);

                $this->session->set_flashdata('success', 'Account created successfully');
                redirect('onboarding');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
                redirect('auth/register');
            }     
        }
    }

    public function login() {
        if ($this->session->userdata('is_authenticated')) {
            $this->_redirect_authenticated_user();
            return;
        }

        if ( ! $this->input->post()) {
            $this->load->view('auth/login');
            return;
        }
        $email    = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);
        $user     = $this->User_model->login($email, $password);

        if ($user) {
            $session_data = array(
                'user_id'          => $user->id,
                'username'             => $user->username,
                'email'            => $user->email,
                'role_id'          => $user->role_id,
                'role_name'        => $user->role_name,
                'is_authenticated' => TRUE
            );
            $this->session->set_userdata($session_data);

            $this->_redirect_authenticated_user();
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('auth/login');
        }
    }
}
