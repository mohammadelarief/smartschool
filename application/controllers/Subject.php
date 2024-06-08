<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Subject_model');
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
        $data['code_js'] = 'subject/codejs';
        $data['page'] = 'subject/Subject_list';
        $data['modal'] = 'subject/Subject_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Subject_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Subject_model->get_by_id($id);

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
                $id = $this->input->post('idsubject', TRUE);
                $data = array(
                    'idsubject' => $this->input->post('idsubject', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'nick_name' => $this->input->post('nick_name', TRUE),
                    'full_name' => $this->input->post('full_name', TRUE),
                );

                $update = $this->Subject_model->update($id, $data);
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
                    'idsubject' => $this->input->post('idsubject', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'nick_name' => $this->input->post('nick_name', TRUE),
                    'full_name' => $this->input->post('full_name', TRUE),
                );
                if (!$this->Subject_model->is_exist($this->input->post('idsubject'))) {

                    $insert = $this->Subject_model->insert($data);
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
        $row = $this->Subject_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idsubject' => $row->idsubject,
                'period_id' => $row->period_id,
                'nick_name' => $row->nick_name,
                'full_name' => $row->full_name,
            );
            $data['title'] = 'Subject';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'subject/Subject_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subject'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('subject/create_action'),
            'idsubject' => set_value('idsubject'),
            'period_id' => set_value('period_id'),
            'nick_name' => set_value('nick_name'),
            'full_name' => set_value('full_name'),
        );
        $data['title'] = 'Subject';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'subject/Subject_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idsubject' => $this->input->post('idsubject', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'nick_name' => $this->input->post('nick_name', TRUE),
                'full_name' => $this->input->post('full_name', TRUE),
            );
            if (!$this->Subject_model->is_exist($this->input->post('idsubject'))) {
                $this->Subject_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('subject'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idsubject is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Subject_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('subject/update_action'),
                'idsubject' => set_value('idsubject', $row->idsubject),
                'period_id' => set_value('period_id', $row->period_id),
                'nick_name' => set_value('nick_name', $row->nick_name),
                'full_name' => set_value('full_name', $row->full_name),
            );
            $data['title'] = 'Subject';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'subject/Subject_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subject'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idsubject', TRUE));
        } else {
            $data = array(
                'idsubject' => $this->input->post('idsubject', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'nick_name' => $this->input->post('nick_name', TRUE),
                'full_name' => $this->input->post('full_name', TRUE),
            );

            $this->Subject_model->update($this->input->post('idsubject', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('subject'));
        }
    }

    public function delete($id)
    {
        $row = $this->Subject_model->get_by_id($id);

        if ($row) {
            $this->Subject_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('subject'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subject'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Subject_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idsubject', 'idsubject', 'trim|required');
        $this->form_validation->set_rules('period_id', 'period id', 'trim|required');
        $this->form_validation->set_rules('nick_name', 'nick name', 'trim|required');
        $this->form_validation->set_rules('full_name', 'full name', 'trim|required');

        $this->form_validation->set_rules('idsubject', 'idsubject', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Subject.php */
