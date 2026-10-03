<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent :: __construct();
        $folder = ($this->session->userdata('level') == "superadmin") ? "admin" : $this->session->userdata('level');
		if (strtolower($folder) != "admin") {
			$this->session->set_flashdata('pesan', 'Anda Belum Login');
			redirect(site_url('home/login'));
			exit;
		}
	}

	public function index()
    {
        $data['bulan'] = date('m');
        $data['tahun'] = date('Y');
        $this->config->load('absensi', TRUE);
        $this->load->model('model_login');
        $this->load->model('model_absen');
		$data['totalkaryawan'] = $this->model_login->countdata();
        $data['rowuser'] = $this->model_login->selectdata($this->session->userdata('username'));
        $today = date('Y-m-d');
        $today_absen = $this->model_absen->getdataby([
            'DATE(waktu)' => $today,
        ]);
        $today_checkin = array_filter($today_absen, function ($row) { return $row->checkinout == 'In'; });
        $today_checkout = array_filter($today_absen, function ($row) { return $row->checkinout == 'Out'; });
        $today_checkin_by_user = array();
        foreach ($today_checkin as $row) {
            $today_checkin_by_user[$row->username] = $row;
        }
        $today_checkout_by_user = array();
        foreach ($today_checkout as $row) {
            $today_checkout_by_user[$row->username] = $row;
        }
        $data['total_hadir_hari_ini'] = count($today_checkin_by_user);
        $data['terlambat'] = 0;
        foreach ($today_checkin as $row) {
            if (date('H:i:s', strtotime($row->waktu)) > '08:00:00') {
                $data['terlambat']++;
            }
        }
        $data['belum_pulang'] = 0;
        foreach ($today_checkin_by_user as $username => $row) {
            if (!isset($today_checkout_by_user[$username])) {
                $data['belum_pulang']++;
            }
        }
        $data['tidak_hadir'] = max(0, $data['totalkaryawan'] - $data['total_hadir_hari_ini']);
        $data['grafik_absensi'] = $this->model_absen->getdataby(['DATE(waktu) >=' => date('Y-m-01')]);
        $data['absensi_lokasi'] = $this->model_absen->getdataby(['latitude !=' => '', 'longitude !=' => '']);
        $monthly = array_fill(0, 12, 0);
        foreach ($data['grafik_absensi'] as $row) {
            $month = (int) date('m', strtotime($row->waktu)) - 1;
            if ($month >= 0 && $month < 12) {
                $monthly[$month]++;
            }
        }
        $data['monthly_counts'] = $monthly;
        $secret = $this->config->item('absensi_barcode_secret', 'absensi');
        if (empty($secret)) {
            $secret = 'absensi-secret';
        }
        $data['daily_barcode_code'] = strtoupper(substr(hash('sha256', $secret . date('Y-m-d')), 0, 8));
		$data['content'] = 'view_index';
		$data['title'] = 'Admin';
		$this->load->view('admin/template', $data);
	}

	public function ganti_password()
	{
		$data['content'] = 'view_ganti_password';
		$data['title'] = 'Ganti Password';
		$this->load->view('admin/template', $data);
	}
	
	public function update_password()
	{
		$username = $this->session->userdata('username');
		$this->load->model('model_login');
		$rowlogin = $this->model_login->selectdataby(
            [
                'username' => $username,
            ]
        );
		if ($rowlogin) {
			if (($this->input->post('lama') == $rowlogin->password)) {
            // if (password_verify($this->input->post('lama'), $rowlogin->password)) {
				if ($this->input->post('baru') == $this->input->post('konfirmasi')) {
					$data = array(
						'password'=>$this->input->post('baru'),
						);
					$this->load->model('model_login');
					$this->model_login->updatedata($data, $username);
					$this->session->set_flashdata('message', '
					<div class="alert alert-success" role="alert">
						Password berhasil diubah
					</div>');
					redirect(site_url('admin/home/ganti_password'));	
				} else {
					$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
						Password Baru Tidak Sama Dengan Konfirmasi
					</div>');
					redirect(site_url('admin/home/ganti_password'));	
				}
			} else {
				$this->session->set_flashdata('message', '
				<div class="alert alert-danger" role="alert">
					Password lama salah
				</div>');
				redirect(site_url('admin/home/ganti_password'));
	
			}
		} else {

			$this->session->set_flashdata('message', '
			<div class="alert alert-danger" role="alert">
				Username/Email tidak ditemukan
			</div>');
			redirect(site_url('admin/home/ganti_password'));

		}
	}
}
