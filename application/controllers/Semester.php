<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Semester extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        // $this->layout->validate_token();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Semester_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Semester';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Semester' => '',
        ];
        $data['code_js'] = 'semester/codejs';
        $data['page'] = 'semester/Semester_list';
        $data['modal'] = 'semester/Semester_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Semester_model->json();
    }

    public function update_status()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->Semester_model->activate_semester($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Semester_model->get_by_id($id);

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
                $id = $this->input->post('idsemester', TRUE);
                $data = array(
                    'idsemester' => $this->input->post('idsemester', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                    'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                    'description' => $this->input->post('description', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $update = $this->Semester_model->update($id, $data);
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
                    'idsemester' => $this->input->post('idsemester', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                    'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                    'description' => $this->input->post('description', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                if (!$this->Semester_model->is_exist($this->input->post('idsemester'))) {

                    $insert = $this->Semester_model->insert($data);
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
        $row = $this->Semester_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idsemester' => $row->idsemester,
                'period_id' => $row->period_id,
                'start_date' => $row->start_date,
                'end_date' => $row->end_date,
                'description' => $row->description,
                'status' => $row->status,
            );
            $data['title'] = 'Semester';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'semester/Semester_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('semester'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('semester/create_action'),
            'idsemester' => set_value('idsemester'),
            'period_id' => set_value('period_id'),
            'start_date' => set_value('start_date'),
            'end_date' => set_value('end_date'),
            'description' => set_value('description'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Semester';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'semester/Semester_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idsemester' => $this->input->post('idsemester', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                'description' => $this->input->post('description', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            if (!$this->Semester_model->is_exist($this->input->post('idsemester'))) {
                $this->Semester_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('semester'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idsemester is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Semester_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('semester/update_action'),
                'idsemester' => set_value('idsemester', $row->idsemester),
                'period_id' => set_value('period_id', $row->period_id),
                'start_date' => set_value('start_date', $row->start_date),
                'end_date' => set_value('end_date', $row->end_date),
                'description' => set_value('description', $row->description),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Semester';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'semester/Semester_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('semester'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idsemester', TRUE));
        } else {
            $data = array(
                'idsemester' => $this->input->post('idsemester', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                'description' => $this->input->post('description', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Semester_model->update($this->input->post('idsemester', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('semester'));
        }
    }

    public function delete($id)
    {
        $row = $this->Semester_model->get_by_id($id);

        if ($row) {
            $this->Semester_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('semester'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('semester'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Semester_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idsemester', 'idsemester', 'trim|required');
        $this->form_validation->set_rules('period_id', 'period id', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('idsemester', 'idsemester', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Semester.php */
