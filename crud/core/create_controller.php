<?php

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$c_url = \$this->router->fetch_class();
        \$this->layout->auth();
        \$this->layout->auth_privilege(\$c_url);
        \$this->load->model('$m');
        \$this->load->library('form_validation');";

if ($jenis_tabel <> 'reguler_table') {
    $string .= "        \n\t\t\$this->load->library('datatables');";
}

$string .= "
    }";

if ($jenis_tabel == 'reguler_table') {

    $string .= "\n\n    public function index()
    {
        \$q = urldecode(\$this->input->get('q', TRUE));
        \$start = intval(\$this->input->get('start'));
        
        if (\$q <> '') {
            \$config['base_url'] = base_url() . '$c_url?q=' . urlencode(\$q);
            \$config['first_url'] = base_url() . '$c_url?q=' . urlencode(\$q);
        } else {
            \$config['base_url'] = base_url() . '$c_url';
            \$config['first_url'] = base_url() . '$c_url';
        }

        \$config['per_page'] = 10;
        \$config['page_query_string'] = TRUE;
        \$config['total_rows'] = \$this->" . $m . "->total_rows(\$q);
        \$$c_url = \$this->" . $m . "->get_limit_data(\$config['per_page'], \$start, \$q);

        \$this->load->library('pagination');
        \$this->pagination->initialize(\$config);

        \$data = array(
            '" . $c_url . "_data' => \$$c_url,
            'q' => \$q,
            'pagination' => \$this->pagination->create_links(),
            'total_rows' => \$config['total_rows'],
            'start' => \$start,
        );
        \$data['title'] = '" . label($c_url) . "';
        \$data['subtitle'] = '';
        \$data['crumb'] = [
            '" . label($c_url) . "' => '',
        ];
        \$data['code_js'] = '$c_url/codejs';
        \$data['page'] = '$c_url/$v_list';
        \$this->load->view('template/backend', \$data);
    }";
} else {

    $string .= "\n\n    public function index()
    {
        \$data['title'] = '" . label($c_url) . "';
        \$data['subtitle'] = '';
        \$data['crumb'] = [
            '" . label($c_url) . "' => '',
        ];
        \$data['code_js'] = '$c_url/codejs';
        \$data['page'] = '$c_url/$v_list';";
    if ($cruds == 'ajax_modal') {
        $string .= "\n\t\t\$data['modal'] = '$c_url/$v_modal';";
    };
    $string .= "\n\t\t\$this->load->view('template/backend', \$data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo \$this->" . $m . "->json();
    }";
}
if ($cruds == 'ajax_modal') {
    $string .=
        "\n\n    public function json_get() 
        {
            \$id = \$this->input->post(\"id\");
            \$row = \$this->" . $m . "->get_by_id(\$id);
            \n\t\t\techo json_encode(\$row);
            \n}\n
    public function json_form()
        {
            \$this->_rules();
            \$data = array('status' => false, 'messages' => array(), 'msg' => '');
            if (\$this->form_validation->run() === FALSE) {
                foreach (\$_POST as \$key => \$value) {
                    \$data['messages'][\$key] = form_error(\$key);
                }
                \$data['status'] = false;
                \$data['msg'] = 'Error';
            } else {
            \$act = isset(\$_POST['actions']) ? \$_POST['actions'] : '';
            if (\$act == 'Edit') {
                \$id = \$this->input->post('$pk', TRUE);
                \$data = array(";
    foreach ($non_pk as $row) {
        $string .= "\n\t\t\t\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "',TRUE),";
    }
    $string .= "\n\t    );
                
                    \$update = \$this->" . $m . "->update(\$id, \$data);
                            if (\$update) {
                                \$data['status'] = true;
                    \$data['msg'] = 'Success to update data';
                            } else {
                                \$data['status'] = false;
                    \$data['msg'] = 'Failed to update data';
                    foreach (\$_POST as \$key => \$value) {
                        \$data['messages'][\$key] = form_error(\$key);
                    }
                            }
        } else {
           \$data = array(";
    foreach ($non_pk as $row) {
        $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "',TRUE),";
    }
    $string .= "\n\t    );";
    if (!$isai) {
        $string .= "\nif(! \$this->" . $m . "->is_exist(\$this->input->post('" . $pk . "'))){
                 \n\$insert =\$this->" . $m . "->insert(\$data);
                 if (\$insert) {
                    \$data['status'] = true;
                    \$data['msg'] = 'Success to insert data';
                            } else {
                                \$data['status'] = false;
                        \$data['msg'] = 'Failed to insert data';
                        foreach (\$_POST as \$key => \$value) {
                            \$data['messages'][\$key] = form_error(\$key);
                        }
                            }
            }else{
                \$data['status'] = false;
                \$data['msg'] = 'idsiswa is exist';
            }";
    } else {
        $string .=    "\n\$insert =\$this->" . $m . "->insert(\$data);
        if (\$insert) {
           \$data['status'] = true;
           \$data['msg'] = 'Success to insert data';
                   } else {
                       \$data['status'] = false;
               \$data['msg'] = 'Failed to insert data';
               foreach (\$_POST as \$key => \$value) {
                   \$data['messages'][\$key] = form_error(\$key);
               }
                   }";
    }
    $string .= " }\n}\necho json_encode(\$data);\n}";
}

$string .= "\n\n    public function read(\$id) 
    {
        \$row = \$this->" . $m . "->get_by_id(\$id);
        if (\$row) {
            \$data = array(";
foreach ($all as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$row->" . $row['column_name'] . ",";
}
$string .= "\n\t    );
        \$data['title'] = '" . label($c_url) . "';
        \$data['subtitle'] = '';
        \$data['crumb'] = [
            'Dashboard' => '',
        ];

        \$data['page'] = '$c_url/$v_read';
        \$this->load->view('template/backend', \$data);
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }

    public function create() 
    {
        \$data = array(
            'button' => 'Create',
            'action' => site_url('$c_url/create_action'),";
foreach ($all as $row) {
    $string .= "\n\t    '" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "'),";
}
$string .= "\n\t);
        \$data['title'] = '" . label($c_url) . "';
        \$data['subtitle'] = '';
        \$data['crumb'] = [
            'Dashboard' => '',
        ];

        \$data['page'] = '$c_url/$v_form';
        \$this->load->view('template/backend', \$data);
    }
    
    public function create_action() 
    {
        \$this->_rules();

        if (\$this->form_validation->run() == FALSE) {
            \$this->create();
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "',TRUE),";
}
$string .= "\n\t    );";

if (!$isai) {
    $string .= "\nif(! \$this->" . $m . "->is_exist(\$this->input->post('" . $pk . "'))){
                \$this->" . $m . "->insert(\$data);
            \$this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('$c_url'));
            }else{
                \$this->create();
                \$this->session->set_flashdata('message', 'Create Record Faild, {$pk} is exist');
            }";
} else {
    $string .=    "\$this->" . $m . "->insert(\$data);
            \$this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('$c_url'));";
}
$string .= "}
    }
    
    public function update(\$id) 
    {
        \$row = \$this->" . $m . "->get_by_id(\$id);

        if (\$row) {
            \$data = array(
                'button' => 'Update',
                'action' => site_url('$c_url/update_action'),";
foreach ($all as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "', \$row->" . $row['column_name'] . "),";
}
$string .= "\n\t    );
            \$data['title'] = '" . label($c_url) . "';
        \$data['subtitle'] = '';
        \$data['crumb'] = [
            'Dashboard' => '',
        ];

        \$data['page'] = '$c_url/$v_form';
        \$this->load->view('template/backend', \$data);
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }
    
    public function update_action() 
    {
        \$this->_rules();

        if (\$this->form_validation->run() == FALSE) {
            \$this->update(\$this->input->post('$pk', TRUE));
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "',TRUE),";
}
$string .= "\n\t    );

            \$this->" . $m . "->update(\$this->input->post('$pk', TRUE), \$data);
            \$this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('$c_url'));
        }
    }
    
    public function delete(\$id) 
    {
        \$row = \$this->" . $m . "->get_by_id(\$id);

        if (\$row) {
            \$this->" . $m . "->delete(\$id);
            \$this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('$c_url'));
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }

    public function deletebulk(){
        \$delete = \$this->" . $m . "->deletebulk();
        if(\$delete){
            \$this->session->set_flashdata('message', 'Delete Record Success');
        }else{
            \$this->session->set_flashdata('message_error', 'Delete Record failed');
        }
        echo \$delete;
    }
   
    public function _rules() 
    {";
foreach ($non_pk as $row) {
    $int = $row3['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
    $string .= "\n\t\$this->form_validation->set_rules('" . $row['column_name'] . "', '" .  strtolower(label($row['column_name'])) . "', 'trim|required$int');";
}
$string .= "\n\n\t\$this->form_validation->set_rules('$pk', '$pk', 'trim');";
if ($cruds == 'ajax_modal') {
    $string .= "\n\t\$this->form_validation->set_error_delimiters('<p class=\"text-danger\">', '</p>');
}";
} else {
    $string .= "\n\t\$this->form_validation->set_error_delimiters('<span class=\"text-danger\">', '</span>');
        }";
}

if ($export_excel == '1') {
    $string .= "\n\n    public function excel()
    {
        \$this->load->helper('exportexcel');
        \$namaFile = \"$table_name.xls\";
        \$judul = \"$table_name\";
        \$tablehead = 0;
        \$tablebody = 1;
        \$nourut = 1;
        //penulisan header
        header(\"Pragma: public\");
        header(\"Expires: 0\");
        header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
        header(\"Content-Type: application/force-download\");
        header(\"Content-Type: application/octet-stream\");
        header(\"Content-Type: application/download\");
        header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
        header(\"Content-Transfer-Encoding: binary \");

        xlsBOF();

        \$kolomhead = 0;
        xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
    foreach ($non_pk as $row) {
        $column_name = label($row['column_name']);
        $string .= "\n\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
    }
    $string .= "\n\n\tforeach (\$this->" . $m . "->get_all() as \$data) {
            \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
    foreach ($non_pk as $row) {
        $column_name = $row['column_name'];
        $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
        $string .= "\n\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
    }
    $string .= "\n\n\t    \$tablebody++;
            \$nourut++;
        }

        xlsEOF();
        exit();
    }";
}

if ($export_word == '1') {
    $string .= "\n\n    public function word()
    {
        header(\"Content-type: application/vnd.ms-word\");
        header(\"Content-Disposition: attachment;Filename=$table_name.doc\");

        \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        
        \$this->load->view('" . $c_url . "/" . $v_doc . "',\$data);
    }";
}

if ($export_pdf == '1') {
    $string .= "\n\n  public function printdoc(){
        \$data = array(
            '" . $c_url . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        \$this->load->view('" . $c_url . "/" . $c_url . "_print', \$data);
    }";
}

$string .= "\n\n}\n\n/* End of file $c_file */
";




$hasil_controller = createFile($string, $target . "controllers/" . $c_file);
