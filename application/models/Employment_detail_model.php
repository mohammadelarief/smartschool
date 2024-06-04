<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employment_detail_model extends CI_Model
{

    public $table = 'employee_detail';
    public $id = 'id';
    public $nil = 'person_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('id,person_id,date_born,where_born,address,dusun,kelurahan,kecamatan,kabupaten,provinsi,zipcode,nik,kk,religion,nationality,email,phone,relationship,name_partner,childrens,name_mother,npwp,position,status_employment');
        $this->datatables->from('employee_detail');
        //add this line for join
        //$this->datatables->join('table2', 'employee_detail.field = table2.field');
        $this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('employment_detail/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'employment_detail/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'id');
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
        $this->db->where($this->nil, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id', $q);
        $this->db->or_like('person_id', $q);
        $this->db->or_like('date_born', $q);
        $this->db->or_like('where_born', $q);
        $this->db->or_like('address', $q);
        $this->db->or_like('dusun', $q);
        $this->db->or_like('kelurahan', $q);
        $this->db->or_like('kecamatan', $q);
        $this->db->or_like('kabupaten', $q);
        $this->db->or_like('provinsi', $q);
        $this->db->or_like('zipcode', $q);
        $this->db->or_like('nik', $q);
        $this->db->or_like('kk', $q);
        $this->db->or_like('religion', $q);
        $this->db->or_like('nationality', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('phone', $q);
        $this->db->or_like('relationship', $q);
        $this->db->or_like('name_partner', $q);
        $this->db->or_like('childrens', $q);
        $this->db->or_like('name_mother', $q);
        $this->db->or_like('npwp', $q);
        $this->db->or_like('position', $q);
        $this->db->or_like('status_employment', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('person_id', $q);
        $this->db->or_like('date_born', $q);
        $this->db->or_like('where_born', $q);
        $this->db->or_like('address', $q);
        $this->db->or_like('dusun', $q);
        $this->db->or_like('kelurahan', $q);
        $this->db->or_like('kecamatan', $q);
        $this->db->or_like('kabupaten', $q);
        $this->db->or_like('provinsi', $q);
        $this->db->or_like('zipcode', $q);
        $this->db->or_like('nik', $q);
        $this->db->or_like('kk', $q);
        $this->db->or_like('religion', $q);
        $this->db->or_like('nationality', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('phone', $q);
        $this->db->or_like('relationship', $q);
        $this->db->or_like('name_partner', $q);
        $this->db->or_like('childrens', $q);
        $this->db->or_like('name_mother', $q);
        $this->db->or_like('npwp', $q);
        $this->db->or_like('position', $q);
        $this->db->or_like('status_employment', $q);
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
        $this->db->where($this->nil, $id);
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
