<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $folder = $this->session->userdata('level');
        if (strtolower($folder) != "") {
            $this->session->set_flashdata('pesan', 'Anda Sudah Login');
            redirect(strtolower($folder) . '/home');
            exit;
        }
    }

	public function index()
	{
		$data['content'] = 'view_index';
		$data['title'] = 'Index';
		$this->load->view('template', $data); 
	}

	public function login()
	{
		$data['content'] = 'view_login';
		$data['title'] = 'Login';
		$this->load->view('template_login', $data); 
	}
	
	public function ceklogin() 
	{
		$this->load->model('model_login');
		$rowlogin = $this->model_login->selectdataby(
			[
				'email' => $this->input->post('email'),
			]
		);
		// $rowlogin = $this->model_login->cek($this->input->post('username'), password_verify($this->input->post('password'), $check->password));
		if ($rowlogin) {
			$folder = ($rowlogin->level == "superadmin") ? "admin" : $rowlogin->level;
			if ($this->input->post('password') == $rowlogin->password) {
            // if (password_verify($this->input->post('password'), $rowlogin->password)) {
				$this->session->unset_userdata('message');
				$data = array(
                    'username' => $rowlogin->username,
					'nama' => $rowlogin->nama_lengkap,
					'level' => $rowlogin->level,
				);
				$this->session->set_userdata($data);
				redirect(strtolower($folder).'/home');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah</div>');
				$this->session->keep_flashdata('message');
				redirect('home/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak ditemukan</div>');
			redirect('home/login');
		}
	}
	
	public function logout() 
	{
		$this->session->sess_destroy();
		redirect('home/index');
	}
}
