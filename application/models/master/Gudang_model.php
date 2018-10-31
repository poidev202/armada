<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("master_gudang");
	}

	public function getSaldoLpGudang($where,$select = false)
	{
		$this->db->where($where);
		if ($select) {
			if (is_array($select)) {
				$this->db->select(implode(",", $select));
			} else {
				$this->db->select($select);
			}
		}
		$query = $this->db->get("laporan_gudang");
		return $query->row();
	}

}

/* End of file Gudang_model.php */
/* Location: ./application/models/master/Gudang_model.php */