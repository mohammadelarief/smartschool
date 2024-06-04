<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Person_detail extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$c_url = $this->router->fetch_class();
		$this->layout->auth();
		$this->layout->auth_privilege($c_url);
		$this->load->model('Person_detail_model');
		$this->load->library('form_validation');
		$this->load->library('datatables');
	}

	public function index()
	{
		$data['title'] = 'Person Detail';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Person Detail' => '',
		];
		$data['code_js'] = 'person_detail/codejs';
		$data['page'] = 'person_detail/Person_detail_list';
		$data['modal'] = 'person_detail/Person_detail_modal';
		$this->load->view('template/backend', $data);
	}

	public function json()
	{
		header('Content-Type: application/json');
		echo $this->Person_detail_model->json();
	}

	public function json_get()
	{
		$id = $this->input->post("id");
		$row = $this->Person_detail_model->get_by_id($id);

		echo json_encode($row);
	}

	public function json_form()
	{
		$this->_rules();
		$data = array('status' => false, 'messages' => array(), 'msg' => '');
		if ($this->form_validation->run() === FALSE) {
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
			$data['status'] = false;
			$data['msg'] = 'Error';
		} else {
			$act = isset($_POST['actions']) ? $_POST['actions'] : '';
			if ($act == 'Edit') {
				$id = $this->input->post('id', TRUE);
				$data = array(
					'person_id' => $this->input->post('person_id', TRUE),
					'date_born' => $this->input->post('date_born', TRUE),
					'where_born' => $this->input->post('where_born', TRUE),
					'address' => $this->input->post('address', TRUE),
					'dusun' => $this->input->post('dusun', TRUE),
					'kelurahan' => $this->input->post('kelurahan', TRUE),
					'kecamatan' => $this->input->post('kecamatan', TRUE),
					'kabupaten' => $this->input->post('kabupaten', TRUE),
					'provinsi' => $this->input->post('provinsi', TRUE),
					'zipcode' => $this->input->post('zipcode', TRUE),
					'nik' => $this->input->post('nik', TRUE),
					'kk' => $this->input->post('kk', TRUE),
					'religion' => $this->input->post('religion', TRUE),
					'nationality' => $this->input->post('nationality', TRUE),
					'anak_ke' => $this->input->post('anak_ke', TRUE),
					'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
					'weight' => $this->input->post('weight', TRUE),
					'height' => $this->input->post('height', TRUE),
					'email' => $this->input->post('email', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'name_father' => $this->input->post('name_father', TRUE),
					'name_mother' => $this->input->post('name_mother', TRUE),
					'nik_father' => $this->input->post('nik_father', TRUE),
					'nik_mother' => $this->input->post('nik_mother', TRUE),
					'work_father' => $this->input->post('work_father', TRUE),
					'education_father' => $this->input->post('education_father', TRUE),
					'earnings_father' => $this->input->post('earnings_father', TRUE),
					'phone_father' => $this->input->post('phone_father', TRUE),
					'work_mother' => $this->input->post('work_mother', TRUE),
					'education_mother' => $this->input->post('education_mother', TRUE),
					'earnings_mother' => $this->input->post('earnings_mother', TRUE),
					'phone_mother' => $this->input->post('phone_mother', TRUE),
				);

				$update = $this->Person_detail_model->update($id, $data);
				if ($update) {
					$data['status'] = true;
					$data['msg'] = 'Success to update data';
				} else {
					$data['status'] = false;
					$data['msg'] = 'Failed to update data';
					foreach ($_POST as $key => $value) {
						$data['messages'][$key] = form_error($key);
					}
				}
			} else {
				$data = array(
					'person_id' => $this->input->post('person_id', TRUE),
					'date_born' => $this->input->post('date_born', TRUE),
					'where_born' => $this->input->post('where_born', TRUE),
					'address' => $this->input->post('address', TRUE),
					'dusun' => $this->input->post('dusun', TRUE),
					'kelurahan' => $this->input->post('kelurahan', TRUE),
					'kecamatan' => $this->input->post('kecamatan', TRUE),
					'kabupaten' => $this->input->post('kabupaten', TRUE),
					'provinsi' => $this->input->post('provinsi', TRUE),
					'zipcode' => $this->input->post('zipcode', TRUE),
					'nik' => $this->input->post('nik', TRUE),
					'kk' => $this->input->post('kk', TRUE),
					'religion' => $this->input->post('religion', TRUE),
					'nationality' => $this->input->post('nationality', TRUE),
					'anak_ke' => $this->input->post('anak_ke', TRUE),
					'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
					'weight' => $this->input->post('weight', TRUE),
					'height' => $this->input->post('height', TRUE),
					'email' => $this->input->post('email', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'name_father' => $this->input->post('name_father', TRUE),
					'name_mother' => $this->input->post('name_mother', TRUE),
					'nik_father' => $this->input->post('nik_father', TRUE),
					'nik_mother' => $this->input->post('nik_mother', TRUE),
					'work_father' => $this->input->post('work_father', TRUE),
					'education_father' => $this->input->post('education_father', TRUE),
					'earnings_father' => $this->input->post('earnings_father', TRUE),
					'phone_father' => $this->input->post('phone_father', TRUE),
					'work_mother' => $this->input->post('work_mother', TRUE),
					'education_mother' => $this->input->post('education_mother', TRUE),
					'earnings_mother' => $this->input->post('earnings_mother', TRUE),
					'phone_mother' => $this->input->post('phone_mother', TRUE),
				);
				$insert = $this->Person_detail_model->insert($data);
				if ($insert) {
					$data['status'] = true;
					$data['msg'] = 'Success to insert data';
				} else {
					$data['status'] = false;
					$data['msg'] = 'Failed to insert data';
					foreach ($_POST as $key => $value) {
						$data['messages'][$key] = form_error($key);
					}
				}
			}
		}
		echo json_encode($data);
	}

	public function read($id)
	{
		$row = $this->Person_detail_model->get_by_id($id);
		if ($row) {
			$data = array(
				'id' => $row->id,
				'person_id' => $row->person_id,
				'date_born' => $row->date_born,
				'where_born' => $row->where_born,
				'address' => $row->address,
				'dusun' => $row->dusun,
				'kelurahan' => $row->kelurahan,
				'kecamatan' => $row->kecamatan,
				'kabupaten' => $row->kabupaten,
				'provinsi' => $row->provinsi,
				'zipcode' => $row->zipcode,
				'nik' => $row->nik,
				'kk' => $row->kk,
				'religion' => $row->religion,
				'nationality' => $row->nationality,
				'anak_ke' => $row->anak_ke,
				'jumlah_saudara_kandung' => $row->jumlah_saudara_kandung,
				'weight' => $row->weight,
				'height' => $row->height,
				'email' => $row->email,
				'phone' => $row->phone,
				'name_father' => $row->name_father,
				'name_mother' => $row->name_mother,
				'nik_father' => $row->nik_father,
				'nik_mother' => $row->nik_mother,
				'work_father' => $row->work_father,
				'education_father' => $row->education_father,
				'earnings_father' => $row->earnings_father,
				'phone_father' => $row->phone_father,
				'work_mother' => $row->work_mother,
				'education_mother' => $row->education_mother,
				'earnings_mother' => $row->earnings_mother,
				'phone_mother' => $row->phone_mother,
			);
			$data['title'] = 'Person Detail';
			$data['subtitle'] = '';
			$data['crumb'] = [
				'Dashboard' => '',
			];

			$data['page'] = 'person_detail/Person_detail_read';
			$this->load->view('template/backend', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('person_detail'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('person_detail/create_action'),
			'id' => set_value('id'),
			'person_id' => set_value('person_id'),
			'date_born' => set_value('date_born'),
			'where_born' => set_value('where_born'),
			'address' => set_value('address'),
			'dusun' => set_value('dusun'),
			'kelurahan' => set_value('kelurahan'),
			'kecamatan' => set_value('kecamatan'),
			'kabupaten' => set_value('kabupaten'),
			'provinsi' => set_value('provinsi'),
			'zipcode' => set_value('zipcode'),
			'nik' => set_value('nik'),
			'kk' => set_value('kk'),
			'religion' => set_value('religion'),
			'nationality' => set_value('nationality'),
			'anak_ke' => set_value('anak_ke'),
			'jumlah_saudara_kandung' => set_value('jumlah_saudara_kandung'),
			'weight' => set_value('weight'),
			'height' => set_value('height'),
			'email' => set_value('email'),
			'phone' => set_value('phone'),
			'name_father' => set_value('name_father'),
			'name_mother' => set_value('name_mother'),
			'nik_father' => set_value('nik_father'),
			'nik_mother' => set_value('nik_mother'),
			'work_father' => set_value('work_father'),
			'education_father' => set_value('education_father'),
			'earnings_father' => set_value('earnings_father'),
			'phone_father' => set_value('phone_father'),
			'work_mother' => set_value('work_mother'),
			'education_mother' => set_value('education_mother'),
			'earnings_mother' => set_value('earnings_mother'),
			'phone_mother' => set_value('phone_mother'),
		);
		$data['title'] = 'Person Detail';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Dashboard' => '',
		];

		$data['page'] = 'person_detail/Person_detail_form';
		$this->load->view('template/backend', $data);
	}

	public function create_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'person_id' => $this->input->post('person_id', TRUE),
				'date_born' => $this->input->post('date_born', TRUE),
				'where_born' => $this->input->post('where_born', TRUE),
				'address' => $this->input->post('address', TRUE),
				'dusun' => $this->input->post('dusun', TRUE),
				'kelurahan' => $this->input->post('kelurahan', TRUE),
				'kecamatan' => $this->input->post('kecamatan', TRUE),
				'kabupaten' => $this->input->post('kabupaten', TRUE),
				'provinsi' => $this->input->post('provinsi', TRUE),
				'zipcode' => $this->input->post('zipcode', TRUE),
				'nik' => $this->input->post('nik', TRUE),
				'kk' => $this->input->post('kk', TRUE),
				'religion' => $this->input->post('religion', TRUE),
				'nationality' => $this->input->post('nationality', TRUE),
				'anak_ke' => $this->input->post('anak_ke', TRUE),
				'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
				'weight' => $this->input->post('weight', TRUE),
				'height' => $this->input->post('height', TRUE),
				'email' => $this->input->post('email', TRUE),
				'phone' => $this->input->post('phone', TRUE),
				'name_father' => $this->input->post('name_father', TRUE),
				'name_mother' => $this->input->post('name_mother', TRUE),
				'nik_father' => $this->input->post('nik_father', TRUE),
				'nik_mother' => $this->input->post('nik_mother', TRUE),
				'work_father' => $this->input->post('work_father', TRUE),
				'education_father' => $this->input->post('education_father', TRUE),
				'earnings_father' => $this->input->post('earnings_father', TRUE),
				'phone_father' => $this->input->post('phone_father', TRUE),
				'work_mother' => $this->input->post('work_mother', TRUE),
				'education_mother' => $this->input->post('education_mother', TRUE),
				'earnings_mother' => $this->input->post('earnings_mother', TRUE),
				'phone_mother' => $this->input->post('phone_mother', TRUE),
			);
			$this->Person_detail_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('person_detail'));
		}
	}

	public function update($id)
	{
		$row = $this->Person_detail_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('person_detail/update_action'),
				'id' => set_value('id', $row->id),
				'person_id' => set_value('person_id', $row->person_id),
				'date_born' => set_value('date_born', $row->date_born),
				'where_born' => set_value('where_born', $row->where_born),
				'address' => set_value('address', $row->address),
				'dusun' => set_value('dusun', $row->dusun),
				'kelurahan' => set_value('kelurahan', $row->kelurahan),
				'kecamatan' => set_value('kecamatan', $row->kecamatan),
				'kabupaten' => set_value('kabupaten', $row->kabupaten),
				'provinsi' => set_value('provinsi', $row->provinsi),
				'zipcode' => set_value('zipcode', $row->zipcode),
				'nik' => set_value('nik', $row->nik),
				'kk' => set_value('kk', $row->kk),
				'religion' => set_value('religion', $row->religion),
				'nationality' => set_value('nationality', $row->nationality),
				'anak_ke' => set_value('anak_ke', $row->anak_ke),
				'jumlah_saudara_kandung' => set_value('jumlah_saudara_kandung', $row->jumlah_saudara_kandung),
				'weight' => set_value('weight', $row->weight),
				'height' => set_value('height', $row->height),
				'email' => set_value('email', $row->email),
				'phone' => set_value('phone', $row->phone),
				'name_father' => set_value('name_father', $row->name_father),
				'name_mother' => set_value('name_mother', $row->name_mother),
				'nik_father' => set_value('nik_father', $row->nik_father),
				'nik_mother' => set_value('nik_mother', $row->nik_mother),
				'work_father' => set_value('work_father', $row->work_father),
				'education_father' => set_value('education_father', $row->education_father),
				'earnings_father' => set_value('earnings_father', $row->earnings_father),
				'phone_father' => set_value('phone_father', $row->phone_father),
				'work_mother' => set_value('work_mother', $row->work_mother),
				'education_mother' => set_value('education_mother', $row->education_mother),
				'earnings_mother' => set_value('earnings_mother', $row->earnings_mother),
				'phone_mother' => set_value('phone_mother', $row->phone_mother),
			);
			$data['title'] = 'Person Detail';
			$data['subtitle'] = '';
			$data['crumb'] = [
				'Dashboard' => '',
			];

			$data['page'] = 'person_detail/Person_detail_form';
			$this->load->view('template/backend', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('person_detail'));
		}
	}

	public function update_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id', TRUE));
		} else {
			$data = array(
				'person_id' => $this->input->post('person_id', TRUE),
				'date_born' => $this->input->post('date_born', TRUE),
				'where_born' => $this->input->post('where_born', TRUE),
				'address' => $this->input->post('address', TRUE),
				'dusun' => $this->input->post('dusun', TRUE),
				'kelurahan' => $this->input->post('kelurahan', TRUE),
				'kecamatan' => $this->input->post('kecamatan', TRUE),
				'kabupaten' => $this->input->post('kabupaten', TRUE),
				'provinsi' => $this->input->post('provinsi', TRUE),
				'zipcode' => $this->input->post('zipcode', TRUE),
				'nik' => $this->input->post('nik', TRUE),
				'kk' => $this->input->post('kk', TRUE),
				'religion' => $this->input->post('religion', TRUE),
				'nationality' => $this->input->post('nationality', TRUE),
				'anak_ke' => $this->input->post('anak_ke', TRUE),
				'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung', TRUE),
				'weight' => $this->input->post('weight', TRUE),
				'height' => $this->input->post('height', TRUE),
				'email' => $this->input->post('email', TRUE),
				'phone' => $this->input->post('phone', TRUE),
				'name_father' => $this->input->post('name_father', TRUE),
				'name_mother' => $this->input->post('name_mother', TRUE),
				'nik_father' => $this->input->post('nik_father', TRUE),
				'nik_mother' => $this->input->post('nik_mother', TRUE),
				'work_father' => $this->input->post('work_father', TRUE),
				'education_father' => $this->input->post('education_father', TRUE),
				'earnings_father' => $this->input->post('earnings_father', TRUE),
				'phone_father' => $this->input->post('phone_father', TRUE),
				'work_mother' => $this->input->post('work_mother', TRUE),
				'education_mother' => $this->input->post('education_mother', TRUE),
				'earnings_mother' => $this->input->post('earnings_mother', TRUE),
				'phone_mother' => $this->input->post('phone_mother', TRUE),
			);

			$this->Person_detail_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('person_detail'));
		}
	}

	public function delete($id)
	{
		$row = $this->Person_detail_model->get_by_id($id);

		if ($row) {
			$this->Person_detail_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('person_detail'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('person_detail'));
		}
	}

	public function deletebulk()
	{
		$delete = $this->Person_detail_model->deletebulk();
		if ($delete) {
			$this->session->set_flashdata('message', 'Delete Record Success');
		} else {
			$this->session->set_flashdata('message_error', 'Delete Record failed');
		}
		echo $delete;
	}

	public function _rules()
	{
		$this->form_validation->set_rules('person_id', 'person id', 'trim|required');
		$this->form_validation->set_rules('date_born', 'date born', 'trim|required');
		$this->form_validation->set_rules('where_born', 'where born', 'trim|required');
		$this->form_validation->set_rules('address', 'address', 'trim|required');
		$this->form_validation->set_rules('dusun', 'dusun', 'trim|required');
		$this->form_validation->set_rules('kelurahan', 'kelurahan', 'trim|required');
		$this->form_validation->set_rules('kecamatan', 'kecamatan', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'provinsi', 'trim|required');
		$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required');
		$this->form_validation->set_rules('nik', 'nik', 'trim|required');
		$this->form_validation->set_rules('kk', 'kk', 'trim|required');
		$this->form_validation->set_rules('religion', 'religion', 'trim|required');
		$this->form_validation->set_rules('nationality', 'nationality', 'trim|required');
		$this->form_validation->set_rules('anak_ke', 'anak ke', 'trim|required');
		$this->form_validation->set_rules('jumlah_saudara_kandung', 'jumlah saudara kandung', 'trim|required');
		$this->form_validation->set_rules('weight', 'weight', 'trim|required');
		$this->form_validation->set_rules('height', 'height', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('phone', 'phone', 'trim|required');
		$this->form_validation->set_rules('name_father', 'name father', 'trim|required');
		$this->form_validation->set_rules('name_mother', 'name mother', 'trim|required');
		$this->form_validation->set_rules('nik_father', 'nik father', 'trim|required');
		$this->form_validation->set_rules('nik_mother', 'nik mother', 'trim|required');
		$this->form_validation->set_rules('work_father', 'work father', 'trim|required');
		$this->form_validation->set_rules('education_father', 'education father', 'trim|required');
		$this->form_validation->set_rules('earnings_father', 'earnings father', 'trim|required');
		$this->form_validation->set_rules('phone_father', 'phone father', 'trim|required');
		$this->form_validation->set_rules('work_mother', 'work mother', 'trim|required');
		$this->form_validation->set_rules('education_mother', 'education mother', 'trim|required');
		$this->form_validation->set_rules('earnings_mother', 'earnings mother', 'trim|required');
		$this->form_validation->set_rules('phone_mother', 'phone mother', 'trim|required');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	}
}

/* End of file Person_detail.php */
