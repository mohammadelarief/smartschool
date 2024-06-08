<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutation_model extends CI_Model
{

    public $table = 'mutation';
    public $id = 'idmutation';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('m.idmutation,m.cfg_mutation_id,m.student_id,m.person_id,m.new_classes,m.old_classes,m.date_mutation,m.date_process,m.keterangan,m.user_id,m.status,cm.title,p.gender,p.name');
        $this->datatables->from('mutation m');
        //add this line for join
        $this->datatables->join('cfg_mutation cm', 'cm.idmutasi = m.cfg_mutation_id');
        $this->datatables->join('person p', 'p.numberid = m.person_id');
        // $this->datatables->add_column(
        //     'action',
        //     '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>'
        //     // . "  " . anchor(site_url('mutation/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'mutation/delete/$1\')" data-toggle="tooltip" title="Delete"')
        //     ,
        //     'idmutation'
        // );
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
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('idmutation', $q);
        $this->db->or_like('idmutation', $q);
        $this->db->or_like('cfg_mutation_id', $q);
        $this->db->or_like('student_id', $q);
        $this->db->or_like('person_id', $q);
        $this->db->or_like('new_classes', $q);
        $this->db->or_like('old_classes', $q);
        $this->db->or_like('date_mutation', $q);
        $this->db->or_like('date_process', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->or_like('user_id', $q);
        $this->db->or_like('status', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idmutation', $q);
        $this->db->or_like('idmutation', $q);
        $this->db->or_like('cfg_mutation_id', $q);
        $this->db->or_like('student_id', $q);
        $this->db->or_like('person_id', $q);
        $this->db->or_like('new_classes', $q);
        $this->db->or_like('old_classes', $q);
        $this->db->or_like('date_mutation', $q);
        $this->db->or_like('date_process', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->or_like('user_id', $q);
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

    function update_student($id, $data)
    {
        $this->db->where('idstudent', $id);
        $this->db->update('student', $data);
        return $this->db->affected_rows() > 0;
    }

    function insert_student($data)
    {
        $this->db->insert('student', $data);
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

    function penempatanbulk()
    {
        $datas = $this->input->post('msg', TRUE);
        $arr_id = explode(",", $datas);
        $datass = array();

        $index = 0;
        foreach ($arr_id as $nis) {
            array_push($datass, array(
                'idsiswa' => _unix_id("S"),
                'idpdb' => $nis,
                // 'idunit' => $this->input->post('unit', TRUE),
                'idkelas' => $this->input->post('kelas', TRUE),
                // 'status_daftar' => 1,
            ));
            $index++;
        }
        return $this->db->insert_batch('penempatan', $datass);
    }

    function insert_bulk($data)
    {
        $this->db->insert('student', $data);
        return $this->db->affected_rows() > 0;
    }

    function update_bulk($id, $data)
    {
        $this->db->where('idstudent', $id);
        $this->db->update('student', $data);
        return $this->db->affected_rows() > 0;
    }
}
