<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parent__model extends CI_Model
{

    public $table = 'parent';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id,idparent,name,gender,nik,work,education,earnings,phone_number,position,status');
        $this->datatables->from('parent');
        //add this line for join
        //$this->datatables->join('table2', 'parent.field = table2.field');
$this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>'."  ".anchor(site_url('parent_/delete/$1'),'<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'parent_/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'id');return $this->datatables->generate();
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
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('idparent', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('gender', $q);
	$this->db->or_like('nik', $q);
	$this->db->or_like('work', $q);
	$this->db->or_like('education', $q);
	$this->db->or_like('earnings', $q);
	$this->db->or_like('phone_number', $q);
	$this->db->or_like('position', $q);
	$this->db->or_like('status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('idparent', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('gender', $q);
	$this->db->or_like('nik', $q);
	$this->db->or_like('work', $q);
	$this->db->or_like('education', $q);
	$this->db->or_like('earnings', $q);
	$this->db->or_like('phone_number', $q);
	$this->db->or_like('position', $q);
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
    function deletebulk(){
        $data = $this->input->post('msg_', TRUE);
        $arr_id = explode(",", $data); 
        $this->db->where_in($this->id, $arr_id);
        return $this->db->delete($this->table);
    }

}