<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model
{
    protected $table = 'subjects';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_student_subjects($user_id)
    {
        return $this->db
            ->select(
                'subjects.*,
                 courses.name AS course_name,
                 courses.code AS course_code'
            )
            ->from('students')
            ->join(
                'courses',
                'courses.id = students.course_id'
            )
            ->join(
                'subjects',
                'subjects.course_id = courses.id'
            )
            ->where('students.user_id', $user_id)
            ->order_by('subjects.semester', 'ASC')
            ->order_by('subjects.name', 'ASC')
            ->get()
            ->result();
    }
}