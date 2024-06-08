<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kenaikan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->library('form_validation');
        $this->load->model('Mutation_model');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['title'] = 'Mutation';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Mutation' => '',
        ];

        $data['code_js'] = 'mutation/kenaikan_codejs';
        $data['page'] = 'mutation/Kenaikan';
        $data['filter'] = 'template/filter';
        // $data['modal'] = 'mutation/Mutation_modal';
        $this->load->view('template/backend', $data);
    }

    public function naikbulk()
    {
        $this->db->trans_begin();
        $datas = $this->input->post('msg', TRUE);
        $arr_id = explode(",", $datas);
        // $insert_data = array();
        $idkelas = $this->input->post('kelas');

        $index = 0;
        foreach ($arr_id as $nis) {
            $insert_data = array(
                'idstudent' => _unix_id("S"),
                'class_id' => $idkelas,
                'personid' => $nis,
                'status' => '1'
            );
            $s = $this->db->query("
            SELECT * 
            FROM student WHERE personid='{$nis}' and status = '1'
            ")->row();
            $ids = $s->idstudent;
            $update_data = array(
                'kenaikan' => '1',
            );
            $update = $this->Mutation_model->update_bulk($ids, $update_data);
            $insert = $this->Mutation_model->insert_bulk($insert_data);
            $index++;
        }
        
        if ($idkelas == 'all') {
            $this->session->set_flashdata('message_error', 'Silahkan Pilih Kelas terlebih dahulu');
        } else {
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Terjadi kesalahan sistem, silahkan ulangi');
                redirect(site_url('Kenaikan'));
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', 'Insert All Record Success');
                redirect(site_url('Kenaikan'));
            }
            echo $insert;
        }
    }
}
