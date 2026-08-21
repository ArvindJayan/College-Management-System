<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_course($data) {
        return $this->db->insert('courses', $data);
    }

    public function get_course_by_id($id) {
        $this->db->select('
            courses.*,
            departments.name as department_name,
            departments.code as department_code
        ');
        $this->db->from('courses');
        $this->db->join(
            'departments',
            'departments.id = courses.department_id'
        );
        $this->db->where('courses.id', $id);

        return $this->db->get()->row();
    }

    public function get_all_courses($search = NULL, $department_id = NULL) {

        $this->db->select('
            courses.*,
            departments.name as department_name,
            departments.code as department_code
        ');

        $this->db->from('courses');

        $this->db->join(
            'departments',
            'departments.id = courses.department_id'
        );

        if (!empty($search)) {

            $this->db->group_start();

            $this->db->like('courses.name', $search);
            $this->db->or_like('courses.code', $search);
            $this->db->or_like('departments.name', $search);
            $this->db->or_like('departments.code', $search);

            $this->db->group_end();
        }

        if (!empty($department_id)) {
            $this->db->where(
                'courses.department_id',
                $department_id
            );
        }

        $this->db->order_by('courses.name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_course_count() {
        return $this->db->count_all('courses');
    }

    public function update_course($id, $data) {

        $this->db->where('id', $id);

        return $this->db->update('courses', $data);
    }

    public function delete_course($id) {

        $this->db->where('id', $id);

        return $this->db->delete('courses');
    }
}