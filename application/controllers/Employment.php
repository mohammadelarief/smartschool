<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Employment_model');
        $this->load->model('Employment_detail_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Employment';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Employment' => '',
        ];
        $data['code_js'] = 'employment/codejs';
        $data['page'] = 'employment/Employment_list';
        $data['modal'] = 'employment/Employment_modal';
        $get_prov = $this->db->select('*')->from('ind_provinsi')->get();
        $data['provinsi_ind'] = $get_prov->result();
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Employment_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Employment_model->get_by_id($id);
        $row_detail = $this->Employment_detail_model->get_by_id($id);
        $combined_row = array_merge((array) $row, (array) $row_detail);

        echo json_encode($combined_row);
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
                $id = $this->input->post('idperson', TRUE);
                $nis = $this->input->post('numberid', TRUE);
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'numberid' => $this->input->post('numberid', TRUE),
                    'nip' => $this->input->post('nip', TRUE),
                    'nipy' => $this->input->post('nipy', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $data_detail = array(
                    // 'person_id' => $this->input->post('person_id', TRUE),
                    'date_born' => date('Y-m-d', strtotime($this->input->post('date_born', TRUE))),
                    'where_born' => $this->input->post('where_born', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'dusun' => $this->input->post('dusun', TRUE),
                    'kelurahan' => $this->input->post('kelurahan', TRUE),
                    'kecamatan' => $this->input->post('kecamatan', TRUE),
                    'kabupaten' => $this->input->post('kabupaten', TRUE),
                    'provinsi' => $this->input->post('provinsi', TRUE),
                    'zipcode' => $this->input->post('zipcode', TRUE),
                    'nik' => $this->input->post('nik', TRUE),
                    'kk' => $this->input->post('kk', TRUE),
                    'religion' => $this->input->post('religion', TRUE),
                    'nationality' => $this->input->post('nationality', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'relationship' => $this->input->post('relationship', TRUE),
                    'name_partner' => $this->input->post('name_partner', TRUE),
                    'childrens' => $this->input->post('childrens', TRUE),
                    'name_mother' => $this->input->post('name_mother', TRUE),
                    'npwp' => $this->input->post('npwp', TRUE),
                    'position' => $this->input->post('position', TRUE),
                    'status_employment' => $this->input->post('status_employment', TRUE),
                );
                $this->db->trans_begin();
                $this->Employment_model->update($id, $data);
                $this->Employment_detail_model->update($nis, $data_detail);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data['status'] = false;
                    $data['msg'] = 'Failed to update data';
                    foreach ($_POST as $key => $value) {
                        $data['messages'][$key] = form_error($key);
                    }
                } else {
                    $this->db->trans_commit();
                    $data['status'] = true;
                    $data['msg'] = 'Success to update data';
                    $this->session->set_flashdata('message', 'Update Record Success');
                }
            } else {
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'numberid' => $this->input->post('numberid', TRUE),
                    'nip' => $this->input->post('nip', TRUE),
                    'nipy' => $this->input->post('nipy', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                $data_detail = array(
                    'person_id' => $this->input->post('numberid', TRUE),
                    'date_born' => date('Y-m-d', strtotime($this->input->post('date_born', TRUE))),
                    'where_born' => $this->input->post('where_born', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'dusun' => $this->input->post('dusun', TRUE),
                    'kelurahan' => $this->input->post('kelurahan', TRUE),
                    'kecamatan' => $this->input->post('kecamatan', TRUE),
                    'kabupaten' => $this->input->post('kabupaten', TRUE),
                    'provinsi' => $this->input->post('provinsi', TRUE),
                    'zipcode' => $this->input->post('zipcode', TRUE),
                    'nik' => $this->input->post('nik', TRUE),
                    'kk' => $this->input->post('kk', TRUE),
                    'religion' => $this->input->post('religion', TRUE),
                    'nationality' => $this->input->post('nationality', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'relationship' => $this->input->post('relationship', TRUE),
                    'name_partner' => $this->input->post('name_partner', TRUE),
                    'childrens' => $this->input->post('childrens', TRUE),
                    'name_mother' => $this->input->post('name_mother', TRUE),
                    'npwp' => $this->input->post('npwp', TRUE),
                    'position' => $this->input->post('position', TRUE),
                    'status_employment' => $this->input->post('status_employment', TRUE),
                );
                $this->db->trans_begin();
                $this->Employment_model->insert($data);
                $this->Employment_detail_model->insert($data_detail);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data['status'] = false;
                    $data['msg'] = 'Failed to insert data';
                    foreach ($_POST as $key => $value) {
                        $data['messages'][$key] = form_error($key);
                    }
                    $this->session->set_flashdata('message', 'Terjadi kesalahan sistem, silahkan ulangi');
                } else {
                    $this->db->trans_commit();
                    $data['status'] = true;
                    $data['msg'] = 'Success to insert data';
                    $this->session->set_flashdata('message', 'Insert Record Success');
                }
            }
        }
        echo json_encode($data);
    }

    public function import()
    {
        $file_path = $this->input->post('file_path');
        $data = $this->Employment_model->upload_excel($file_path);
        echo json_encode($data);
    }

    public function read($id)
    {
        $row = $this->Employment_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idperson' => $row->idperson,
                'name' => $row->name,
                'numberid' => $row->numberid,
                'nip' => $row->nip,
                'nipy' => $row->nipy,
                'gender' => $row->gender,
                'status' => $row->status,
            );
            $data['title'] = 'Employment';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'employment/Employment_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('employment'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('employment/create_action'),
            'idperson' => set_value('idperson'),
            'name' => set_value('name'),
            'numberid' => set_value('numberid'),
            'nip' => set_value('nip'),
            'nipy' => set_value('nipy'),
            'gender' => set_value('gender'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Employment';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'employment/Employment_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'numberid' => $this->input->post('numberid', TRUE),
                'nip' => $this->input->post('nip', TRUE),
                'nipy' => $this->input->post('nipy', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Employment_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('employment'));
        }
    }

    public function update($id)
    {
        $row = $this->Employment_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('employment/update_action'),
                'idperson' => set_value('idperson', $row->idperson),
                'name' => set_value('name', $row->name),
                'numberid' => set_value('numberid', $row->numberid),
                'nip' => set_value('nip', $row->nip),
                'nipy' => set_value('nipy', $row->nipy),
                'gender' => set_value('gender', $row->gender),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Employment';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'employment/Employment_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('employment'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idperson', TRUE));
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'numberid' => $this->input->post('numberid', TRUE),
                'nip' => $this->input->post('nip', TRUE),
                'nipy' => $this->input->post('nipy', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Employment_model->update($this->input->post('idperson', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('employment'));
        }
    }

    public function delete($id)
    {
        $row = $this->Employment_model->get_by_id($id);

        if ($row) {
            $this->Employment_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('employment'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('employment'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Employment_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('numberid', 'numberid', 'trim|required');
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('nipy', 'nipy', 'trim|required');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('date_born', 'date born', 'trim');
        $this->form_validation->set_rules('where_born', 'where born', 'trim');
        $this->form_validation->set_rules('address', 'address', 'trim');
        $this->form_validation->set_rules('dusun', 'dusun', 'trim');
        $this->form_validation->set_rules('kelurahan', 'kelurahan', 'trim');
        $this->form_validation->set_rules('kecamatan', 'kecamatan', 'trim');
        $this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim');
        $this->form_validation->set_rules('provinsi', 'provinsi', 'trim');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'trim');
        $this->form_validation->set_rules('nik', 'nik', 'trim');
        $this->form_validation->set_rules('kk', 'kk', 'trim');
        $this->form_validation->set_rules('religion', 'religion', 'trim');
        $this->form_validation->set_rules('nationality', 'nationality', 'trim');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('phone', 'phone', 'trim');
        $this->form_validation->set_rules('relationship', 'relationship', 'trim');
        $this->form_validation->set_rules('name_partner', 'name partner', 'trim');
        $this->form_validation->set_rules('childrens', 'childrens', 'trim');
        $this->form_validation->set_rules('name_mother', 'name mother', 'trim');
        $this->form_validation->set_rules('npwp', 'npwp', 'trim');
        $this->form_validation->set_rules('position', 'position', 'trim');
        $this->form_validation->set_rules('status_employment', 'status employment', 'trim');

        $this->form_validation->set_rules('idperson', 'idperson', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Employment.php */
