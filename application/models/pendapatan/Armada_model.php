<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("pendapatan_armada");
	}

	public function transactionInsert($data,$dataLpKas)
	{
		// $this->db->trans_begin();
		$this->db->trans_start(); // Query will be rolled back

		$this->db->where(array("armada_id" => $data["armada_id"],"warna_kuning" => "kuning"));
		$checkStatusArmada = $this->db->get("performa_status_armada")->row();
		if ($checkStatusArmada) {
			$this->db->where(array("armada_id" => $data["armada_id"]));
			$dataWarna = array(
								"warna_merah"	=>	"",
								"warna_hijau"	=>	"hijau",
								"warna_ungu"	=>	"",
								"warna_kuning"	=>	"",
								"warna_biru"	=>	"",
							);
			$this->db->update("performa_status_armada",$dataWarna); // update data status warna armada
		}

		// untuk insert data surat jalan / memo
		array_shift($data);

		$this->db->insert("pendapatan_armada",$data);
		$lastId = $this->db->insert_id();

		/*insert laporan account kas*/
		$dataLpKas["pendpt_armada_id"] = $lastId;
		$this->db->insert('laporan_account_kas', $dataLpKas);

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
/* Location: ./application/models/pendapatan/Armada_model.php */