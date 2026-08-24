<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model
{
    protected $table = 'courses';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_courses()
    {
        return $this->db
            ->select(
                'courses.*,
                 departments.name AS department_name,
                 departments.code AS department_code'
            )
            ->from('courses')
            ->join(
                'departments',
                'departments.id = courses.department_id',
                'left'
            )
            ->order_by('courses.name', 'ASC')
            ->get()
            ->result();
    }

    public function get_course($id)
    {
        return $this->db
            ->select(
                'courses.*,
                 departments.name AS department_name,
                 departments.code AS department_code'
            )
            ->from('courses')
            ->join(
                'departments',
                'departments.id = courses.department_id',
                'left'
            )
            ->where('courses.id', $id)
            ->get()
            ->row();
    }

    public function get_student_course($user_id)
    {
        return $this->db
            ->select(
                'courses.*,
                 departments.name AS department_name,
                 departments.code AS department_code'
            )
            ->from('students')
            ->join(
                'courses',
                'courses.id = students.course_id'
            )
            ->join(
                'departments',
                'departments.id = courses.department_id'
            )
            ->where('students.user_id', $user_id)
            ->get()
            ->row();
    }

    public function create_course($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_course($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete_course($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    public function name_exists($name, $exclude_id = NULL)
    {
        $this->db->where('name', $name);

        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    public function code_exists($code, $exclude_id = NULL)
    {
        $this->db->where('code', $code);

        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
    }
}