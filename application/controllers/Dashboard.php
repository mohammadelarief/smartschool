<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->layout->auth();
		$this->load->model('Dashboard_model');
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Dashboard' => '',
		];
		
		$data['count'] = array(
			'pegawai' => array(
				'jml' => get_count('employee', array('status' => '1')),
				'text' => 'Guru & Pegawai',
				'url' => base_url('employment')
			),
			'siswa' => array(
				'jml' => $this->Dashboard_model->get_student_period(),
				'text' => 'Siswa',
				'url' => base_url('student')
			),
			'kelas' => array(
				'jml' => $this->Dashboard_model->get_class_period(),
				'text' => 'Kelas',
				'url' => base_url('classes')
			)
		);
		$data['tapel'] = array(
			'periode' => 'Tahun Pelajaran ' . get_data_custom('period', array('status' => '1'), array('description')),
			'semester' => 'Semester ' . get_data_custom('semester', array('status' => '1'), array('description'))
		);
		// $data['code_js'] = 'Dashboard/codejs';
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
