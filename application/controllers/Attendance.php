<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_authenticated')) {
            redirect('/auth/login');
        }

        $this->load->library('form_validation');
        $this->load->model('Attendance_model');
    }

    private function require_staff()
    {
        $role_id = (int) $this->session->userdata('role_id');

        if (!in_array($role_id, array(1, 2, 3), TRUE)) {
            $this->session->set_flashdata(
                'error',
                'You are not authorized to access attendance.'
            );

            redirect('/dashboard');
        }
    }

    public function index()
    {
        $role_id = (int) $this->session->userdata('role_id');
        $user_id = (int) $this->session->userdata('user_id');

        if (in_array($role_id, array(1, 2, 3), TRUE)) {
            $data['subjects'] =
                $this->Attendance_model->get_staff_subjects(
                    $user_id,
                    $role_id
                );

            $this->load->view('attendance/index', $data);

            return;
        }

        if ($role_id === 4) {
            $data['attendance'] =
                $this->Attendance_model->get_student_attendance_summary(
                    $user_id
                );

            $data['records'] =
                $this->Attendance_model->get_student_attendance(
                    $user_id
                );

            $this->load->view('attendance/index', $data);

            return;
        }

        $this->session->set_flashdata(
            'error',
            'You are not authorized to access attendance.'
        );

        redirect('/dashboard');
    }

    public function mark($subject_id)
    {
        $this->require_staff();

        $role_id =
            (int) $this->session->userdata('role_id');

        $user_id =
            (int) $this->session->userdata('user_id');

        $subject =
            $this->Attendance_model->get_staff_subject(
                $user_id,
                $role_id,
                $subject_id
            );

        if (!$subject) {
            $this->session->set_flashdata(
                'error',
                'You are not authorized to mark attendance for this subject.'
            );

            redirect('/attendance');

            return;
        }

        $date =
            $this->input->get('date', TRUE);

        if (!$date) {
            $date = date('Y-m-d');
        }

        $students =
            $this->Attendance_model->get_students_for_subject(
                $subject_id
            );

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules(
                'attendance_date',
                'Attendance Date',
                'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]'
            );

            if ($this->form_validation->run() === FALSE) {
                $date =
                    $this->input->post(
                        'attendance_date',
                        TRUE
                    );
            } else {
                $date =
                    $this->input->post(
                        'attendance_date',
                        TRUE
                    );

                $attendance =
                    $this->input->post('status');

                if (!is_array($attendance)) {
                    $this->session->set_flashdata(
                        'error',
                        'No attendance data was submitted.'
                    );

                    redirect(
                        '/attendance/mark/' .
                        $subject_id .
                        '?date=' .
                        urlencode($date)
                    );

                    return;
                }

                if (
                    $this->Attendance_model->save_attendance(
                        $subject_id,
                        $date,
                        $attendance,
                        $user_id
                    )
                ) {
                    $this->session->set_flashdata(
                        'success',
                        'Attendance saved successfully.'
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Unable to save attendance.'
                    );
                }

                redirect(
                    '/attendance/mark/' .
                    $subject_id .
                    '?date=' .
                    urlencode($date)
                );

                return;
            }
        }

        $data['subject'] =
            $subject;

        $data['students'] =
            $students;

        $data['attendance'] =
            $this->Attendance_model->get_attendance_for_date(
                $subject_id,
                $date
            );

        $data['attendance_date'] =
            $date;

        $this->load->view(
            'attendance/mark',
            $data
        );
    }
}