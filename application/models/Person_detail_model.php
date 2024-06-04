<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Person_detail_model extends CI_Model
{

	public $table = 'person_detail';
	public $id = 'id';
	public $nis = 'person_id';
	public $order = 'DESC';

	function __construct()
	{
		parent::__construct();
	}

	// datatables
	function json()
	{
		$this->datatables->select('id,person_id,date_born,where_born,address,dusun,kelurahan,kecamatan,kabupaten,provinsi,zipcode,nik,kk,religion,nationality,anak_ke,jumlah_saudara_kandung,weight,height,email,phone,name_father,name_mother,nik_father,nik_mother,work_father,education_father,earnings_father,phone_father,work_mother,education_mother,earnings_mother,phone_mother');
		$this->datatables->from('person_detail');
		//add this line for join
		//$this->datatables->join('table2', 'person_detail.field = table2.field');
		$this->datatables->add_column('action', '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>' . "  " . anchor(site_url('person_detail/delete/$1'), '<i class="fa fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="return confirmdelete(\'person_detail/delete/$1\')" data-toggle="tooltip" title="Delete"'), 'id');
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
		$this->db->or_like('anak_ke', $q);
		$this->db->or_like('jumlah_saudara_kandung', $q);
		$this->db->or_like('weight', $q);
		$this->db->or_like('height', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('phone', $q);
		$this->db->or_like('name_father', $q);
		$this->db->or_like('name_mother', $q);
		$this->db->or_like('nik_father', $q);
		$this->db->or_like('nik_mother', $q);
		$this->db->or_like('work_father', $q);
		$this->db->or_like('education_father', $q);
		$this->db->or_like('earnings_father', $q);
		$this->db->or_like('phone_father', $q);
		$this->db->or_like('work_mother', $q);
		$this->db->or_like('education_mother', $q);
		$this->db->or_like('earnings_mother', $q);
		$this->db->or_like('phone_mother', $q);
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
		$this->db->or_like('anak_ke', $q);
		$this->db->or_like('jumlah_saudara_kandung', $q);
		$this->db->or_like('weight', $q);
		$this->db->or_like('height', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('phone', $q);
		$this->db->or_like('name_father', $q);
		$this->db->or_like('name_mother', $q);
		$this->db->or_like('nik_father', $q);
		$this->db->or_like('nik_mother', $q);
		$this->db->or_like('work_father', $q);
		$this->db->or_like('education_father', $q);
		$this->db->or_like('earnings_father', $q);
		$this->db->or_like('phone_father', $q);
		$this->db->or_like('work_mother', $q);
		$this->db->or_like('education_mother', $q);
		$this->db->or_like('earnings_mother', $q);
		$this->db->or_like('phone_mother', $q);
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
		$this->db->where($this->nis, $id);
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
