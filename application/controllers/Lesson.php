<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Lesson_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Lesson';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Lesson' => '',
        ];
        $data['code_js'] = 'lesson/codejs';
        $data['page'] = 'lesson/Lesson_list';
        $data['modal'] = 'lesson/Lesson_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Lesson_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Lesson_model->get_by_id($id);

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
                $id = $this->input->post('idlesson', TRUE);
                $data = array(
                    'idlesson' => $this->input->post('idlesson', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'employee_id' => $this->input->post('employee_id', TRUE),
                    'class_id' => $this->input->post('class_id', TRUE),
                    'subject_id' => $this->input->post('subject_id', TRUE),
                );

                $update = $this->Lesson_model->update($id, $data);
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
                    'idlesson' => $this->input->post('idlesson', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'employee_id' => $this->input->post('employee_id', TRUE),
                    'class_id' => $this->input->post('class_id', TRUE),
                    'subject_id' => $this->input->post('subject_id', TRUE),
                );
                if (!$this->Lesson_model->is_exist($this->input->post('idlesson'))) {

                    $insert = $this->Lesson_model->insert($data);
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
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'idsiswa is exist';
                }
            }
        }
        echo json_encode($data);
    }

    public function read($id)
    {
        $row = $this->Lesson_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idlesson' => $row->idlesson,
                'period_id' => $row->period_id,
                'employee_id' => $row->employee_id,
                'subject_id' => $row->subject_id,
            );
            $data['title'] = 'Lesson';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'lesson/Lesson_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lesson'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('lesson/create_action'),
            'idlesson' => set_value('idlesson'),
            'period_id' => set_value('period_id'),
            'employee_id' => set_value('employee_id'),
            'subject_id' => set_value('subject_id'),
        );
        $data['title'] = 'Lesson';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'lesson/Lesson_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idlesson' => $this->input->post('idlesson', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'employee_id' => $this->input->post('employee_id', TRUE),
                'subject_id' => $this->input->post('subject_id', TRUE),
            );
            if (!$this->Lesson_model->is_exist($this->input->post('idlesson'))) {
                $this->Lesson_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('lesson'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idlesson is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Lesson_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('lesson/update_action'),
                'idlesson' => set_value('idlesson', $row->idlesson),
                'period_id' => set_value('period_id', $row->period_id),
                'employee_id' => set_value('employee_id', $row->employee_id),
                'subject_id' => set_value('subject_id', $row->subject_id),
            );
            $data['title'] = 'Lesson';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'lesson/Lesson_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lesson'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idlesson', TRUE));
        } else {
            $data = array(
                'idlesson' => $this->input->post('idlesson', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'employee_id' => $this->input->post('employee_id', TRUE),
                'subject_id' => $this->input->post('subject_id', TRUE),
            );

            $this->Lesson_model->update($this->input->post('idlesson', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('lesson'));
        }
    }

    public function delete($id)
    {
        $row = $this->Lesson_model->get_by_id($id);

        if ($row) {
            $this->Lesson_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('lesson'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lesson'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Lesson_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idlesson', 'idlesson', 'trim|required');
        $this->form_validation->set_rules('period_id', 'period id', 'trim|required');
        $this->form_validation->set_rules('employee_id', 'employee id', 'trim|required');
        $this->form_validation->set_rules('class_id', 'employee id', 'trim|required');
        $this->form_validation->set_rules('subject_id', 'subject id', 'trim|required');

        $this->form_validation->set_rules('idlesson', 'idlesson', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Lesson.php */
