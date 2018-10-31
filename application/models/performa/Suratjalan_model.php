<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalan_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("performa_surat_jalan");
	}

	public function checkStatusArmada($armada_id)
	{
		$this->db->where(array("armada_id" => $armada_id));
		$data = $this->db->get("performa_status_armada")->row();
		return $data;
	}

	public function transactionInsert($data)
	{
		// $this->db->trans_begin();
		$this->db->trans_start(); // Query will be rolled back

		/*$this->db->where(array("armada_id" => $data["armada_id"],"warna_merah" => "merah"));
		$checkStatusArmada = $this->db->get("performa_status_armada")->row();
		if ($checkStatusArmada) {*/
			$this->db->where(array("armada_id" => $data["armada_id"]));
			$dataWarna = array(
								"warna_merah"	=>	"",
								"warna_hijau"	=>	"",
								"warna_ungu"	=>	"",
								"warna_kuning"	=>	"kuning",
								"warna_biru"	=>	"",
							);
			$this->db->update("performa_status_armada",$dataWarna); // update data status warna armada
		/*} else {
			// insert data status armada dengan warna kuning
			$this->db->insert("performa_status_armada",array("armada_id"=>$data["armada_id"],"warna_kuning"=>"kuning"));
		}*/

		// untuk insert data surat jalan / memo
		$this->db->insert("performa_surat_jalan",$data);
		$lastId = $this->db->insert_id();

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

	public function insertTransaction($data,$armadaId)
	{
		$this->db->trans_start(); // Query will be rolled back

			// untuk insert data surat jalan / trip
			$this->db->insert_batch("performa_surat_jalan",$data);

			$this->db->where_in("armada_id", $armadaId);
			$dataWarna = array(
								"warna_merah"	=>	"",
								"warna_hijau"	=>	"",
								"warna_ungu"	=>	"",
								"warna_kuning"	=>	"kuning",
								"warna_biru"	=>	"",
								"updated_at"	=>	date("Y-m-d H:i:s")
							);
			$this->db->update("performa_status_armada",$dataWarna); // update data status warna armada

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return FALSE;
		} else { 
		    $this->db->trans_commit();
		    return TRUE;
		}
	}

}

/* End of file Suratjalan_model.php */
/* Location: ./application/models/performa/Suratjalan_model.php */