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
        // $idunit = $this->input->post('unit');
        $idkelas = $this->input->post('kelas');
        // if ($idunit == 'all') {
        //     $this->session->set_flashdata('message_error', 'Silahkan Pilih Unit terlebih dahulu');
        // } else {
        if ($idkelas == 'all') {
            $this->session->set_flashdata('message_error', 'Silahkan Pilih Kelas terlebih dahulu');
        } else {
            $this->db->trans_begin();
            $insert = $this->Pdb_model->penempatanbulk();
            if ($insert) {
                $this->session->set_flashdata('message', 'Insert All Record Success');
            } else {
                $this->session->set_flashdata('message_error', 'Insert All Record failed');
            }
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
        // }
    }
}
