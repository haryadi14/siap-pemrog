<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
	private const _primary_key = 'npm';
	private $_tabel_mhs = 'mahasiswa';
    function get_mahasiswa_data($npm)
    {
        if ($npm) {
            $this->db->where(self::_primary_key, $npm);
            $this->db->limit(1);
        }
        return $this->db->get($this->_tabel_mhs)->result_array();
    }

    public function insertMahasiswa($data)
    {
        $this->db->insert($this->_tabel_mhs, $data);
        return $this->db->affected_rows();
    }
    public function updateMahasiswa($data, $npm)
    {
        $this->db->update($this->_tabel_mhs, $data, [self::_primary_key => $npm]);
        return $this->db->affected_rows();
    }
    public function deleteMahasiswa($npm)
    {
        $this->db->delete($this->_tabel_mhs, [self::_primary_key => $npm]);
        return $this->db->affected_rows();
    }
}
