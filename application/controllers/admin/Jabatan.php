<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('level') != "superadmin" && $this->session->userdata('level') != "admin") {
            redirect(site_url('home/login'));
        }
        $this->load->model('model_jabatan');
    }

    public function index()
    {
        $data['jabatan'] = $this->model_jabatan->getdata();
        $data['content'] = 'view_jabatan';
        $data['title'] = 'Data Jabatan';
        $this->load->view('admin/template', $data);
    }

    public function add()
    {
        $data['content'] = 'view_add_jabatan';
        $data['title'] = 'Tambah Jabatan';
        $this->load->view('admin/template', $data);
    }

    public function save()
    {
        $data = ['nama_jabatan' => $this->input->post('nama_jabatan')];
        $this->model_jabatan->insertdata($data);
        $this->session->set_flashdata('message', '<script>Swal.fire("Success", "Data Berhasil ditambah", "success");</script>');
        redirect(site_url('admin/jabatan'));
    }

    public function edit()
    {
        $id = $this->uri->segment(4);
        $data['row'] = $this->model_jabatan->selectdata($id);
        $data['content'] = 'view_add_jabatan';
        $data['title'] = 'Edit Jabatan';
        $this->load->view('admin/template', $data);
    }

    public function update()
    {
        $id = $this->uri->segment(4);
        $data = ['nama_jabatan' => $this->input->post('nama_jabatan')];
        $this->model_jabatan->updatedata($data, $id);
        $this->session->set_flashdata('message', '<script>Swal.fire("Success", "Data Berhasil diubah", "success");</script>');
        redirect(site_url('admin/jabatan'));
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->model_jabatan->deletedata($id);
        $this->session->set_flashdata('message', '<script>Swal.fire("Success", "Data berhasil dihapus", "success");</script>');
        redirect(site_url('admin/jabatan'));
    }
}
