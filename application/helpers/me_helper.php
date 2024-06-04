<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('_unix_id')) {
    function _unix_id($input_string)
    {
        // Menggabungkan input string dengan Unix Timestamp
        $timestamp = time();
        $result_string = $input_string . $timestamp;

        // Membuat karakter acak
        $random_chars = '';
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 4;
        for ($i = 0; $i < $length; $i++) {
            $random_chars .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Menggabungkan hasil dengan karakter acak
        $result_string .= $random_chars;

        return $result_string;
    }
}
if (!function_exists('_unix_db_id')) {
    function _unix_db_id($prefix, $table, $col)
    {
        $ci = &get_instance();
        $ci->load->database();

        do {
            $randomString = $prefix . time() . strtoupper(substr(md5(rand()), 0, 4));
            $ci->db->where($col, $randomString);
            $query = $ci->db->get($table); // Ganti 'students' dengan nama tabel Anda
        } while ($query->num_rows() > 0);

        return $randomString;
    }
}
if (!function_exists('cmb_where')) {
    function cmb_where($name, $table, $field, $pk, $selected = null, $where = null, $order = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' class='form-control filter select2' ids='" . $pk . "'>";
        if ($order) {
            $ci->db->order_by($field, $order);
        }
        $data = $ci->db->get_where($table, array($where => 1))->result();
        // $data = $ci->db->get($table)->result();

        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" .  strtoupper($d->$field) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}
if (!function_exists('cmb_dinamis')) {
    function cmb_dinamis($name, $table, $field, $pk, $selected = null, $order = null)
    {
        $ci = get_instance();
        $cmb = '<select class="form-control filter select2" id="' . $pk . '" name="' . $name . '" style="width: 100%;">';
        if ($order) {
            $ci->db->order_by($field, $order);
        }
        $data = $ci->db->get($table)->result();

        foreach ($data as $d) {
            $cmb .= "\n<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" .  strtoupper($d->$field) . "</option>";
        }
        $cmb .= "\n</select>\n";
        return $cmb;
    }
}
if (!function_exists('cmb_filter')) {
    function cmb_filter($default, $name, $table, $field, $pk, $selected = null, $order = null)
    {
        $ci = get_instance();
        $cmb = "<select name='" . $name . "' class='form-control filter select2' id='" . $pk . "' style='width: 100%;'>";
        if ($order) {
            $ci->db->order_by($field, $order);
        }
        $data = $ci->db->get($table)->result();
        $cmb .= "<option value='all' selected='selected'>" . $default . "</option>";

        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" .  strtoupper($d->$field) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}
if (!function_exists('cmb_periode')) {
    function cmb_periode($name, $table, $field, $pk, $selected = null, $order = null)
    {
        $ci = get_instance();
        $cmb = '<select class="form-control filter select2" id="' . $pk . '" name="' . $name . '" style="width: 100%;">';
        if ($order) {
        }
        $ci->db->order_by($pk, $order);
        $data = $ci->db->get($table)->result();
        $default_option = null;
        foreach ($data as $d) {
            if ($d->status == 1) {
                $default_option = $d;
                break;
            }
        }

        if ($default_option) {
            $cmb .= "\n<option value='" . $default_option->$pk . "'";
            $cmb .= ($selected == $default_option->$pk) ? " selected='selected'" : '';
            $cmb .= ">" . strtoupper($default_option->$field) . "</option>";
        }
        foreach ($data as $d) {
            // Jangan tambahkan opsi default kecuali yang sudah ditambahkan di atas
            if ($d->status != 1) {
                $cmb .= "\n<option value='" . $d->$pk . "'";
                $cmb .= ($selected == $d->$pk) ? " selected='selected'" : '';
                $cmb .= ">" . strtoupper($d->$field) . "</option>";
            }
        }
        $cmb .= "\n</select>\n";
        return $cmb;
    }
}

if (!function_exists('cmb_where_select2')) {
    function cmb_where_select2($name, $table, $field, $pk, $field_where, $value_where, $selected, $order = null)
    {
        $ci = get_instance();
        $cmb = '<select class="form-control select2" id="' . $pk . '" name="' . $name . '" style="width: 100%;">';
        $cmb .= '<option value="">-- Pilih Satu --</option>';
        if ($order) {
            $ci->db->order_by($field, $order);
        }
        $ci->db->where($field_where, $value_where);
        $data = $ci->db->get($table)->result();

        // $cmb .= '<option value="">Pilih ' . strtoupper($field) . '</option>'; // Opsi kosong

        foreach ($data as $d) {
            $selectedAttr = ($selected == $d->$pk) ? 'selected="selected"' : '';
            $cmb .= "\n<option value='" . $d->$pk . "' '" . $selectedAttr . "'>" . strtoupper($d->$field) . "</option>";
        }

        $cmb .= "</select>";
        return $cmb;
    }
}

if (!function_exists('select_input')) {
    function select_input($name, $selected_value, $options)
    {
        $select = '<select id="' . $name . '"name="' . $name . '" class="form-control">';
        $select .= '<option selected="true" disabled="disabled">-- Pilih Satu --</option>';
        foreach ($options as $value => $label) {
            $selected = ($selected_value == $value) ? 'selected' : '';
            $select .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }

        $select .= '</select>';

        return $select;
    }
}

if (!function_exists('idperson_')) {
    function idperson_()
    {
        $CI = &get_instance();
        $CI->load->database();

        $tAwal = $CI->db->query("SELECT DATE_FORMAT(tglmulai,'%y') as tahun FROM tbl_periode WHERE aktif='1'")->row()->tahun;
        $akhiId_ = $tAwal + 1;
        $akhiId = $akhiId_ . '0000';
        $awalId = $tAwal . '0000';
        // $awalId = $tAwal . '5000';

        $result = $CI->db->query("SELECT ifnull(MAX(CONVERT(idperson, SIGNED INTEGER))," . $awalId . ")+1 as idbaru FROM tbl_person WHERE idperson BETWEEN " . $awalId . " AND " . $akhiId);

        $rows2     = $result->row()->idbaru;
        $idperson = '';
        if (empty($rows2)) {
            $idperson = $awalId;
        } else {
            $idperson = $rows2;
        }

        return $idperson;
    }
}

if (!function_exists('token_')) {
    function token_($timestamp, $variable1, $variable2)
    {
        $CI = &get_instance();
        $CI->load->library('encryption');

        // Dapatkan timestamp sekarang
        // $timestamp = time();

        // Gabungkan timestamp dan dua variable dengan karakter titik
        $string_to_encrypt = $timestamp . '.' . $variable1 . '.' . $variable2;

        // Enkripsi string
        $encrypted_string = $CI->encryption->encrypt($string_to_encrypt);

        return $encrypted_string;
    }
}

if (!function_exists('sessionsDb')) {
    function sessionsDb($table_name, $data_array)
    {
        $CI = &get_instance();
        $CI->load->database();

        // Pastikan $data_array adalah array yang tidak kosong
        if (!empty($data_array) && is_array($data_array)) {
            // Masukkan data ke dalam tabel
            $CI->db->insert($table_name, $data_array);

            // Periksa apakah operasi penyisipan berhasil
            if ($CI->db->affected_rows() > 0) {
                return true; // Sukses
            } else {
                return false; // Gagal
            }
        } else {
            return false; // Data tidak valid
        }
    }
}

if (!function_exists('get_aktif_table')) {
    function get_aktif_table($table_name, $column_name, $col_where, $val_where)
    {
        $CI = &get_instance();
        $CI->load->database();

        // Pastikan $table_name dan $column_name adalah string yang tidak kosong
        if (!empty($table_name) && !empty($column_name) && !empty($col_where) && !empty($val_where)) {
            // Ambil data dari kolom
            $query = $CI->db->select($column_name)
                ->from($table_name)
                ->where($col_where, $val_where)
                ->get();

            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->$column_name;
            } else {
                return false; // Kolom kosong
            }
        } else {
            return false; // Data tidak valid
        }
    }
}
if (!function_exists('get_count')) {
    function get_count($table, $conditions = array(), $joins = array())
    {
        $CI = &get_instance();
        $CI->load->database();

        if (!empty($joins)) {
            foreach ($joins as $join) {
                $CI->db->join($join['table'], $join['condition'], isset($join['type']) ? $join['type'] : 'inner');
            }
        }

        if (!empty($conditions)) {
            $CI->db->where($conditions);
        }

        return $CI->db->count_all_results($table);
    }
}
if (!function_exists('get_session_data')) {
    function get_session_data()
    {
        $CI = &get_instance();
        $CI->load->library('session');

        if ($CI->session->userdata('__ci_last_regenerate')) {
            return array(
                'status' => 'success',
                'session_data' => array(
                    'user' => $CI->session->userdata('user_id'),
                    'username' => $CI->session->userdata('username')
                )
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'No session data found'
            );
        }
    }
}
