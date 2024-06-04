<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent_ extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Parent__model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Parent ';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Parent ' => '',
        ];
        $data['code_js'] = 'parent_/codejs';
        $data['page'] = 'parent_/Parent__list';
        $data['modal'] = 'parent_/Parent__modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Parent__model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Parent__model->get_by_id($id);

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
                    'idparent' => $this->input->post('idparent', TRUE),
                    'name' => $this->input->post('name', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'nik' => $this->input->post('nik', TRUE),
                    'work' => $this->input->post('work', TRUE),
                    'education' => $this->input->post('education', TRUE),
                    'earnings' => $this->input->post('earnings', TRUE),
                    'phone_number' => $this->input->post('phone_number', TRUE),
                    'position' => $this->input->post('position', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $update = $this->Parent__model->update($id, $data);
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
                    'idparent' => $this->input->post('idparent', TRUE),
                    'name' => $this->input->post('name', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'nik' => $this->input->post('nik', TRUE),
                    'work' => $this->input->post('work', TRUE),
                    'education' => $this->input->post('education', TRUE),
                    'earnings' => $this->input->post('earnings', TRUE),
                    'phone_number' => $this->input->post('phone_number', TRUE),
                    'position' => $this->input->post('position', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                $insert = $this->Parent__model->insert($data);
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
        $row = $this->Parent__model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'idparent' => $row->idparent,
                'name' => $row->name,
                'gender' => $row->gender,
                'nik' => $row->nik,
                'work' => $row->work,
                'education' => $row->education,
                'earnings' => $row->earnings,
                'phone_number' => $row->phone_number,
                'position' => $row->position,
                'status' => $row->status,
            );
            $data['title'] = 'Parent ';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'parent_/Parent__read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('parent_'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('parent_/create_action'),
            'id' => set_value('id'),
            'idparent' => set_value('idparent'),
            'name' => set_value('name'),
            'gender' => set_value('gender'),
            'nik' => set_value('nik'),
            'work' => set_value('work'),
            'education' => set_value('education'),
            'earnings' => set_value('earnings'),
            'phone_number' => set_value('phone_number'),
            'position' => set_value('position'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Parent ';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'parent_/Parent__form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idparent' => $this->input->post('idparent', TRUE),
                'name' => $this->input->post('name', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'nik' => $this->input->post('nik', TRUE),
                'work' => $this->input->post('work', TRUE),
                'education' => $this->input->post('education', TRUE),
                'earnings' => $this->input->post('earnings', TRUE),
                'phone_number' => $this->input->post('phone_number', TRUE),
                'position' => $this->input->post('position', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Parent__model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('parent_'));
        }
    }

    public function update($id)
    {
        $row = $this->Parent__model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('parent_/update_action'),
                'id' => set_value('id', $row->id),
                'idparent' => set_value('idparent', $row->idparent),
                'name' => set_value('name', $row->name),
                'gender' => set_value('gender', $row->gender),
                'nik' => set_value('nik', $row->nik),
                'work' => set_value('work', $row->work),
                'education' => set_value('education', $row->education),
                'earnings' => set_value('earnings', $row->earnings),
                'phone_number' => set_value('phone_number', $row->phone_number),
                'position' => set_value('position', $row->position),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Parent ';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'parent_/Parent__form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('parent_'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'idparent' => $this->input->post('idparent', TRUE),
                'name' => $this->input->post('name', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'nik' => $this->input->post('nik', TRUE),
                'work' => $this->input->post('work', TRUE),
                'education' => $this->input->post('education', TRUE),
                'earnings' => $this->input->post('earnings', TRUE),
                'phone_number' => $this->input->post('phone_number', TRUE),
                'position' => $this->input->post('position', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Parent__model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('parent_'));
        }
    }

    public function delete($id)
    {
        $row = $this->Parent__model->get_by_id($id);

        if ($row) {
            $this->Parent__model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('parent_'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('parent_'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Parent__model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idparent', 'idparent', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
        $this->form_validation->set_rules('nik', 'nik', 'trim|required');
        $this->form_validation->set_rules('work', 'work', 'trim|required');
        $this->form_validation->set_rules('education', 'education', 'trim|required');
        $this->form_validation->set_rules('earnings', 'earnings', 'trim|required');
        $this->form_validation->set_rules('phone_number', 'phone number', 'trim|required');
        $this->form_validation->set_rules('position', 'position', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Parent_.php */
