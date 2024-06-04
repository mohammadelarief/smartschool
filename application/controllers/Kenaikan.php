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
}
