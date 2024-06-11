<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cfg_timetable_model extends CI_Model
{

    public $table = 'cfg_timetable';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('c.id,c.idtimetable,c.period_id,c.semester_id,c.keterangan,c.status,s.description');
        $this->datatables->from('cfg_timetable c');
        //add this line for join
        $this->datatables->join('semester s', 's.idsemester = c.semester_id');
        $this->datatables->add_column('action', anchor(site_url('timetable/timetable/$2'), '<i class="fas fa-book-reader"></i>', 'class="btn btn-xs btn-primary"  data-toggle="tooltip" title="Jadwal"') . "  " . '<button onclick="return edit_data(\'$1\')" class="btn btn-xs btn-warning item_edit" data-id="$1"><i class="fa fa-edit"></i></button>', 'id,idtimetable');
        return $this->datatables->generate();
    }

    public function activate_timetable($id, $semester)
    {
        // Set all status to 0
        $this->db->set('status', '0');
        $this->db->where('semester_id', $semester);
        $this->db->update($this->table);

        // Set status of the specified row to 1
        $this->db->set('status', '1');
        $this->db->where($this->id, $id);
        $this->db->where('semester_id', $semester);
        $this->db->update($this->table);
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
        $this->db->like('id', $q);
        $this->db->or_like('idtimetable', $q);
        $this->db->or_like('period_id', $q);
        $this->db->or_like('semester_id', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->or_like('status', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('idtimetable', $q);
        $this->db->or_like('period_id', $q);
        $this->db->or_like('semester_id', $q);
        $this->db->or_like('keterangan', $q);
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
