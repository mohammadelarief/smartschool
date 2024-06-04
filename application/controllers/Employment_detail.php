<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Employment_detail extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$c_url = $this->router->fetch_class();
		$this->layout->auth();
		$this->layout->auth_privilege($c_url);
		$this->load->model('Employment_detail_model');
		$this->load->library('form_validation');
		$this->load->library('datatables');
	}

	public function index()
	{
		$data['title'] = 'Employment Detail';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Employment Detail' => '',
		];
		$data['code_js'] = 'employment_detail/codejs';
		$data['page'] = 'employment_detail/Employment_detail_list';
		$data['modal'] = 'employment_detail/Employment_detail_modal';
		$this->load->view('template/backend', $data);
	}

	public function json()
	{
		header('Content-Type: application/json');
		echo $this->Employment_detail_model->json();
	}

	public function json_get()
	{
		$id = $this->input->post("id");
		$row = $this->Employment_detail_model->get_by_id($id);

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
					'email' => $this->input->post('email', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'relationship' => $this->input->post('relationship', TRUE),
					'name_partner' => $this->input->post('name_partner', TRUE),
					'childrens' => $this->input->post('childrens', TRUE),
					'name_mother' => $this->input->post('name_mother', TRUE),
					'npwp' => $this->input->post('npwp', TRUE),
					'position' => $this->input->post('position', TRUE),
					'status_employment' => $this->input->post('status_employment', TRUE),
				);

				$update = $this->Employment_detail_model->update($id, $data);
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
					'email' => $this->input->post('email', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'relationship' => $this->input->post('relationship', TRUE),
					'name_partner' => $this->input->post('name_partner', TRUE),
					'childrens' => $this->input->post('childrens', TRUE),
					'name_mother' => $this->input->post('name_mother', TRUE),
					'npwp' => $this->input->post('npwp', TRUE),
					'position' => $this->input->post('position', TRUE),
					'status_employment' => $this->input->post('status_employment', TRUE),
				);
				$insert = $this->Employment_detail_model->insert($data);
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
		$row = $this->Employment_detail_model->get_by_id($id);
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
				'email' => $row->email,
				'phone' => $row->phone,
				'relationship' => $row->relationship,
				'name_partner' => $row->name_partner,
				'childrens' => $row->childrens,
				'name_mother' => $row->name_mother,
				'npwp' => $row->npwp,
				'position' => $row->position,
				'status_employment' => $row->status_employment,
			);
			$data['title'] = 'Employment Detail';
			$data['subtitle'] = '';
			$data['crumb'] = [
				'Dashboard' => '',
			];

			$data['page'] = 'employment_detail/Employment_detail_read';
			$this->load->view('template/backend', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('employment_detail'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('employment_detail/create_action'),
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
			'email' => set_value('email'),
			'phone' => set_value('phone'),
			'relationship' => set_value('relationship'),
			'name_partner' => set_value('name_partner'),
			'childrens' => set_value('childrens'),
			'name_mother' => set_value('name_mother'),
			'npwp' => set_value('npwp'),
			'position' => set_value('position'),
			'status_employment' => set_value('status_employment'),
		);
		$data['title'] = 'Employment Detail';
		$data['subtitle'] = '';
		$data['crumb'] = [
			'Dashboard' => '',
		];

		$data['page'] = 'employment_detail/Employment_detail_form';
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
				'email' => $this->input->post('email', TRUE),
				'phone' => $this->input->post('phone', TRUE),
				'relationship' => $this->input->post('relationship', TRUE),
				'name_partner' => $this->input->post('name_partner', TRUE),
				'childrens' => $this->input->post('childrens', TRUE),
				'name_mother' => $this->input->post('name_mother', TRUE),
				'npwp' => $this->input->post('npwp', TRUE),
				'position' => $this->input->post('position', TRUE),
				'status_employment' => $this->input->post('status_employment', TRUE),
			);
			$this->Employment_detail_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('employment_detail'));
		}
	}

	public function update($id)
	{
		$row = $this->Employment_detail_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('employment_detail/update_action'),
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
				'email' => set_value('email', $row->email),
				'phone' => set_value('phone', $row->phone),
				'relationship' => set_value('relationship', $row->relationship),
				'name_partner' => set_value('name_partner', $row->name_partner),
				'childrens' => set_value('childrens', $row->childrens),
				'name_mother' => set_value('name_mother', $row->name_mother),
				'npwp' => set_value('npwp', $row->npwp),
				'position' => set_value('position', $row->position),
				'status_employment' => set_value('status_employment', $row->status_employment),
			);
			$data['title'] = 'Employment Detail';
			$data['subtitle'] = '';
			$data['crumb'] = [
				'Dashboard' => '',
			];

			$data['page'] = 'employment_detail/Employment_detail_form';
			$this->load->view('template/backend', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('employment_detail'));
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
				'email' => $this->input->post('email', TRUE),
				'phone' => $this->input->post('phone', TRUE),
				'relationship' => $this->input->post('relationship', TRUE),
				'name_partner' => $this->input->post('name_partner', TRUE),
				'childrens' => $this->input->post('childrens', TRUE),
				'name_mother' => $this->input->post('name_mother', TRUE),
				'npwp' => $this->input->post('npwp', TRUE),
				'position' => $this->input->post('position', TRUE),
				'status_employment' => $this->input->post('status_employment', TRUE),
			);

			$this->Employment_detail_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('employment_detail'));
		}
	}

	public function delete($id)
	{
		$row = $this->Employment_detail_model->get_by_id($id);

		if ($row) {
			$this->Employment_detail_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('employment_detail'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('employment_detail'));
		}
	}

	public function deletebulk()
	{
		$delete = $this->Employment_detail_model->deletebulk();
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
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('phone', 'phone', 'trim|required');
		$this->form_validation->set_rules('relationship', 'relationship', 'trim|required');
		$this->form_validation->set_rules('name_partner', 'name partner', 'trim|required');
		$this->form_validation->set_rules('childrens', 'childrens', 'trim|required');
		$this->form_validation->set_rules('name_mother', 'name mother', 'trim|required');
		$this->form_validation->set_rules('npwp', 'npwp', 'trim|required');
		$this->form_validation->set_rules('position', 'position', 'trim|required');
		$this->form_validation->set_rules('status_employment', 'status employment', 'trim|required');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	}
}

/* End of file Employment_detail.php */
