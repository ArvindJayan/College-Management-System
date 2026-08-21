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
}
?>