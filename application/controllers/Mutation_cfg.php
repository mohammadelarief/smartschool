<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutation_cfg extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Mutation_cfg_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Mutation Cfg';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Mutation Cfg' => '',
        ];
        $data['code_js'] = 'mutation_cfg/codejs';
        $data['page'] = 'mutation_cfg/Mutation_cfg_list';
        $data['modal'] = 'mutation_cfg/Mutation_cfg_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Mutation_cfg_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Mutation_cfg_model->get_by_id($id);

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
                $id = $this->input->post('idmutasi', TRUE);
                $data = array(
                    'idmutasi' => $this->input->post('idmutasi', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $update = $this->Mutation_cfg_model->update($id, $data);
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
                    'idmutasi' => $this->input->post('idmutasi', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                if (!$this->Mutation_cfg_model->is_exist($this->input->post('idmutasi'))) {

                    $insert = $this->Mutation_cfg_model->insert($data);
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
        $row = $this->Mutation_cfg_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idmutasi' => $row->idmutasi,
                'type' => $row->type,
                'title' => $row->title,
                'keterangan' => $row->keterangan,
                'status' => $row->status,
            );
            $data['title'] = 'Mutation Cfg';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'mutation_cfg/Mutation_cfg_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation_cfg'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('mutation_cfg/create_action'),
            'idmutasi' => set_value('idmutasi'),
            'type' => set_value('type'),
            'title' => set_value('title'),
            'keterangan' => set_value('keterangan'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Mutation Cfg';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'mutation_cfg/Mutation_cfg_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idmutasi' => $this->input->post('idmutasi', TRUE),
                'type' => $this->input->post('type', TRUE),
                'title' => $this->input->post('title', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            if (!$this->Mutation_cfg_model->is_exist($this->input->post('idmutasi'))) {
                $this->Mutation_cfg_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('mutation_cfg'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idmutasi is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Mutation_cfg_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('mutation_cfg/update_action'),
                'idmutasi' => set_value('idmutasi', $row->idmutasi),
                'type' => set_value('type', $row->type),
                'title' => set_value('title', $row->title),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Mutation Cfg';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'mutation_cfg/Mutation_cfg_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation_cfg'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idmutasi', TRUE));
        } else {
            $data = array(
                'idmutasi' => $this->input->post('idmutasi', TRUE),
                'type' => $this->input->post('type', TRUE),
                'title' => $this->input->post('title', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Mutation_cfg_model->update($this->input->post('idmutasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mutation_cfg'));
        }
    }

    public function delete($id)
    {
        $row = $this->Mutation_cfg_model->get_by_id($id);

        if ($row) {
            $this->Mutation_cfg_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mutation_cfg'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation_cfg'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Mutation_cfg_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idmutasi', 'idmutasi', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('idmutasi', 'idmutasi', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Mutation_cfg.php */
