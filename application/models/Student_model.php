<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function profile_exists($user_id) {
        $query = $this->db->get_where('students', ['user_id' => $user_id]);
        return $query->num_rows() > 0;
    }

    public function create_student($data) {
        return $this->db->insert('students', $data);
    }

    public function get_student_by_user_id($user_id) {
        $this->db->select('
            students.*,
            users.name,
            users.email,
            users.created_at as registered_since,
            courses.name as course_name,
            courses.code as course_code
        ');
        $this->db->from('students');
        $this->db->join('users', 'users.id = students.user_id');
        $this->db->join('courses', 'courses.id = students.course_id');
        $this->db->where('students.user_id', $user_id);

        return $this->db->get()->row();
    }

    public function get_student_by_id($id) {
        $this->db->select('
            students.*,
            users.name,
            users.email,
            users.status,
            users.created_at as registered_since,
            courses.name as course_name,
            courses.code as course_code
        ');

        $this->db->from('students');
        $this->db->join('users', 'users.id = students.user_id');
        $this->db->join('courses', 'courses.id = students.course_id');
        $this->db->where('students.id', $id);

        return $this->db->get()->row();
    }

    public function get_all_students($search = NULL) {
        $this->db->select('
            students.*,
            users.name,
            users.email,
            users.status,
            courses.name as course_name,
            courses.code as course_code
        ');
        $this->db->from('students');
        $this->db->join('users', 'users.id = students.user_id');
        $this->db->join('courses', 'courses.id = students.course_id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('students.student_code', $search);
            $this->db->or_like('students.phone', $search);
            $this->db->or_like('courses.name', $search);
            $this->db->group_end();
        }

        $this->db->order_by('users.name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_student_count() {
        return $this->db->count_all('students');
    }

    public function update_student(
        $id,
        $student_data,
        $user_data = [],
        $actor_user_id
    ) {
        $student = $this->get_student_by_id($id);

        if (!$student) {
            return FALSE;
        }

        $this->load->model('Audit_model');

        $this->db->trans_start();

        $this->db
            ->where('id', $id)
            ->update('students', $student_data);

        if (!empty($user_data)) {
            $this->db
                ->where('id', $student->user_id)
                ->update('users', $user_data);
        }

        $old_values = array_merge(
            [
                'name' => $student->name
            ],
            [
                'student_code'   => $student->student_code,
                'course_id'      => $student->course_id,
                'dob'            => $student->dob,
                'gender'         => $student->gender,
                'phone'          => $student->phone,
                'admission_date' => $student->admission_date
            ]
        );

        $new_values = array_merge(
            $user_data,
            $student_data
        );

        $this->Audit_model->log(
            $actor_user_id,
            'UPDATE_STUDENT',
            'students',
            $id,
            $old_values,
            $new_values,
            'Student profile updated'
        );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function change_status(
        $id,
        $status,
        $actor_user_id
    ) {
        $student = $this->get_student_by_id($id);

        if (!$student) {
            return FALSE;
        }

        if (!in_array($status, ['active', 'inactive'], TRUE)) {
            return FALSE;
        }

        if ($student->status === $status) {
            return TRUE;
        }

        $this->load->model('Audit_model');

        $this->db->trans_start();

        $this->db
            ->where('id', $student->user_id)
            ->update('users', [
                'status' => $status
            ]);

        $this->Audit_model->log(
            $actor_user_id,
            'CHANGE_STATUS',
            'students',
            $id,
            [
                'status' => $student->status
            ],
            [
                'status' => $status
            ],
            'Student account status changed from '
            . $student->status
            . ' to '
            . $status
        );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}