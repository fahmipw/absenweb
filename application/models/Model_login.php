<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_login extends CI_Model
{

    public function getdata()
    {
        return $this->db->get('login')->result();
    }

    public function getdataby($array)
    {
        $this->db->where($array);
        return $this->db->get('login')->result();
    }

    public function countdata()
    {
        return $this->db->get('login')->num_rows();
    }

    public function countdataby($array)
    {
        $this->db->where($array);
        return $this->db->get('login')->num_rows();
    }
	
	public function insertdata($data)
	{
		$this->db->insert('login', $data);
		$this->db->insert_id();
    }

    public function deletedata($id)
    {
        $this->db->where('username', $id);
        $this->db->delete('login');
    }

    public function deletedataby($array)
    {
        $this->db->where($array);
        $this->db->delete('login');
    }

	public function selectdata($id)
	{
		$this->db->where('username', $id);
		return $this->db->get('login')->row();
	}

	public function selectdataby($array)
	{
		$this->db->where($array);
		return $this->db->get('login')->row();
	}
	
	public function updatedata($data, $id)
	{
		$this->db->where('username', $id);
		$this->db->update('login', $data);
	}
	
	public function cek($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('login')->row();
		//print_r($this->db->get('login')->row()); exit;
	}
	
	public function cek_username($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('login')->row();
        //print_r($this->db->get('login')->row()); exit;
    }

    public function uploadfile()
    {
        $config['upload_path']          = 'assets/upload/ttd/';
        $config['allowed_types']        = '*';
        $config['file_name']            = uniqid();
        $config['overwrite']            = true;
        // $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('ttd')) {
            return $this->upload->data("file_name");
        }

        return "default.jpg";
    }

    public function deletefile($id)
    {
        $user = $this->selectdata($id);
        if ($user->ttd != "default.jpg") {
            $filename = explode(".", $user->ttd)[0];
            return array_map('unlink', glob(FCPATH . "assets/upload/ttd/$filename.*"));
        }
    }

}
