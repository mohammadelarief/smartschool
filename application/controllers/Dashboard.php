<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout->auth();
		// $this->layout->validate_token();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Dashboard' => '',
		];
		// $user_conditions = ;
		$data['count'] = array(
			'pegawai' => array(
				'jml' => get_count('employee', array('status' => '1')),
				'text' => 'Guru & Pegawai',
				'url' => base_url('employment')
			),
			'siswa' => array(
				'jml' => get_count('person', array('status' => '1')),
				'text' => 'Siswa',
				'url' => base_url('student')
			)
		);
		$data['code_js'] = 'Dashboard/codejs';
		$data['page'] = 'Dashboard/Index';
		$this->load->view('template/backend', $data);
	}
	function printSessions()
	{
		echo "<pre>";

		print_r($this->session->userdata());

		echo "</pre>";
	}
}
