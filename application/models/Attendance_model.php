<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    protected $table = 'student_attendance';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_staff_subjects($user_id, $role_id)
    {
        $this->db
            ->select(
                'subjects.*,
                 courses.name AS course_name,
                 courses.code AS course_code'
            )
            ->from('subjects')
            ->join(
                'courses',
                'courses.id = subjects.course_id'
            );

        if ($role_id === 3) {
            $this->db
                ->join(
                    'teacher_subjects',
                    'teacher_subjects.subject_id = subjects.id'
                )
                ->join(
                    'teachers',
                    'teachers.id = teacher_subjects.teacher_id'
                )
                ->where(
                    'teachers.user_id',
                    $user_id
                );
        }

        if ($role_id === 2) {
            $this->db
                ->join(
                    'teachers',
                    'teachers.department_id = courses.department_id'
                )
                ->where(
                    'teachers.user_id',
                    $user_id
                );
        }

        return $this->db
            ->order_by(
                'subjects.semester',
                'ASC'
            )
            ->order_by(
                'subjects.name',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function get_staff_subject(
        $user_id,
        $role_id,
        $subject_id
    ) {
        $this->db
            ->select(
                'subjects.*,
                 courses.name AS course_name,
                 courses.code AS course_code'
            )
            ->from('subjects')
            ->join(
                'courses',
                'courses.id = subjects.course_id'
            )
            ->where(
                'subjects.id',
                $subject_id
            );

        if ($role_id === 3) {
            $this->db
                ->join(
                    'teacher_subjects',
                    'teacher_subjects.subject_id = subjects.id'
                )
                ->join(
                    'teachers',
                    'teachers.id = teacher_subjects.teacher_id'
                )
                ->where(
                    'teachers.user_id',
                    $user_id
                );
        }

        if ($role_id === 2) {
            $this->db
                ->join(
                    'teachers',
                    'teachers.department_id = courses.department_id'
                )
                ->where(
                    'teachers.user_id',
                    $user_id
                );
        }

        return $this->db
            ->get()
            ->row();
    }

    public function get_students_for_subject($subject_id)
    {
        return $this->db
            ->select(
                'students.id,
                 students.student_code,
                 users.name,
                 users.email'
            )
            ->from('subjects')
            ->join(
                'students',
                'students.course_id = subjects.course_id'
            )
            ->join(
                'users',
                'users.id = students.user_id'
            )
            ->where(
                'subjects.id',
                $subject_id
            )
            ->where(
                'users.status',
                'active'
            )
            ->order_by(
                'users.name',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function get_attendance_for_date(
        $subject_id,
        $date
    ) {
        $rows =
            $this->db
                ->select(
                    'student_id, status'
                )
                ->from($this->table)
                ->where(
                    'subject_id',
                    $subject_id
                )
                ->where(
                    'attendance_date',
                    $date
                )
                ->get()
                ->result();

        $attendance = array();

        foreach ($rows as $row) {
            $attendance[$row->student_id] =
                $row->status;
        }

        return $attendance;
    }

    public function save_attendance(
        $subject_id,
        $date,
        $attendance,
        $marked_by
    ) {
        $this->db->trans_start();

        foreach ($attendance as $student_id => $status) {
            if (
                !in_array(
                    $status,
                    array('present', 'absent'),
                    TRUE
                )
            ) {
                continue;
            }

            $student =
                $this->db
                    ->select(
                        'students.id'
                    )
                    ->from('students')
                    ->join(
                        'subjects',
                        'subjects.course_id = students.course_id'
                    )
                    ->where(
                        'students.id',
                        $student_id
                    )
                    ->where(
                        'subjects.id',
                        $subject_id
                    )
                    ->get()
                    ->row();

            if (!$student) {
                continue;
            }

            $existing =
                $this->db
                    ->where(
                        'student_id',
                        $student_id
                    )
                    ->where(
                        'subject_id',
                        $subject_id
                    )
                    ->where(
                        'attendance_date',
                        $date
                    )
                    ->get($this->table)
                    ->row();

            $data = array(
                'student_id' => $student_id,
                'subject_id' => $subject_id,
                'attendance_date' => $date,
                'status' => $status,
                'marked_by' => $marked_by
            );

            if ($existing) {
                $this->db
                    ->where(
                        'id',
                        $existing->id
                    )
                    ->update(
                        $this->table,
                        $data
                    );
            } else {
                $this->db
                    ->insert(
                        $this->table,
                        $data
                    );
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_student_attendance_summary(
        $user_id
    ) {
        return $this->db
            ->select(
                'subjects.id AS subject_id,
                 subjects.name AS subject_name,
                 subjects.code AS subject_code,
                 courses.name AS course_name,
                 COUNT(student_attendance.id) AS total_classes,
                 SUM(
                    CASE
                        WHEN student_attendance.status = "present"
                        THEN 1
                        ELSE 0
                    END
                 ) AS present_count,
                 SUM(
                    CASE
                        WHEN student_attendance.status = "absent"
                        THEN 1
                        ELSE 0
                    END
                 ) AS absent_count'
            )
            ->from('students')
            ->join(
                'student_attendance',
                'student_attendance.student_id = students.id',
                'left'
            )
            ->join(
                'subjects',
                'subjects.id = student_attendance.subject_id',
                'left'
            )
            ->join(
                'courses',
                'courses.id = subjects.course_id',
                'left'
            )
            ->where(
                'students.user_id',
                $user_id
            )
            ->group_by(
                'subjects.id'
            )
            ->order_by(
                'subjects.name',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function get_student_attendance(
        $user_id
    ) {
        return $this->db
            ->select(
                'student_attendance.attendance_date,
                 student_attendance.status,
                 subjects.name AS subject_name,
                 subjects.code AS subject_code'
            )
            ->from('students')
            ->join(
                'student_attendance',
                'student_attendance.student_id = students.id'
            )
            ->join(
                'subjects',
                'subjects.id = student_attendance.subject_id'
            )
            ->where(
                'students.user_id',
                $user_id
            )
            ->order_by(
                'student_attendance.attendance_date',
                'DESC'
            )
            ->order_by(
                'subjects.name',
                'ASC'
            )
            ->get()
            ->result();
    }
}