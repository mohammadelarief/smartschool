<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Student extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        // $this->layout->validate_token();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Student_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Student';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Student' => '',
        ];
        $get_mutation = $this->db->select('*')->from('cfg_mutation')->get();
        $data['mutation_cfg'] = $get_mutation->result();
        $get_prov = $this->db->select('*')->from('ind_provinsi')->get();
        $data['provinsi_ind'] = $get_prov->result();
        $data['filter'] = 'template/filter';
        $data['code_js'] = 'student/codejs';
        $data['page'] = 'student/Student_list';
        $data['modal'] = 'student/Student_modal';
        $this->load->view('template/backend', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Student_model->json();
    }
    public function json_naik()
    {
        header('Content-Type: application/json');
        echo $this->Student_model->json_naik();
    }

    // function get_kelas()
    // {
    //     $periode = $this->input->post('periode');
    //     // print_r($idunit);
    //     $data = $this->Student_model->get_class($periode);
    //     echo json_encode($data);
    // }

    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->Student_model->search_idperson($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'value' => $row->numberid,
                        'label'    => $row->name,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    public function generate_excel()
    {
        $prd = $this->input->post('periode');
        // Buat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();

        // Tambahkan data header pada Sheet 1
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Template Siswa');
        $sheet1->setCellValue('A1', 'NO');
        $sheet1->setCellValue('B1', 'NIS');
        $sheet1->setCellValue('C1', 'KELAS');
        $sheet1->setCellValue('D1', 'STATUS');
        $sheet1->setCellValue('E1', 'ID KELAS');

        // Buat sheet baru untuk data dari database
        $spreadsheet->createSheet();
        $sheet2 = $spreadsheet->setActiveSheetIndex(1);
        $sheet2->setTitle('Kelas');

        // Tambahkan header manual pada Sheet 2
        $sheet2->setCellValue('A1', 'ID KELAS');
        $sheet2->setCellValue('B1', 'PERIODE');
        $sheet2->setCellValue('C1', 'NAMA KELAS');

        // Ambil data dari database
        $this->db->select('idclass, period_id, name_class');
        $this->db->from('class');
        $this->db->where('period_id', $prd);
        $this->db->where('status', 1);

        // $query = $this->db->get_where('class', array('period_id' => $prd, 'status' => 1)); // Ganti 'your_table_name' dengan nama tabel Anda
        $query = $this->db->get();
        $data = $query->result_array();

        // echo "Data dari Database: ";
        // print_r($data);
        // echo "<br>";

        // Isi data pada Sheet 2 mulai dari baris ke-2
        $rowNumber = 2;
        foreach ($data as $row) {
            $col = 'A';
            foreach ($row as $cell) {
                $sheet2->setCellValue('A' . $rowNumber, $row['name_class']);
                $sheet2->setCellValue('B' . $rowNumber, $row['period_id']);
                $sheet2->setCellValue('C' . $rowNumber, $row['idclass']);
                $col++;
            }
            $rowNumber++;
        }

        // Dapatkan jumlah baris data di Sheet 2
        $rowCount = $rowNumber - 1;

        // Tambahkan formula VLOOKUP di kolom C baris kedua pada Sheet 1
        $sheet1->setCellValue('E2', '=VLOOKUP(C2, Kelas!$A$2:$C$' . $rowCount . ', 3, FALSE)');

        // Set Sheet 1 sebagai aktif
        $spreadsheet->setActiveSheetIndex(0);

        // Buat writer untuk menulis file ke output
        $writer = new Xlsx($spreadsheet);
        $fileName = 'impor_student.xlsx';
        $filePath = FCPATH . 'assets/templates/' . $fileName; // Pastikan folder uploads memiliki izin tulis

        // Simpan file ke server
        $writer->save($filePath);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success']));
    }

    public function download_excel()
    {
        $fileName = 'impor_student.xlsx';
        $filePath = FCPATH . 'assets/templates/' . $fileName;

        // Set header untuk download
        force_download($filePath, NULL);

        // Hapus file setelah didownload
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function import()
    {
        $file_path = $this->input->post('file_path');
        $data = $this->Student_model->upload_excel($file_path);
        echo json_encode($data);
    }

    public function json_get()
    {
        $id = $this->input->post("id");
        $row = $this->Student_model->get_by_id($id);

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
                $id = $this->input->post('idstudent', TRUE);
                $data = array(
                    'idstudent' => $this->input->post('idstudent', TRUE),
                    'class_id' => $this->input->post('class_id', TRUE),
                    'personid' => $this->input->post('personid', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );

                $update = $this->Student_model->update($id, $data);
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
                    'idstudent' => $this->input->post('idstudent', TRUE),
                    'class_id' => $this->input->post('class_id', TRUE),
                    'personid' => $this->input->post('personid', TRUE),
                    'status' => $this->input->post('status', TRUE),
                );
                if (!$this->Student_model->is_exist($this->input->post('idstudent'))) {

                    $insert = $this->Student_model->insert($data);
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
        $row = $this->Student_model->get_by_id($id);
        if ($row) {
            $data = array(
                'idstudent' => $row->idstudent,
                'class_id' => $row->class_id,
                'personid' => $row->personid,
                'status' => $row->status,
            );
            $data['title'] = 'Student';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'student/Student_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('student/create_action'),
            'idstudent' => set_value('idstudent'),
            'class_id' => set_value('class_id'),
            'personid' => set_value('personid'),
            'status' => set_value('status'),
        );
        $data['title'] = 'Student';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'student/Student_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'idstudent' => $this->input->post('idstudent', TRUE),
                'class_id' => $this->input->post('class_id', TRUE),
                'personid' => $this->input->post('personid', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            if (!$this->Student_model->is_exist($this->input->post('idstudent'))) {
                $this->Student_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('student'));
            } else {
                $this->create();
                $this->session->set_flashdata('message', 'Create Record Faild, idstudent is exist');
            }
        }
    }

    public function update($id)
    {
        $row = $this->Student_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('student/update_action'),
                'idstudent' => set_value('idstudent', $row->idstudent),
                'class_id' => set_value('class_id', $row->class_id),
                'personid' => set_value('personid', $row->personid),
                'status' => set_value('status', $row->status),
            );
            $data['title'] = 'Student';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'student/Student_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idstudent', TRUE));
        } else {
            $data = array(
                'idstudent' => $this->input->post('idstudent', TRUE),
                'class_id' => $this->input->post('class_id', TRUE),
                'personid' => $this->input->post('personid', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Student_model->update($this->input->post('idstudent', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('student'));
        }
    }

    public function delete($id)
    {
        $row = $this->Student_model->get_by_id($id);

        if ($row) {
            $this->Student_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('student'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('student'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Student_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('idstudent', 'idstudent', 'trim|required');
        $this->form_validation->set_rules('class_id', 'class id', 'trim|required');
        $this->form_validation->set_rules('personid', 'personid', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('idstudent', 'idstudent', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    }
}

/* End of file Student.php */
