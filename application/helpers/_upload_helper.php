<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('upload_file')) {
    function upload_file_()
    {
        $CI = &get_instance(); // Get the CI instance
        $path = './assets/uploads/document/';

        // Call the upload_config() function
        upload_config_($path);
        if ($CI->upload->do_upload('file')) { // Perform upload and check if upload is successful
            // If successful:
            $result = array('status' => 'success', 'userfile' => $CI->upload->data());
            return $result;
        } else {
            // If failed:
            $error = array('status' => 'error', 'error' => $CI->upload->display_errors());
            return $error;
        }
    }
}

if (!function_exists('upload_config')) {
    function upload_config_($path)
    {
        $CI = &get_instance(); // Get the CI instance
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|XLSX|xls|XLS';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 4096;
        $CI->load->library('upload', $config);
    }
}

if (!function_exists('read_excel')) {
    function read_excel_($file_path)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
        $sheet_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $data = [];
        $isFirstRow = true;
        foreach ($sheet_data as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Skip the first row
            }
            $data[] = $row;
        }
        $result = array('status' => 'success', 'data' => $data);
        return $result;
    }
}
