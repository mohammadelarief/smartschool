<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Helpers extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->library('encryption');
        $this->load->model('Student_model');
    }
    public function uniqid()
    {
        $var = $this->input->post('_uniq');
        $result = _unix_id($var);
        $response = array(
            'hasil' => $result
        );
        echo json_encode($response);
    }

    public function encrypt_($encrypted_data)
    {
        // Dekripsi data
        $decrypted_data = $this->encryption->decrypt(urldecode($encrypted_data));

        // Redirect atau lakukan operasi yang sesuai, misalnya mendownload file
        redirect(base_url($decrypted_data));
    }

    function add_ajax_kab($id_prov)
    {
        $query = $this->db->get_where('ind_kabupaten', array('provinsiId' => $id_prov));
        $data = "<option value='' selected disabled hidden>- Pilih Kabupaten -</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->kabupatenId . "'>" . $value->kabupatenNama . "</option>";
        }
        echo $data;
    }

    function add_ajax_kec($id_kab)
    {
        $query = $this->db->get_where('ind_kecamatan', array('kabupatenId' => $id_kab));
        $data = "<option value='' selected disabled hidden> - Pilih Kecamatan - </option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->kecamatanId . "'>" . $value->kecamatanNama . "</option>";
        }
        echo $data;
    }

    function add_ajax_des($id_kec)
    {
        $query = $this->db->get_where('ind_desa', array('kecamatanId' => $id_kec));
        $data = "<option value='' selected disabled hidden> - Pilih Kelurahan - </option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->desaId . "'>" . $value->desaNama . "</option>";
        }
        echo $data;
    }
    function add_ajax_kodepos($id_des)
    {
        $query = $this->db->get_where('ind_desa', array('desaId' => $id_des));
        // $query = $this->db->query("SELECT kodepos FROM daruttaqwa_referensi.ind_desa WHERE desaId='$id_des';");
        $data = "<option value='' selected disabled hidden> - Pilih Kode Pos - </option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->kodepos . "'>" . $value->kodepos . "</option>";
        }
        echo $data;
    }

    function get_filter_kelas()
    {
        $periode = $this->input->post('periode');
        // print_r($idunit);
        $data = $this->Student_model->get_class($periode);
        echo json_encode($data);
    }
    function next_period()
    {
        $periode = $this->input->post('periode');
        // print_r($idunit);
        $data = $this->Student_model->next_period($periode);
        echo json_encode($data);
    }
    function get_kelas()
    {
        $periode = $this->input->post('periode');
        $jenjang = $this->input->post('jenjang');
        $type = $this->input->post('type');
        // 1 : pindah kelas ; 2 : pindah tingkat
        $types = $type == 'JM1716537721T7T3' ? '1' : '2';

        $data = $this->Student_model->get_class_bymutation($periode, $jenjang, $types);
        echo json_encode($data);
    }

    public function form_excel()
    {
        // $data = array(); // Buat variabel $data sebagai array

        $upload = upload_file_();

        if (isset($upload['error'])) {
            echo json_encode($upload);
        } else {
            // Menampilkan data dari Excel yang diunggah
            echo json_encode($upload);
        }
    }

    public function get_excel_data()
    {
        $file_path = $this->input->post('file_path');
        $data = read_excel_($file_path);
        echo json_encode($data);
    }

    public function sess_data()
    {
        $session_data = get_session_data();
        echo json_encode($session_data);
    }
}
