<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;

class Pdf
{

    protected $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function load_view($view, $data = array())
    {
        $html = get_instance()->load->view($view, $data, TRUE);
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->stream();
    }
}
