<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Periode extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        // $this->layout->validate_token();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Periode_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Periode';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Periode' => '',
        ];
        $data['code_js'] = 'periode/codejs';
        $data['page'] = 'periode/Periode_list';
        $data['modal'] = 'periode/Periode_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Periode_model->json();
    }

    public function update_status()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->Periode_model->activate_period($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Periode_model->get_by_id($id);

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
                    'name_period' => $this->input->post('name_period', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'end_date' => $this->input->post('end_date', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'description' => $this->input->post('description', TRUE),
                );

                $update = $this->Periode_model->update($id, $data);
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
                    'name_period' => $this->input->post('name_period', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'end_date' => $this->input->post('end_date', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'description' => $this->input->post('description', TRUE),
                );
                $insert = $this->Periode_model->insert($data);
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
        $row = $this->Periode_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'name_period' => $row->name_period,
                'start_date' => $row->start_date,
                'end_date' => $row->end_date,
                'status' => $row->status,
                'description' => $row->description,
            );
            $data['title'] = 'Periode';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'periode/Periode_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('periode'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('periode/create_action'),
            'id' => set_value('id'),
            'name_period' => set_value('name_period'),
            'start_date' => set_value('start_date'),
            'end_date' => set_value('end_date'),
            'status' => set_value('status'),
            'description' => set_value('description'),
        );
        $data['title'] = 'Periode';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'periode/Periode_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'name_period' => $this->input->post('name_period', TRUE),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                'status' => $this->input->post('status', TRUE),
                'description' => $this->input->post('description', TRUE),
            );
            $this->Periode_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('periode'));
        }
    }

    public function update($id)
    {
        $row = $this->Periode_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('periode/update_action'),
                'id' => set_value('id', $row->id),
                'name_period' => set_value('name_period', $row->name_period),
                'start_date' => set_value('start_date', $row->start_date),
                'end_date' => set_value('end_date', $row->end_date),
                'status' => set_value('status', $row->status),
                'description' => set_value('description', $row->description),
            );
            $data['title'] = 'Periode';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'periode/Periode_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('periode'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'name_period' => $this->input->post('name_period', TRUE),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', TRUE))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date', TRUE))),
                'status' => $this->input->post('status', TRUE),
                'description' => $this->input->post('description', TRUE),
            );

            $this->Periode_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('periode'));
        }
    }

    public function delete($id)
    {
        $row = $this->Periode_model->get_by_id($id);

        if ($row) {
            $this->Periode_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('periode'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('periode'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Periode_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name_period', 'name period', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Periode.php */
