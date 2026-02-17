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
        $data['bulan'] = $_GET['bulan'];
        $data['tahun'] = $_GET['tahun'];
        $data['username'] = $_GET['username'];
        $this->load->model('model_login');
        $data['tabellogin'] = $this->model_login->getdata();
		$data['content'] = 'view_rekap_absen';
		$data['title'] = 'Rekap Absen';
		$data['list'] = $list;
		$this->load->view('admin/template', $data);
	}

	public function save()
    {
		$username = $this->session->userdata('username');
		$checkinout = $this->input->post('checkinout');
		$keterangan = $this->input->post('keterangan');
		
        $this->load->model('model_absen');
		$data = array(
            'id_absen' => uniqid(),
            'username' => $username,
            'waktu' => date("Y-m-d H:i:s"),
            'checkinout' => $checkinout,
            'keterangan' => $keterangan,
		);
		$checkexisting = $this->model_absen->countdataby([
            'username' => $username,
            'DATE(waktu)' => date("Y-m-d"),
            'checkinout' => $checkinout,
		]);
		if ($checkexisting > 0) {
			$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
						Anda sudah absen Check-'.$checkinout.' hari ini
					</div>
					');
			redirect(site_url('admin/absen'));
		} else {
			$this->model_absen->insertdata($data);
			$this->session->set_flashdata('message', '
					<div class="alert alert-success" role="alert">
						Absen berhasil disubmit
					</div>
					');
			redirect(site_url('admin/absen'));
		}

	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		$this->load->model('model_absen');
		$this->model_absen->deletedata($id);

		redirect(site_url('admin/absen'));
	}
}
