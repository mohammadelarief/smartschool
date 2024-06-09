<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Timetable_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Subject';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Subject' => '',
        ];
        $data['code_js'] = 'timetable/codejs';
        $data['page'] = 'timetable/index';
        $data['jenjang'] = $this->Timetable_model->get_all_jenjang_classes();
        $classes = $this->Timetable_model->get_all_classes(); // Mengambil semua kelas
        $data['classes'] = $classes;
        foreach ($classes as $class) {
            $data['subjects'][$class->idclass] = $this->Timetable_model->get_subjects_by_class($class->idclass);
        }
        $data['schedule'] = $this->Timetable_model->get_all_timetable();
        // $data['modal'] = 'timetable/Subject_modal';
        $this->load->view('template/backend', $data);
    }

    public function save_timetable()
    {
        $idtimetable = _unix_id("TM");
        $schedule_data = $this->input->post('schedule');

        $days = ['SABTU', 'MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

        foreach ($schedule_data as $class_id => $days_data) {
            foreach ($days_data as $day_index => $times) {
                $day_name = $days[$day_index];
                foreach ($times as $time => $lesson_id) {
                    if (!empty($lesson_id)) {
                        $condition = [
                            'class_id' => $class_id,
                            'position' => $time,
                            'day' => $day_name
                        ];
                        $data = array(
                            'idtimetable' => $idtimetable,
                            'period_id' => '20232024',
                            'class_id' => $class_id,
                            'lesson_id' => $lesson_id,
                            'position' => $time,
                            'day' => $day_name
                        );
                        if ($this->Timetable_model->timetable_exists($condition)) {
                            // Lakukan update
                            $this->Timetable_model->update_timetable($data, $condition);
                        } else {
                            // Lakukan insert
                            $this->Timetable_model->save_timetable($data);
                        }
                        // $this->Timetable_model->save_timetable($data);
                    }
                }
            }
        }

        redirect('timetable');
    }
}
