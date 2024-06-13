<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employment_model extends CI_Model
{

    public $table = 'employee';
    public $id = 'idperson';
    public $nil = 'numberid';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('e.idperson,e.name,e.numberid,e.nip,e.nipy,e.gender,e.status,
        (
            select GROUP_CONCAT(ecg1.name_group) 
            from employee_group eg1 
            join employee_cfg_group ecg1 ON ecg1.id = eg1.group_id 
            where eg1.numberid = e.numberid) as grup,
        (
            select GROUP_CONCAT(eg2.description) 
            from employement_group eg2 
            where eg2.numberid = e.numberid) as grup_employement
            ');
        $this->datatables->from('employee e');
        //add this line for join
        // $this->datatables->join('employee_group eg', 'eg.numberid = e.numberid');
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('employment/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'employment/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'numberid');
        return $this->datatables->generate();
    }
    function json_group()
    {
        $periode = $this->input->post('periode');
        $group = $this->input->post('group');
        $this->datatables->select('eg.period_id, eg.numberid, ecg.name_group,e.name,e.gender,e.status
            ');
        $this->datatables->from('employee_group eg');
        //add this line for join
        $this->datatables->join('employee_cfg_group ecg', 'ecg.id = eg.group_id');
        $this->datatables->join('employee e', 'e.numberid = eg.numberid');
        $this->datatables->where("eg.period_id='{$periode}'");
        if ($group != 'all') {
            $this->datatables->where("ecg.id='{$group}'");
        }
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('employment/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'employment/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'numberid');
        return $this->datatables->generate();
    }
    function json_status()
    {
        $periode = $this->input->post('periode');
        $status = $this->input->post('status');
        $this->datatables->select('eg.period_id, eg.numberid, eg.description,e.name,e.gender,e.status
            ');
        $this->datatables->from('employement_group eg');
        //add this line for join
        $this->datatables->join('employee e', 'e.numberid = eg.numberid');
        $this->datatables->where("eg.period_id='{$periode}'");
        if ($status != 'all') {
            $this->datatables->where("eg.description='{$status}'");
        }
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('employment/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'employment/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'numberid');
        return $this->datatables->generate();
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
            $employee_data[] = array(
                'name' => $row['B'], // Insert data nis dari kolom A di excel
                'numberid' => $row['C'], // Insert data nama dari kolom B di excel
                'nip' => $row['D'], // Insert data jenis kelamin dari kolom C di excel
                'gender' => $row['F'], // Insert data alamat dari kolom D di excel
                'status' => $row['G'], // Insert data alamat dari kolom D di excel
                'nipy' => $row['E']
                // Tambahkan kolom sesuai dengan struktur database Anda
            );
            $date = DateTime::createFromFormat('d/m/Y', $row['H']); // adjust format as necessary
            if ($date) {
                $formattedDate = $date->format('Y-m-d');
            } else {
                $formattedDate = null; // or handle invalid date formats as needed
            }
            $employee_data_detail[] = array(
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
                'status_employment' => $row['U'],
                'position' => $row['V'],
                'relationship' => $row['W'],
                'name_partner' => $row['X'],
                'childrens' => $row['Y'],
                'email' => $row['Z'],
                'phone' => $row['AA'],
                'name_mother' => $row['AB'],
                'npwp' => $row['AC']
                // Tambahkan kolom sesuai dengan struktur database Anda
            );
        }
        $this->db->trans_begin();
        $this->insert_multiple('employee', $employee_data);
        $this->insert_multiple('employee_detail', $employee_data_detail);
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
    public function insert_multiple($table, $data)
    {
        $this->db->insert_batch($table, $data);
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
        $this->db->where($this->nil, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('idperson', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('numberid', $q);
        $this->db->or_like('nip', $q);
        $this->db->or_like('nipy', $q);
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
        $this->db->or_like('nip', $q);
        $this->db->or_like('nipy', $q);
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
