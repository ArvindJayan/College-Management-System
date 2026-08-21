<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teacher_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function profile_exists($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('teachers') > 0;
    }

    public function create_teacher($data) {
        return $this->db->insert('teachers', $data);
    }

    public function get_teacher_by_id($id) {
        $this->db->select('teachers.*, users.name, users.email');
        $this->db->from('teachers');
        $this->db->join('users', 'users.id = teachers.user_id');
        $this->db->where('teachers.id', $id);
        return $this->db->get()->row();
    }

    public function get_all_teachers($search = NULL, $specialty = NULL) {
        $this->db->select('teachers.*, users.name, users.email');
        $this->db->from('teachers');
        $this->db->join('users', 'users.id = teachers.user_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('teachers.specialization', $search);
            $this->db->group_end();
        }

        if (!empty($specialty)) {
            $this->db->where('teachers.specialization', $specialty);
        }

        $this->db->order_by('users.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_specializations() {
        $this->db->select('specialization');
        $this->db->distinct();
        $this->db->from('teachers');
        $this->db->where('specialization IS NOT NULL');
        $this->db->where('specialization !=', '');
        $this->db->order_by('specialization', 'ASC');
        $query = $this->db->get();
        
        return array_column($query->result_array(), 'specialization');
    }

    public function get_teacher_count() {
        return $this->db->count_all('teachers');
    }

    public function update_teacher($id, $teacher_data, $user_data = []) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('teachers', $teacher_data);

        if (!empty($user_data)) {
            $teacher = $this->get_teacher_by_id($id);
            if ($teacher) {
                $this->db->where('id', $teacher->user_id);
                $this->db->update('users', $user_data);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}