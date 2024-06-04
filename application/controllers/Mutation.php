<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutation extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Mutation_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Mutation';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Mutation' => '',
        ];
        $data['code_js'] = 'mutation/codejs';
        $data['page'] = 'mutation/Mutation_list';
        $data['modal'] = 'mutation/Mutation_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Mutation_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Mutation_model->get_by_id($id);

        echo json_encode($row);
    }

    public function json_form()
    {
        $user = $this->ion_auth->user()->row();
        $userid = $user->id;
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
                $id = $this->input->post('idmutation_old', TRUE);
                $data = array(
                    'idmutation' => $this->input->post('idmutation', TRUE),
                    'cfg_mutation_id' => $this->input->post('cfg_mutation_id', TRUE),
                    'student_id' => $this->input->post('student_id', TRUE),
                    'person_id' => $this->input->post('person_id', TRUE),
                    'new_classes' => $this->input->post('new_classes', TRUE),
                    'old_classes' => $this->input->post('old_classes', TRUE),
                    'date_mutation' => date('Y-m-d', strtotime($this->input->post('date_mutation', TRUE))),
                    'date_process' => date('Y-m-d H:i:s'),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'user_id' => $userid,
                    'status' => '2',
                );
                $data_student = array(
                    'status' => '1',
                );
                $data_update = array(
                    'status' => '0',
                );

                $this->db->trans_begin();
                $this->Mutation_model->insert($data);
                $this->Mutation_model->update($id, $data_update);
                $this->Mutation_model->update_student($this->input->post('student_id', TRUE), $data_student);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data['status'] = false;
                    $data['msg'] = 'Failed to update data';
                    foreach ($_POST as $key => $value) {
                        $data['messages'][$key] = form_error($key);
                    }
                    $this->session->set_flashdata('message', 'Terjadi kesalahan sistem, silahkan ulangi');
                } else {
                    $this->db->trans_commit();
                    $data['status'] = true;
                    $data['msg'] = 'Success to update data';
                    $this->session->set_flashdata('message', 'Update Record Success');
                }
            } else {
                $types = $this->input->post('cfg_mutation_id', TRUE);
                $data = array(
                    'idmutation' => $this->input->post('idmutation', TRUE),
                    'cfg_mutation_id' => $this->input->post('cfg_mutation_id', TRUE),
                    'student_id' => $this->input->post('student_id', TRUE),
                    'person_id' => $this->input->post('person_id', TRUE),
                    'new_classes' => $this->input->post('new_classes', TRUE),
                    'old_classes' => $this->input->post('old_classes', TRUE),
                    'date_mutation' => date('Y-m-d', strtotime($this->input->post('date_mutation', TRUE))),
                    'date_process' => date('Y-m-d H:i:s'),
                    'keterangan' => $this->input->post('keterangan', TRUE),
                    'info' => $this->input->post('info', TRUE),
                    'user_id' => $userid,
                    'status' => $this->input->post('status', TRUE),
                );
                $data_student = array(
                    'status' => '0',
                );
                $data_new_student = array(
                    'status' => '1',
                    'personid' => $this->input->post('person_id', TRUE),
                    'class_id' => $this->input->post('new_classes', TRUE),
                    'idstudent' => _unix_id('S')
                );

                if (!$this->Mutation_model->is_exist($this->input->post('idmutation'))) {

                    $this->db->trans_begin();
                    $this->Mutation_model->insert($data);
                    $this->Mutation_model->update_student($this->input->post('student_id', TRUE), $data_student);
                    if ($types == 'JM1716537721T7T3' || $types == 'JM17165377488HZS') {
                        $this->Mutation_model->insert_student($data_new_student);
                    }

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $data['status'] = false;
                        $data['msg'] = 'Failed to update data';
                        foreach ($_POST as $key => $value) {
                            $data['messages'][$key] = form_error($key);
                        }
                        $this->session->set_flashdata('message', 'Terjadi kesalahan sistem, silahkan ulangi');
                    } else {
                        $this->db->trans_commit();
                        $data['status'] = true;
                        $data['msg'] = 'Success to update data';
                        $this->session->set_flashdata('message', 'Update Record Success');
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
        $row = $this->Mutation_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idmutation' => $row->idmutation,
                'cfg_mutation_id' => $row->cfg_mutation_id,
                'student_id' => $row->student_id,
                'person_id' => $row->person_id,
                'new_classes' => $row->new_classes,
                'old_classes' => $row->old_classes,
                'date_mutation' => $row->date_mutation,
                'date_process' => $row->date_process,
                'keterangan' => $row->keterangan,
                'user_id' => $row->user_id,
                'status' => $row->status,
            );
            $data['title'] = 'Mutation';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'mutation/Mutation_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('mutation/create_action'),
            'idmutation' => set_value('idmutation'),
            'cfg_mutation_id' => set_value('cfg_mutation_id'),
            'student_id' => set_value('student_id'),
            'person_id' => set_value('person_id'),
            'new_classes' => set_value('new_classes'),
            'old_classes' => set_value('old_classes'),
            'date_mutation' => set_value('date_mutation'),
            'date_process' => set_value('date_process'),
            'keterangan' => set_value('keterangan'),
            'user_id' => set_value('user_id'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Mutation';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'mutation/Mutation_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idmutation' => $this->input->post('idmutation', TRUE),
                'cfg_mutation_id' => $this->input->post('cfg_mutation_id', TRUE),
                'student_id' => $this->input->post('student_id', TRUE),
                'person_id' => $this->input->post('person_id', TRUE),
                'new_classes' => $this->input->post('new_classes', TRUE),
                'old_classes' => $this->input->post('old_classes', TRUE),
                'date_mutation' => $this->input->post('date_mutation', TRUE),
                'date_process' => $this->input->post('date_process', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'user_id' => $this->input->post('user_id', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            if (!$this->Mutation_model->is_exist($this->input->post('idmutation'))) {
                $this->Mutation_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('mutation'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idmutation is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Mutation_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('mutation/update_action'),
                'idmutation' => set_value('idmutation', $row->idmutation),
                'cfg_mutation_id' => set_value('cfg_mutation_id', $row->cfg_mutation_id),
                'student_id' => set_value('student_id', $row->student_id),
                'person_id' => set_value('person_id', $row->person_id),
                'new_classes' => set_value('new_classes', $row->new_classes),
                'old_classes' => set_value('old_classes', $row->old_classes),
                'date_mutation' => set_value('date_mutation', $row->date_mutation),
                'date_process' => set_value('date_process', $row->date_process),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'user_id' => set_value('user_id', $row->user_id),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Mutation';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'mutation/Mutation_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idmutation', TRUE));
        } else {
            $data = array(
                'idmutation' => $this->input->post('idmutation', TRUE),
                'cfg_mutation_id' => $this->input->post('cfg_mutation_id', TRUE),
                'student_id' => $this->input->post('student_id', TRUE),
                'person_id' => $this->input->post('person_id', TRUE),
                'new_classes' => $this->input->post('new_classes', TRUE),
                'old_classes' => $this->input->post('old_classes', TRUE),
                'date_mutation' => $this->input->post('date_mutation', TRUE),
                'date_process' => $this->input->post('date_process', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'user_id' => $this->input->post('user_id', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Mutation_model->update($this->input->post('idmutation', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mutation'));
        }
    }

    public function delete($id)
    {
        $row = $this->Mutation_model->get_by_id($id);

        if ($row) {
            $this->Mutation_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mutation'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mutation'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Mutation_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idmutation', 'idmutation', 'trim|required');
        $this->form_validation->set_rules('cfg_mutation_id', 'cfg mutation id', 'trim|required');
        $this->form_validation->set_rules('student_id', 'student id', 'trim|required');
        $this->form_validation->set_rules('person_id', 'person id', 'trim|required');
        $this->form_validation->set_rules('new_classes', 'new classes', 'trim');
        $this->form_validation->set_rules('old_classes', 'old classes', 'trim|required');
        $this->form_validation->set_rules('date_mutation', 'date mutation', 'trim|required');
        $this->form_validation->set_rules('date_process', 'date process', 'trim');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_rules('user_id', 'user id', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('idmutation', 'idmutation', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Mutation.php */
