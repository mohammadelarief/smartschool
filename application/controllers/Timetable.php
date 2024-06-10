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
        $this->load->model('Cfg_timetable_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Cfg Timetable';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Cfg Timetable' => '',
        ];
        $data['code_js'] = 'timetable/t_codejs';
        $data['page'] = 'timetable/timetable_list';
        $data['modal'] = 'timetable/timetable_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Cfg_timetable_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Cfg_timetable_model->get_by_id($id);

        echo json_encode($row);
    }

    public function json_form()
    {
        $this->_rules();
        $data = array('status' => false, 'messages' => array(), 'msg' => '');
        if ($this->form_validation->run() === FALSE) {
            foreach ($_POST as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
            $data['status'] = false;
            $data['msg'] = 'Error';
        } else {
            $act = isset($_POST['actions']) ? $_POST['actions'] : '';
            if ($act == 'Edit') {
                $id = $this->input->post('id', TRUE);
                $data = array(
                    'idtimetable' => $this->input->post('idtimetable', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'semester_id' => $this->input->post('semester_id', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $update = $this->Cfg_timetable_model->update($id, $data);
                if ($update) {
                    $data['status'] = true;
                    $data['msg'] = 'Success to update data';
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'Failed to update data';
                    foreach ($_POST as $key => $value) {
                        $data['messages'][$key] = form_error($key);
                    }
                }
            } else {
                $data = array(
                    'idtimetable' => $this->input->post('idtimetable', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'semester_id' => $this->input->post('semester_id', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                $insert = $this->Cfg_timetable_model->insert($data);
                if ($insert) {
                    $data['status'] = true;
                    $data['msg'] = 'Success to insert data';
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'Failed to insert data';
                    foreach ($_POST as $key => $value) {
                        $data['messages'][$key] = form_error($key);
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function timetable($id)
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
        $data['schedule'] = $this->Timetable_model->get_all_timetable($id);
        // $data['modal'] = 'timetable/Subject_modal';
        $this->load->view('template/backend', $data);
    }

    public function save_timetable()
    {
        $idtimetable = $this->input->post('idtimetable');
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

    public function update_status()
    {
        $id = $this->input->post('id');
        $idsemester = $this->input->post('semester');
        if ($id) {
            $this->Cfg_timetable_model->activate_timetable($id, $idsemester);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idtimetable', 'idtimetable', 'trim|required');
        $this->form_validation->set_rules('period_id', 'period id', 'trim|required');
        $this->form_validation->set_rules('semester_id', 'semester id', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}
