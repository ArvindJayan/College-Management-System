<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function profile_exists($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->count_all_results('teachers') > 0;
    }

    public function create_teacher($data) {
        return $this->db->insert('teachers', $data);
    }

    public function get_teacher_by_id($id) {
        $this->db->select('
            teachers.*,
            users.name,
            users.email,
            users.status,
            departments.name as department_name,
            departments.code as department_code
        ');
        $this->db->from('teachers');
        $this->db->join('users', 'users.id = teachers.user_id');
        $this->db->join('departments', 'departments.id = teachers.department_id');
        $this->db->where('teachers.id', $id);

        return $this->db->get()->row();
    }

    public function get_teacher_by_user_id($user_id) {
        $this->db->select('
            teachers.*,
            users.name,
            users.email,
            users.status,
            departments.name as department_name,
            departments.code as department_code
        ');
        $this->db->from('teachers');
        $this->db->join('users', 'users.id = teachers.user_id');
        $this->db->join('departments', 'departments.id = teachers.department_id');
        $this->db->where('teachers.user_id', $user_id);

        return $this->db->get()->row();
    }

    public function get_all_teachers($search = NULL, $department_id = NULL) {
        $this->db->select('
            teachers.*,
            users.name,
            users.email,
            users.status,
            departments.name as department_name,
            departments.code as department_code
        ');
        $this->db->from('teachers');
        $this->db->join('users', 'users.id = teachers.user_id');
        $this->db->join('departments', 'departments.id = teachers.department_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('teachers.employee_code', $search);
            $this->db->or_like('teachers.first_name', $search);
            $this->db->or_like('teachers.last_name', $search);
            $this->db->or_like('teachers.phone', $search);
            $this->db->or_like('departments.name', $search);
            $this->db->group_end();
        }

        if (!empty($department_id)) {
            $this->db->where('teachers.department_id', $department_id);
        }

        $this->db->order_by('users.name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_departments() {
        $this->db->select('id, name, code');
        $this->db->from('departments');
        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_teacher_count() {
        return $this->db->count_all('teachers');
    }

    public function update_teacher(
        $id,
        $teacher_data,
        $user_data = [],
        $actor_user_id
    ) {
        $teacher = $this->get_teacher_by_id($id);

        if (!$teacher) {
            return FALSE;
        }

        $this->load->model('Audit_model');

        $this->db->trans_start();

        $this->db
            ->where('id', $id)
            ->update('teachers', $teacher_data);

        if (!empty($user_data)) {
            $this->db
                ->where('id', $teacher->user_id)
                ->update('users', $user_data);
        }

        $old_values = array_merge(
            [
                'name' => $teacher->name
            ],
            [
                'employee_code' => $teacher->employee_code,
                'department_id' => $teacher->department_id,
                'first_name'    => $teacher->first_name,
                'last_name'     => $teacher->last_name,
                'phone'         => $teacher->phone,
                'joining_date'  => $teacher->joining_date
            ]
        );

        $new_values = array_merge(
            $user_data,
            $teacher_data
        );

        $this->Audit_model->log(
            $actor_user_id,
            'UPDATE_TEACHER',
            'teachers',
            $id,
            $old_values,
            $new_values,
            'Teacher profile updated'
        );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function change_status(
        $id,
        $status,
        $actor_user_id
    ) {
        $teacher = $this->get_teacher_by_id($id);

        if (!$teacher) {
            return FALSE;
        }

        if (!in_array($status, ['active', 'inactive'], TRUE)) {
            return FALSE;
        }

        if ($teacher->status === $status) {
            return TRUE;
        }

        $this->load->model('Audit_model');

        $this->db->trans_start();

        $this->db
            ->where('id', $teacher->user_id)
            ->update('users', [
                'status' => $status
            ]);

        $this->Audit_model->log(
            $actor_user_id,
            'CHANGE_STATUS',
            'teachers',
            $id,
            [
                'status' => $teacher->status
            ],
            [
                'status' => $status
            ],
            'Teacher account status changed from '
            . $teacher->status
            . ' to '
            . $status
        );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}