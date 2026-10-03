<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_absen extends CI_Model
{

    public function getdata()
    {
        $this->db->order_by('waktu', 'desc');
        return $this->db->get('absen')->result();
    }

    public function getdataby($array)
    {
        $this->db->order_by('waktu', 'desc');
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
        return $this->db->insert_id();
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

    public function ensure_absen_columns()
    {
        $columns = $this->db->list_fields('absen');
        $required = array(
            'foto_selfie' => 'VARCHAR(255) NULL DEFAULT NULL',
            'foto_path' => 'VARCHAR(255) NULL DEFAULT NULL',
            'foto_taken_at' => 'DATETIME NULL DEFAULT NULL',
            'latitude' => 'VARCHAR(50) NULL DEFAULT NULL',
            'longitude' => 'VARCHAR(50) NULL DEFAULT NULL',
            'accuracy_gps' => 'VARCHAR(50) NULL DEFAULT NULL',
            'distance_m' => 'DECIMAL(10,2) NULL DEFAULT NULL',
            'status_absen' => 'VARCHAR(50) NULL DEFAULT NULL',
            'barcode_code' => 'VARCHAR(255) NULL DEFAULT NULL',
            'device_info' => 'TEXT NULL DEFAULT NULL',
        );

        foreach ($required as $column => $definition) {
            if (!in_array($column, $columns, true)) {
                $this->db->query('ALTER TABLE absen ADD COLUMN ' . $column . ' ' . $definition);
            }
        }
    }
}
