<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function register_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);   
        if ($this->db->insert('users', $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function login($email, $password) {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = user.role_id');
        $this->db->where('users.email', $email);
        $query = $this->db->get();

        if(password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }

    public function get_user_by_id($id) {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }
}
?>