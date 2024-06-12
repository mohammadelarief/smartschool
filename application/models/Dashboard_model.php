<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_student_period()
    {
        $this->db->from('student s');
        $this->db->join('class c', 'c.idclass = s.class_id');
        $this->db->join('period p', 'p.name_period = c.period_id');
        $this->db->where('p.status', '1');
        return $this->db->count_all_results();
    }

    function get_class_period()
    {
        $this->db->from('class c');
        // $this->db->join('class c', 'c.idclass = s.class_id');
        $this->db->join('period p', 'p.name_period = c.period_id');
        $this->db->where('p.status', '1');
        return $this->db->count_all_results();
    }
}
