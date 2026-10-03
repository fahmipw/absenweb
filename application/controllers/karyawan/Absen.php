<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $folder = ($this->session->userdata('level') == "superadmin") ? "admin" : $this->session->userdata('level');
        if (strtolower($folder) != "karyawan") {
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
        $data['tabelabsen'] = $this->model_absen->getdataby([
            'username' => $this->session->userdata('username'),
            'DATE(waktu)' => date('Y-m-d'),
        ]);
        $data['content'] = 'view_absen';
        $data['title'] = 'Data Absen Anda Hari Ini';
        $this->load->view('karyawan/template', $data);
    }

    public function rekap()
    {
        $data['bulan'] = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
        $data['tahun'] = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $data['username'] = $this->session->userdata('username');

        $this->load->model('model_login');
        $data['tabellogin'] = $this->model_login->getdataby([
            'username' => $data['username'],
        ]);
        $data['content'] = 'view_rekap_absen';
        $data['title'] = 'Rekap Absen';
        $this->load->view('karyawan/template', $data);
    }

    public function save()
    {
        $username = $this->session->userdata('username');
        $checkinout = trim($this->input->post('checkinout'));
        $keterangan = trim($this->input->post('keterangan'));
        $barcode_code = strtoupper(trim($this->input->post('barcode_code')));
        $lat = trim($this->input->post('latitude'));
        $lng = trim($this->input->post('longitude'));

        $this->load->model('model_absen');
        $this->model_absen->ensure_absen_columns();

        $this->load->library('user_agent');
        $device_info = $this->agent->agent_string();

        if (empty($barcode_code)) {
            $this->output->set_content_type('application/json');
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Anda harus melakukan scan barcode terlebih dahulu!']);
            return;
        }

        if (empty($lat) || empty($lng)) {
            $this->output->set_content_type('application/json');
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Izin lokasi wajib diaktifkan untuk melakukan absen!']);
            return;
        }

        // Hitung jarak radius (Haversine formula)
        // Setkan nilai default radius 500 meter agar tidak terus menerus terkena pembatasan radius jika testing di lokasi berbeda
        $target_lat = -6.272950;
        $target_lng = 106.873394;
        $earth_radius = 6371000;

        $dLat = deg2rad($lat - $target_lat);
        $dLon = deg2rad($lng - $target_lng);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($target_lat)) * cos(deg2rad($lat)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earth_radius * $c;

        // Radius disesuaikan ke 5000 meter untuk pengetesan lokal
        if ($distance > 5000) {
            $this->output->set_content_type('application/json');
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Anda berada di luar radius 5000 meter dari lokasi absensi! Jarak Anda: ' . round($distance) . ' meter.']);
            return;
        }

        $data = array(
            'id_absen' => uniqid(),
            'username' => $username,
            'waktu' => date('Y-m-d H:i:s'),
            'checkinout' => $checkinout,
            'keterangan' => $keterangan,
            'barcode_code' => $barcode_code,
            'device_info' => $device_info,
            'status_absen' => $this->get_attendance_status(),
        );

        $checkexisting = $this->model_absen->countdataby([
            'username' => $username,
            'DATE(waktu)' => date('Y-m-d'),
            'checkinout' => $checkinout,
        ]);
        if ($checkexisting > 0) {
            $this->output->set_content_type('application/json');
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Anda sudah absen Check-' . $checkinout . ' hari ini']);
            return;
        }

        $this->model_absen->insertdata($data);
        $this->output->set_content_type('application/json');
        $this->output->set_status_header(200);
        $message = ($checkinout == 'Out') ? 'Pulang' : 'Absen berhasil disubmit';
        echo json_encode(['status' => 'success', 'message' => $message]);
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->load->model('model_absen');
        $this->model_absen->deletedata($id);

        redirect(site_url('karyawan/absen'));
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

    private function get_attendance_status()
    {
        $current_time = date('H:i:s');
        $work_start_time = '09:00:00';
        
        if ($current_time <= $work_start_time) {
            return 'Hadir';
        } else {
            $start = strtotime($work_start_time);
            $now = strtotime($current_time);
            $diff = $now - $start;
            
            $hours = floor($diff / 3600);
            $minutes = floor(($diff % 3600) / 60);
            
            if ($hours > 0) {
                return 'Hadir & Terlambat (' . $hours . ' Jam ' . $minutes . ' Menit)';
            } else {
                return 'Hadir & Terlambat (' . $minutes . ' Menit)';
            }
        }
    }
}
