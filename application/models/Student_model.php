<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model
{

    public $table = 'student';
    public $id = 'idstudent';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $periode = $this->input->post('periode');
        $kelas = $this->input->post('kls');
        $this->datatables->select('s.idstudent,s.class_id,s.personid,s.status,p.name,p.gender,c.name_class');
        $this->datatables->from('student s');
        //add this line for join
        $this->datatables->join('class c', 'c.idclass = s.class_id');
        $this->datatables->join('person p', 'p.numberid = s.personid');
        $this->datatables->where("c.period_id='{$periode}'");
        $this->datatables->where('s.status', '1');
        if ($kelas != 'all') {
            $this->datatables->where("c.idclass='{$kelas}'");
        }
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('student/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'student/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'idstudent');
        return $this->datatables->generate();
    }

    function get_class($prd)
    {
        $this->db->select('idclass, period_id, name_class');
        $this->db->from('class');
        $this->db->where('period_id', $prd);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }
    function get_class_bymutation($prd, $jenjang, $types)
    {
        $this->db->select('idclass, period_id, name_class');
        $this->db->from('class');
        $this->db->where('period_id', $prd);
        $this->db->where('status', 1);
        if ($types == '1') {
            $this->db->where('jenjang', $jenjang);
        } else {
            $this->db->where('jenjang <>', $jenjang);
        }

        return $this->db->get()->result();
    }

    function next_period($idperiode)
    {
        $per = $this->db->query("
			SELECT end_date 
			FROM period WHERE name_period='{$idperiode}'
		")->row();

        $tglakhir = "9999-99-99";
        if ($per) {
            $tglakhir = $per->end_date;
        }
        $data = $this->db->query("
			SELECT name_period,description 
			FROM period WHERE start_date>'{$tglakhir}'
		")->result();

        return $data;
    }

    function search_idperson($title)
    {
        $this->db->from('person p');
        $this->db->like('p.numberid', $title, 'both');
        $this->db->order_by('p.numberid', 'ASC');
        // $this->db->where('p.tipe =', 'S');
        $this->db->limit(10);
        return $this->db->get()->result();
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
            $student_data[] = array(
                'idstudent' => _unix_id("S"), // Insert data nis dari kolom A di excel
                'personid' => $row['B'], // Insert data jenis kelamin dari kolom C di excel
                'class_id' => $row['E'], // Insert data nama dari kolom B di excel
                'status' => $row['D']
                // Tambahkan kolom sesuai dengan struktur database Anda
            );
        }
        $this->db->trans_begin();
        $this->Student_model->insert_multiple('student', $student_data);
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

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->join('person', 'person.numberid = student.personid');
        $this->db->join('person_detail', 'person_detail.person_id = person.numberid');
        $this->db->join('class', 'class.idclass = student.class_id');

        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('idstudent', $q);
        $this->db->or_like('idstudent', $q);
        $this->db->or_like('class_id', $q);
        $this->db->or_like('personid', $q);
        $this->db->or_like('status', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idstudent', $q);
        $this->db->or_like('idstudent', $q);
        $this->db->or_like('class_id', $q);
        $this->db->or_like('personid', $q);
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
    //check pk data is exists 

    function is_exist($id)
    {
        $query = $this->db->get_where($this->table, array($this->id => $id));
        $count = $query->num_rows();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
