<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable_model extends CI_Model
{

    // public $table = 'cfg_subject';
    // public $id = 'idsubject';
    // public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
    public function get_all_classes()
    {

        $this->db->join('period p', 'p.name_period = c.period_id');
        $this->db->where('p.status', 1);
        $query = $this->db->get('class c');
        return $query->result();
    }
    public function get_all_jenjang_classes()
    {
        $this->db->select('c.jenjang');
        $this->db->join('period p', 'p.name_period = c.period_id');
        $this->db->where('p.status', 1);
        $this->db->group_by('c.jenjang');
        $query = $this->db->get('class c');
        return $query->result();
    }
    public function get_subjects_by_class($class_id)
    {
        $this->db->select('l.idlesson, l.subject_id, e.name, s.full_name');
        $this->db->from('lesson l');
        $this->db->join('period p', 'p.name_period = l.period_id');
        $this->db->join('cfg_subject s', 's.idsubject = l.subject_id');
        $this->db->join('employee e', 'e.numberid = l.employee_id');
        $this->db->where('p.status', 1);
        $this->db->where('l.class_id', $class_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function save_timetable($data)
    {
        $this->db->insert('timetable', $data);
    }

    public function update_timetable($data, $condition)
    {
        $this->db->where($condition);
        $this->db->update('timetable', $data);
    }

    public function timetable_exists($condition)
    {
        $this->db->from('timetable');
        $this->db->where($condition);
        return $this->db->count_all_results() > 0;
    }

    public function get_all_timetable($id)
    {
        $this->db->select('*');
        $this->db->from('timetable');
        $this->db->where('idtimetable', $id);
        $query = $this->db->get();
        return $query->result();
    }
}
