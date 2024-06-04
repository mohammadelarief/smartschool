<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        // $this->layout->validate_token();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Classes_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Classes';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Classes' => '',
        ];
        $data['filter'] = 'template/filter';
        $data['code_js'] = 'classes/codejs';
        $data['page'] = 'classes/Classes_list';
        $data['modal'] = 'classes/Classes_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Classes_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Classes_model->get_by_id($id);

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
                $id = $this->input->post('idclass', TRUE);
                $data = array(
                    'idclass' => $this->input->post('idclass', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'employee_id' => $this->input->post('employee_id', TRUE),
                    'name_class' => $this->input->post('jenjang', TRUE) . ' ' . $this->input->post('tingkat', TRUE) . ' ' . $this->input->post('rombel', TRUE),
                    'jenjang' => $this->input->post('jenjang', TRUE),
                    'tingkat' => $this->input->post('tingkat', TRUE),
                    'rombel' => $this->input->post('rombel', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'capacity' => $this->input->post('capacity', TRUE),
                );

                $update = $this->Classes_model->update($id, $data);
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
                    'idclass' => $this->input->post('idclass', TRUE),
                    'period_id' => $this->input->post('period_id', TRUE),
                    'employee_id' => $this->input->post('employee_id', TRUE),
                    'name_class' => $this->input->post('jenjang', TRUE) . ' ' . $this->input->post('tingkat', TRUE) . ' ' . $this->input->post('rombel', TRUE),
                    'jenjang' => $this->input->post('jenjang', TRUE),
                    'tingkat' => $this->input->post('tingkat', TRUE),
                    'rombel' => $this->input->post('rombel', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'capacity' => $this->input->post('capacity', TRUE),
                );
                if (!$this->Classes_model->is_exist($this->input->post('idclass'))) {

                    $insert = $this->Classes_model->insert($data);
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
        $row = $this->Classes_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idclass' => $row->idclass,
                'period_id' => $row->period_id,
                'employee_id' => $row->employee_id,
                'name_class' => $row->name_class,
                'jenjang' => $row->jenjang,
                'tingkat' => $row->tingkat,
                'rombel' => $row->rombel,
                'status' => $row->status,
                'capacity' => $row->capacity,
            );
            $data['title'] = 'Classes';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'classes/Classes_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classes'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('classes/create_action'),
            'idclass' => set_value('idclass'),
            'period_id' => set_value('period_id'),
            'employee_id' => set_value('employee_id'),
            'name_class' => set_value('name_class'),
            'jenjang' => set_value('jenjang'),
            'tingkat' => set_value('tingkat'),
            'rombel' => set_value('rombel'),
            'status' => set_value('status'),
            'capacity' => set_value('capacity'),
        );
        $data['title'] = 'Classes';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'classes/Classes_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idclass' => $this->input->post('idclass', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'employee_id' => $this->input->post('employee_id', TRUE),
                'name_class' => $this->input->post('name_class', TRUE),
                'jenjang' => $this->input->post('jenjang', TRUE),
                'tingkat' => $this->input->post('tingkat', TRUE),
                'rombel' => $this->input->post('rombel', TRUE),
                'status' => $this->input->post('status', TRUE),
                'capacity' => $this->input->post('capacity', TRUE),
            );
            if (!$this->Classes_model->is_exist($this->input->post('idclass'))) {
                $this->Classes_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('classes'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idclass is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Classes_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('classes/update_action'),
                'idclass' => set_value('idclass', $row->idclass),
                'period_id' => set_value('period_id', $row->period_id),
                'employee_id' => set_value('employee_id', $row->employee_id),
                'name_class' => set_value('name_class', $row->name_class),
                'jenjang' => set_value('jenjang', $row->jenjang),
                'tingkat' => set_value('tingkat', $row->tingkat),
                'rombel' => set_value('rombel', $row->rombel),
                'status' => set_value('status', $row->status),
                'capacity' => set_value('capacity', $row->capacity),
            );
            $data['title'] = 'Classes';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'classes/Classes_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classes'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idclass', TRUE));
        } else {
            $data = array(
                'idclass' => $this->input->post('idclass', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'employee_id' => $this->input->post('employee_id', TRUE),
                'name_class' => $this->input->post('name_class', TRUE),
                'jenjang' => $this->input->post('jenjang', TRUE),
                'tingkat' => $this->input->post('tingkat', TRUE),
                'rombel' => $this->input->post('rombel', TRUE),
                'status' => $this->input->post('status', TRUE),
                'capacity' => $this->input->post('capacity', TRUE),
            );

            $this->Classes_model->update($this->input->post('idclass', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('classes'));
        }
    }

    public function delete($id)
    {
        $row = $this->Classes_model->get_by_id($id);

        if ($row) {
            $this->Classes_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('classes'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classes'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Classes_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idclass', 'idclass', 'trim|required');
        $this->form_validation->set_rules('period_id', 'period id', 'trim|required');
        $this->form_validation->set_rules('employee_id', 'employee id', 'trim');
        $this->form_validation->set_rules('name_class', 'name class', 'trim');
        $this->form_validation->set_rules('jenjang', 'jenjang', 'trim|required');
        $this->form_validation->set_rules('tingkat', 'tingkat', 'trim|required');
        $this->form_validation->set_rules('rombel', 'rombel', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('capacity', 'capacity', 'trim|required');

        $this->form_validation->set_rules('idclass', 'idclass', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Classes.php */
