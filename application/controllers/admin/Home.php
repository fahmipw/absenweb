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
        $this->load->model('model_login');
		$data['totalkaryawan'] = $this->model_login->countdata();
        $data['rowuser'] = $this->model_login->selectdata($this->session->userdata('username'));
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
