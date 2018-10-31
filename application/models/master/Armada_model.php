<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("master_armada");
	}

	public function insertTransaction($data)
	{
		$this->db->trans_start(); // Query will be rolled back

		$this->db->insert("master_armada",$data);
		$lastId = $this->db->insert_id();

		$dataWarna = array(
								"armada_id"		=>	$lastId,
								"warna_merah"	=>	"merah", // stand by
								"warna_hijau"	=>	"",
								"warna_ungu"	=>	"",
								"warna_kuning"	=>	"",
								"warna_biru"	=>	"",
							);
		$this->db->insert("performa_status_armada",$dataWarna); // insert data status warna armada stand by

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return FALSE;
		} else { 
		    $this->db->trans_commit();
		    // return TRUE;
		    return $lastId;
		}
	}

}

/* End of file Armada_model.php */
/* Location: ./application/models/master/Armada_model.php */