<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cfg_timetable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
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
        $data['code_js'] = 'cfg_timetable/codejs';
        $data['page'] = 'cfg_timetable/Cfg_timetable_list';
        $data['modal'] = 'cfg_timetable/Cfg_timetable_modal';
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



    public function read($id)
    {
        $row = $this->Cfg_timetable_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'idtimetable' => $row->idtimetable,
                'period_id' => $row->period_id,
                'semester_id' => $row->semester_id,
                'keterangan' => $row->keterangan,
                'status' => $row->status,
            );
            $data['title'] = 'Cfg Timetable';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'cfg_timetable/Cfg_timetable_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cfg_timetable'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('cfg_timetable/create_action'),
            'id' => set_value('id'),
            'idtimetable' => set_value('idtimetable'),
            'period_id' => set_value('period_id'),
            'semester_id' => set_value('semester_id'),
            'keterangan' => set_value('keterangan'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Cfg Timetable';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'cfg_timetable/Cfg_timetable_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idtimetable' => $this->input->post('idtimetable', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'semester_id' => $this->input->post('semester_id', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Cfg_timetable_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('cfg_timetable'));
        }
    }

    public function update($id)
    {
        $row = $this->Cfg_timetable_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('cfg_timetable/update_action'),
                'id' => set_value('id', $row->id),
                'idtimetable' => set_value('idtimetable', $row->idtimetable),
                'period_id' => set_value('period_id', $row->period_id),
                'semester_id' => set_value('semester_id', $row->semester_id),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Cfg Timetable';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'cfg_timetable/Cfg_timetable_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cfg_timetable'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'idtimetable' => $this->input->post('idtimetable', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'semester_id' => $this->input->post('semester_id', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Cfg_timetable_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cfg_timetable'));
        }
    }

    public function delete($id)
    {
        $row = $this->Cfg_timetable_model->get_by_id($id);

        if ($row) {
            $this->Cfg_timetable_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cfg_timetable'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cfg_timetable'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Cfg_timetable_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
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

/* End of file Cfg_timetable.php */
