<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Person extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        // $this->layout->validate_token();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Person_model');
        $this->load->model('Person_detail_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->library('encryption');
    }

    public function index()
    {
        $data['title'] = 'Person';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Person' => '',
        ];
        $data['code_js'] = 'person/codejs';
        $data['page'] = 'person/Person_list';
        $data['modal'] = 'person/Person_modal';
        $get_prov = $this->db->select('*')->from('ind_provinsi')->get();
        $data['provinsi_ind'] = $get_prov->result();
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Person_model->json();
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Person_model->get_by_id($id);
        $row_detail = $this->Person_detail_model->get_by_id($id);
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
                    'nisn' => $this->input->post('nisn', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                $data_detail = array(
                    // 'person_id' => $this->input->post('numberid', TRUE),
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
                    'anak_ke' => $this->input->post('anak_ke', TRUE),
                    'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
                    'weight' => $this->input->post('weight', TRUE),
                    'height' => $this->input->post('height', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'name_father' => $this->input->post('name_father', TRUE),
                    'name_mother' => $this->input->post('name_mother', TRUE),
                    'nik_father' => $this->input->post('nik_father', TRUE),
                    'nik_mother' => $this->input->post('nik_mother', TRUE),
                    'work_father' => $this->input->post('work_father', TRUE),
                    'education_father' => $this->input->post('education_father', TRUE),
                    'earnings_father' => $this->input->post('earnings_father', TRUE),
                    'phone_father' => $this->input->post('phone_father', TRUE),
                    'work_mother' => $this->input->post('work_mother', TRUE),
                    'education_mother' => $this->input->post('education_mother', TRUE),
                    'earnings_mother' => $this->input->post('earnings_mother', TRUE),
                    'phone_mother' => $this->input->post('phone_mother', TRUE),
                );
                $this->db->trans_begin();
                $this->Person_model->update($id, $data);
                $this->Person_detail_model->update($nis, $data_detail);
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
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'numberid' => $this->input->post('numberid', TRUE),
                    'nisn' => $this->input->post('nisn', TRUE),
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
                    'anak_ke' => $this->input->post('anak_ke', TRUE),
                    'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
                    'weight' => $this->input->post('weight', TRUE),
                    'height' => $this->input->post('height', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'name_father' => $this->input->post('name_father', TRUE),
                    'name_mother' => $this->input->post('name_mother', TRUE),
                    'nik_father' => $this->input->post('nik_father', TRUE),
                    'nik_mother' => $this->input->post('nik_mother', TRUE),
                    'work_father' => $this->input->post('work_father', TRUE),
                    'education_father' => $this->input->post('education_father', TRUE),
                    'earnings_father' => $this->input->post('earnings_father', TRUE),
                    'phone_father' => $this->input->post('phone_father', TRUE),
                    'work_mother' => $this->input->post('work_mother', TRUE),
                    'education_mother' => $this->input->post('education_mother', TRUE),
                    'earnings_mother' => $this->input->post('earnings_mother', TRUE),
                    'phone_mother' => $this->input->post('phone_mother', TRUE),
                );
                // 
                $this->db->trans_begin();
                $this->Person_model->insert($data);
                $this->Person_detail_model->insert($data_detail);
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
        $data = $this->Person_model->upload_excel($file_path);
        echo json_encode($data);
    }

    public function read($id)
    {
        $row = $this->Person_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idperson' => $row->idperson,
                'name' => $row->name,
                'numberid' => $row->numberid,
                'nisn' => $row->nisn,
                'gender' => $row->gender,
                'status' => $row->status,
            );
            $data['title'] = 'Person';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'person/Person_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('person'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('person/create_action'),
            'idperson' => set_value('idperson'),
            'name' => set_value('name'),
            'numberid' => set_value('numberid'),
            'nisn' => set_value('nisn'),
            'gender' => set_value('gender'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Person';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'person/Person_form';
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
                'nisn' => $this->input->post('nisn', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Person_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('person'));
        }
    }

    public function update($id)
    {
        $row = $this->Person_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('person/update_action'),
                'idperson' => set_value('idperson', $row->idperson),
                'name' => set_value('name', $row->name),
                'numberid' => set_value('numberid', $row->numberid),
                'nisn' => set_value('nisn', $row->nisn),
                'gender' => set_value('gender', $row->gender),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Person';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'person/Person_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('person'));
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
                'nisn' => $this->input->post('nisn', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Person_model->update($this->input->post('idperson', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('person'));
        }
    }

    public function delete($id)
    {
        $row = $this->Person_model->get_by_id($id);

        if ($row) {
            $this->Person_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('person'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('person'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Person_model->deletebulk();
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
        $this->form_validation->set_rules('nisn', 'nisn', 'trim');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('person_id', 'person id', 'trim');
        $this->form_validation->set_rules('date_born', 'date born', 'trim');
        $this->form_validation->set_rules('where_born', 'where born', 'trim');
        $this->form_validation->set_rules('address', 'address', 'trim');
        $this->form_validation->set_rules('dusun', 'dusun', 'trim');
        $this->form_validation->set_rules('kelurahan', 'kelurahan', 'trim');
        $this->form_validation->set_rules('kecamatan', 'kecamatan', 'trim');
        $this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim');
        $this->form_validation->set_rules('provinsi', 'provinsi', 'trim');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'trim|numeric');
        $this->form_validation->set_rules('nik', 'nik', 'trim|numeric|exact_length[16]');
        $this->form_validation->set_rules('kk', 'kk', 'trim|numeric|exact_length[16]');
        $this->form_validation->set_rules('religion', 'religion', 'trim');
        $this->form_validation->set_rules('nationality', 'nationality', 'trim');
        $this->form_validation->set_rules('anak_ke', 'anak ke', 'trim|numeric');
        $this->form_validation->set_rules('jumlah_saudara_kandung', 'jumlah saudara kandung', 'trim|numeric');
        $this->form_validation->set_rules('weight', 'weight', 'trim|numeric');
        $this->form_validation->set_rules('height', 'height', 'trim|numeric');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('phone', 'phone', 'trim|numeric');

        $this->form_validation->set_rules('name_father', 'name father', 'trim');
        $this->form_validation->set_rules('name_mother', 'name mother', 'trim');
        $this->form_validation->set_rules('nik_father', 'nik father', 'trim|numeric|exact_length[16]');
        $this->form_validation->set_rules('nik_mother', 'nik mother', 'trim|numeric|exact_length[16]');
        $this->form_validation->set_rules('work_father', 'work father', 'trim');
        $this->form_validation->set_rules('education_father', 'education father', 'trim');
        $this->form_validation->set_rules('earnings_father', 'earnings father', 'trim');
        $this->form_validation->set_rules('phone_father', 'phone father', 'trim|numeric');
        $this->form_validation->set_rules('work_mother', 'work mother', 'trim');
        $this->form_validation->set_rules('education_mother', 'education mother', 'trim');
        $this->form_validation->set_rules('earnings_mother', 'earnings mother', 'trim');
        $this->form_validation->set_rules('phone_mother', 'phone mother', 'trim|numeric');

        $this->form_validation->set_rules('idperson', 'idperson', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Person.php */
