<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_absen extends CI_Model
{

    public function getdata()
    {
        $this->db->order_by('id_absen', 'asc'); 
        return $this->db->get('absen')->result();
    }

    public function getdataby($array)
    {
        $this->db->order_by('id_absen', 'desc');
        $this->db->where($array);
        return $this->db->get('absen')->result();
    }

    public function countdata()
    {
        
        return $this->db->get('absen')->num_rows();
    }

    public function countdataby($array)
    {
        
        $this->db->where($array);
        return $this->db->get('absen')->num_rows();
    }
    public function selectdata($id)
    {
        $this->db->where('id_absen', $id);
        return $this->db->get('absen')->row();
    }

    public function selectdataby($array)
    {
        $this->db->where($array);
        return $this->db->get('absen')->row();
    }

    public function insertdata($data)
    {
        $this->db->insert('absen', $data);
        $this->db->insert_id();
    }

    public function updatedata($data, $id)
    {
        $this->db->where('id_absen', $id);
        $this->db->update('absen', $data);
    }

    public function updatedataby($data, $array)
    {
        $this->db->where($array);
        $this->db->update('absen', $data);
    }

    public function deletedata($id)
    {
        $this->db->where('id_absen', $id);
        $this->db->delete('absen');
    }

    public function deletedataby($array)
    {
        $this->db->where($array);
        $this->db->delete('absen');
    }
}
