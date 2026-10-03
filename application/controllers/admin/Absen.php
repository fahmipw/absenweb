<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
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
        $this->load->model('model_absen');
        $data['tabelabsen'] = $this->model_absen->getdata();
        $data['content'] = 'view_absen';
        $data['title'] = 'Data Absen PT. Srikandi Inti Prakarsa';
        $this->load->view('admin/template', $data);
    }

    public function rekap()
    {
        $data['bulan'] = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
        $data['tahun'] = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $data['username'] = isset($_GET['username']) ? $_GET['username'] : '';
        $this->load->model('model_login');
        $data['tabellogin'] = $this->model_login->getdata();
        $data['content'] = 'view_rekap_absen';
        $data['title'] = 'Rekap Absen';
        $this->load->view('admin/template', $data);
    }

    public function save()
    {
        $username = $this->session->userdata('username');
        $checkinout = trim($this->input->post('checkinout'));
        $keterangan = trim($this->input->post('keterangan'));
        $barcode_code = strtoupper(trim($this->input->post('barcode_code')));

        $this->load->model('model_absen');
        $this->model_absen->ensure_absen_columns();

        if (empty($barcode_code) || !$this->is_valid_barcode($barcode_code)) {
            $this->session->set_flashdata('message', '<script>Swal.fire("Error", "Kode barcode tidak valid", "error");</script>');
            redirect(site_url('admin/absen'));
            return;
        }

        $data = array(
            'id_absen' => uniqid(),
            'username' => $username,
            'waktu' => date('Y-m-d H:i:s'),
            'checkinout' => $checkinout,
            'keterangan' => $keterangan,
            'barcode_code' => $barcode_code,
            'status_absen' => 'Valid Barcode',
        );

        $checkexisting = $this->model_absen->countdataby([
            'username' => $username,
            'DATE(waktu)' => date('Y-m-d'),
            'checkinout' => $checkinout,
        ]);
        if ($checkexisting > 0) {
            $this->session->set_flashdata('message', '<script>Swal.fire("Error", "Anda sudah absen Check-' . $checkinout . ' hari ini", "error");</script>');
            redirect(site_url('admin/absen'));
            return;
        }

        $this->model_absen->insertdata($data);
        $this->session->set_flashdata('message', '<script>Swal.fire("Success", "Absen berhasil disubmit", "success");</script>');
        redirect(site_url('admin/absen'));
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->load->model('model_absen');
        $this->model_absen->deletedata($id);

        $this->session->set_flashdata('message', '<script>Swal.fire("Success", "Data berhasil dihapus", "success");</script>');
        redirect(site_url('admin/absen'));
    }

    private function get_daily_barcode_code()
    {
        $secret = $this->config->item('absensi_barcode_secret', 'absensi');
        if (empty($secret)) {
            $secret = 'absensi-secret';
        }

        $hash = hash('sha256', $secret . date('Y-m-d'));
        return strtoupper(substr($hash, 0, 8));
    }

    private function is_valid_barcode($code)
    {
        return strtoupper(trim($code)) === $this->get_daily_barcode_code();
    }
}
