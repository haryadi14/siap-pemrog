<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{
	private const _primary_key = 'id_jadwal';
	private $_tabel = 'jadwal';

    function get_jadwal($id_jadwal)
    {
        if ($id_jadwal) {
            $this->db->where(self::_primary_key, $id_jadwal);
            $this->db->limit(1);
        }
        return $this->db->get($this->_tabel)->result_array();
    }

    public function insert_jadwal($data)
    {
        $this->db->insert($this->_tabel, $data);
        return $this->db->affected_rows();
    }
    public function update_jadwal($data, $id_jadwal)
    {
        $this->db->update($this->_tabel, $data, [self::_primary_key => $id_jadwal]);
        return $this->db->affected_rows();
    }
    public function delete_jadwal($id_jadwal)
    {
        $this->db->delete($this->_tabel, [self::_primary_key => $id_jadwal]);
        return $this->db->affected_rows();
    }
}
