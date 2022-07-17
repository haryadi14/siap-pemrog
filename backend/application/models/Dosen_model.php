<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dosen_model extends CI_Model
{
	private const _primary_key = 'id_dosen';
	private $_tabel = 'dosen';

	function get_dosen($id_dosen)
	{
		if ($id_dosen) {
			$this->db->where(self::_primary_key, $id_dosen);
			$this->db->limit(1);
		}
		return $this->db->get($this->_tabel)->result_array();
	}

	public function insert_dosen($data)
	{
		$this->db->insert($this->_tabel, $data);
		return $this->db->affected_rows();
	}

	public function update_dosen($data, $id_dosen)
	{
		$this->db->update($this->_tabel, $data, [self::_primary_key => $id_dosen]);
		return $this->db->affected_rows();
	}

	public function delete_dosen($npm)
	{
		$this->db->delete($this->_tabel, [self::_primary_key => $npm]);
		return $this->db->affected_rows();
	}
}
