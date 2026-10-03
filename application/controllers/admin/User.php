<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $this->load->model('model_login');
        $data['tabellogin'] = $this->model_login->getdata();
		$data['content'] = 'view_user';
		$data['title'] = 'Data Karyawan Anda';
		$this->load->view('admin/template', $data);
	}

	public function detail()
	{
		$id = $this->uri->segment(4);
        $this->load->model('model_login');
        $data['tabellogin'] = $this->model_login->getdata();
		$data['content'] = 'view_detail_user';
		$data['title'] = 'Detail User';
		$this->load->view('admin/template', $data);
    }

    public function add()
    {
        $this->load->model('model_jabatan');
        $data['arr_jabatan'] = $this->model_jabatan->getdata();
        $data['arr_level'] = [
            'admin',
            'karyawan'
        ];
        $data['arr_jkel'] = [
            'Laki-laki',
            'Perempuan'
        ];
        $data['content'] = 'view_add_user';
        $data['title'] = 'Add Data User';
        $this->load->view('admin/template', $data);
    }

	public function save()
    {
        $this->load->model('model_login');
        $jabatan = $this->input->post('jabatan');
        $prefix = strtoupper(substr($jabatan, 0, 4));
        $nik = $prefix . rand(10000, 99999);

		$data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'level' => $this->input->post('level'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'alamat' => $this->input->post('alamat'),
            'telepon' => $this->input->post('telepon'),
            'jkel' => $this->input->post('jkel'),
            'jabatan' => $jabatan,
            'nik' => $nik,
            'email' => $this->input->post('email'),
            'ttd' => (!empty($_FILES["ttd"]["name"])) ? $this->model_login->uploadfile() : "",
            'waktu' => date('Y-m-d H:i:s'),
		);

		$this->load->model('model_login');
		$this->model_login->insertdata($data);
		$this->session->set_flashdata('user_message', '
				<script>Swal.fire("Success", "Data Berhasil diinput", "success");</script>
				');
		redirect(site_url('admin/user'));
	}

    public function edit()
    {
        $id = $this->uri->segment(4);
        $this->load->model('model_jabatan');
        $data['arr_jabatan'] = $this->model_jabatan->getdata();
        $data['arr_level'] = [
            'admin',
            'karyawan'
        ];
        $data['arr_jkel'] = [
            'Laki-laki',
            'Perempuan'
        ];
        $this->load->model('model_login');
        $data['rowuser'] = $this->model_login->selectdata($id);
        $data['content'] = 'view_edit_user';
        $data['title'] = 'Edit User';
        $this->load->view('admin/template', $data);
    }

	public function update()
    {
        $this->load->model('model_login');
        $id = $this->uri->segment(4);
        $oldUser = $this->model_login->selectdata($id);
        $nik = $oldUser ? $oldUser->nik : $this->input->post('nik');

        if(!empty($_FILES["ttd"]["name"])) {
            $data = array(
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'jkel' => $this->input->post('jkel'),
                'jabatan' => $this->input->post('jabatan'),
                'nik' => $nik,
                'email' => $this->input->post('email'),
                'ttd' =>  $this->model_login->uploadfile(),
                'waktu' => date('Y-m-d H:i:s'),
            );
        } else {
            $data = array(
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon'),
                'jkel' => $this->input->post('jkel'),
                'jabatan' => $this->input->post('jabatan'),
                'nik' => $nik,
                'email' => $this->input->post('email'),
                'waktu' => date('Y-m-d H:i:s'),
            );
        }

        $this->model_login->updatedata($data, $id);
        $this->session->set_flashdata('user_message', '
				<script>Swal.fire("Success", "Data Berhasil diubah", "success");</script>
				');
        redirect(site_url('admin/user'));
	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		$this->load->model('model_login');
		$this->model_login->deletedata($id);

		$this->session->set_flashdata('user_message', '<script>Swal.fire("Success", "Data berhasil dihapus", "success");</script>');
		redirect(site_url('admin/user'));
	}
}
