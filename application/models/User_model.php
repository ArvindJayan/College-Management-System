<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register_user($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        if (!$this->db->insert('users', $data)) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return $this->db->insert_id();
    }

    public function login($email, $password)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.email', $email);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $user = $query->row();

            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return FALSE;
    }

    public function get_user_by_id($id)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.id', $id);

        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return $query->row();
    }

    public function get_non_admin_roles()
    {
        $this->db->where('id !=', 1);

        $query = $this->db->get('roles');

        if (!$query) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return $query->result();
    }

    public function get_profile($user_id)
    {
        $user = $this->db
            ->select('users.id, users.name, users.email, users.status, users.created_at, users.updated_at, roles.name AS role_name')
            ->from('users')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $user_id)
            ->get()
            ->row();

        if (!$user) {
            return NULL;
        }

        $student = $this->db
            ->select('students.id AS student_id, students.student_code, students.dob, students.gender, students.phone, students.admission_date, courses.name AS course_name, courses.code AS course_code, departments.name AS department_name, departments.code AS department_code')
            ->from('students')
            ->join('courses', 'courses.id = students.course_id', 'left')
            ->join('departments', 'departments.id = courses.department_id', 'left')
            ->where('students.user_id', $user_id)
            ->get()
            ->row();

        $teacher = $this->db
            ->select('teachers.id AS teacher_id, teachers.employee_code, teachers.first_name, teachers.last_name, teachers.phone, teachers.joining_date, departments.name AS department_name, departments.code AS department_code')
            ->from('teachers')
            ->join('departments', 'departments.id = teachers.department_id', 'left')
            ->where('teachers.user_id', $user_id)
            ->get()
            ->row();

        $user->student = $student;
        $user->teacher = $teacher;

        return $user;
    }

    public function email_exists($email, $exclude_id = NULL)
    {
        $this->db->where('email', $email);

        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results('users') > 0;
    }

    public function update_user($user_id, $data)
    {
        if (!$this->db->where('id', $user_id)->update('users', $data)) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return TRUE;
    }

    public function update_student($user_id, $data)
    {
        if (!$this->db->where('user_id', $user_id)->update('students', $data)) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return TRUE;
    }

    public function update_teacher($user_id, $data)
    {
        if (!$this->db->where('user_id', $user_id)->update('teachers', $data)) {
            $error = $this->db->error();
            throw new Exception($error['message'], $error['code']);
        }

        return TRUE;
    }
}