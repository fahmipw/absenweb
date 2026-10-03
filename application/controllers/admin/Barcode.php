<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barcode extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $folder = ($this->session->userdata('level') == "superadmin") ? "admin" : $this->session->userdata('level');
        if (strtolower($folder) != "admin") {
            $this->session->set_flashdata('pesan', 'Anda Belum Login');
            redirect(site_url('home/login'));
            exit;
        }
        $this->load->helper('url');
        $this->config->load('absensi', TRUE);
    }

    public function index()
    {
        $data['content'] = 'view_barcode';
        $data['title'] = 'Barcode Absensi';
        $this->load->view('admin/template', $data);
    }

    public function get_barcode_data()
    {
        $this->load->helper('string');
        
        $secret = $this->config->item('absensi_barcode_secret', 'absensi');
        if (empty($secret)) {
            $secret = 'absensi-secret';
        }

        $hash = hash('sha256', $secret . date('Y-m-d'));
        $barcode_code = strtoupper(substr($hash, 0, 8));
        
        $this->output->set_content_type('application/json');
        $this->output->set_status_header(200);
        echo json_encode([
            'barcode_code' => $barcode_code,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'timestamp' => time()
        ]);
    }
}
