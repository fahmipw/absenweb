<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jabatan extends CI_Model
{
    public function getdata() { return $this->db->get('jabatan')->result(); }
    public function insertdata($data) { $this->db->insert('jabatan', $data); }
    public function selectdata($id) { return $this->db->where('id', $id)->get('jabatan')->row(); }
    public function updatedata($data, $id) { $this->db->where('id', $id)->update('jabatan', $data); }
    public function deletedata($id) { $this->db->where('id', $id)->delete('jabatan'); }
}
