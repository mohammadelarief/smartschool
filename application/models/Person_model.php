<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Person_model extends CI_Model
{

    public $table = 'person';
    public $id = 'idperson';
    public $nis = 'numberid';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('idperson,name,numberid,nisn,gender,status');
        $this->datatables->from('person');
        //add this line for join
        //$this->datatables->join('table2', 'person.field = table2.field');
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('person/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'person/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'numberid');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->nis, $id);
        return $this->db->get($this->table)->row();
    }

    public function upload_excel($file_path)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
        $sheet_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $data = [];
        $isFirstRow = true;
        foreach ($sheet_data as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Skip the first row
            }
            $person_data[] = array(
                'name' => $row['B'], // Insert data nis dari kolom A di excel
                'numberid' => $row['C'], // Insert data nama dari kolom B di excel
                'nisn' => $row['D'], // Insert data jenis kelamin dari kolom C di excel
                'gender' => $row['F'], // Insert data alamat dari kolom D di excel
                'status' => $row['G'], // Insert data alamat dari kolom D di excel
                'nis_emis' => $row['E']
                // Tambahkan kolom sesuai dengan struktur database Anda
            );
            $date = DateTime::createFromFormat('d/m/Y', $row['H']); // adjust format as necessary
            if ($date) {
                $formattedDate = $date->format('Y-m-d');
            } else {
                $formattedDate = null; // or handle invalid date formats as needed
            }
            $person_data_detail[] = array(
                'person_id' => $row['C'],
                'date_born' => $formattedDate,
                'where_born' => $row['I'],
                'address' => $row['J'],
                'dusun' => $row['K'],
                'kelurahan' => $row['L'],
                'kecamatan' => $row['M'],
                'kabupaten' => $row['N'],
                'provinsi' => $row['O'],
                'zipcode' => $row['P'],
                'nik' => $row['Q'],
                'kk' => $row['R'],
                'religion' => $row['S'],
                'nationality' => $row['T'],
                'anak_ke' => $row['U'],
                'jumlah_saudara_kandung' => $row['V'],
                'weight' => $row['W'],
                'height' => $row['X'],
                'email' => $row['Y'],
                'phone' => $row['Z'],
                'name_father' => $row['AA'],
                'name_mother' => $row['AB'],
                'nik_father' => $row['AC'],
                'nik_mother' => $row['AD'],
                'work_father' => $row['AE'],
                'education_father' => $row['AF'],
                'earnings_father' => $row['AG'],
                'phone_father' => $row['AH'],
                'work_mother' => $row['AI'],
                'education_mother' => $row['AJ'],
                'earnings_mother' => $row['AK'],
                'phone_mother' => $row['AL']
                // Tambahkan kolom sesuai dengan struktur database Anda
            );
        }
        $this->db->trans_begin();
        $this->Person_model->insert_multiple('person', $person_data);
        $this->Person_model->insert_multiple('person_detail', $person_data_detail);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['msg'] = 'Failed to update data';
            $data['status'] = 'error';
            $data['message'] = 'File imported unsuccessfully.';
        } else {
            $this->db->trans_commit();
            // $data['status'] = true;
            $data['msg'] = 'Success to update data';
            $data['status'] = 'success';
            $data['message'] = 'File imported successfully.';
        }
        $result = array('status' => 'success', 'data' => $data);
        return $result;
    }


    // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('idperson', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('numberid', $q);
        $this->db->or_like('nisn', $q);
        $this->db->or_like('gender', $q);
        $this->db->or_like('status', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idperson', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('numberid', $q);
        $this->db->or_like('nisn', $q);
        $this->db->or_like('gender', $q);
        $this->db->or_like('status', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows() > 0;
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows() > 0;
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // delete bulkdata
    function deletebulk()
    {
        $data = $this->input->post('msg_', TRUE);
        $arr_id = explode(",", $data);
        $this->db->where_in($this->id, $arr_id);
        return $this->db->delete($this->table);
    }
}
