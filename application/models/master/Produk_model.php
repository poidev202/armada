<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("master_produk");
	}

	/**
	* @param $queryAll = array($this->db->insert(),$this->db->insert(),$this->db->update(),$this->db->delete())
	*/
	public function transactionInsert($dataProduk,$dataLaporanGudang)
	{
		// $this->db->trans_begin();
		// $this->db->trans_strict(FALSE);

		$this->db->trans_start(); // Query will be rolled back

		/*insert master produk*/
		$this->db->insert("master_produk",$dataProduk);
		$produk_id = $this->db->insert_id();

		$dataLaporanGudang["produk_id"] = $produk_id;
		$this->db->insert('laporan_gudang', $dataLaporanGudang);

		$this->db->trans_complete();


		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else { 
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function transactionUpdate($dataProduk,$dataLaporanGudang)
	{
		$this->db->trans_start(); // Query will be rolled back

		/*update for master produk*/
		$this->db->where("id",$dataProduk["id"]);
		$this->db->update("master_produk",$dataProduk);
		/*end update for master produk*/

		/*update for laporan gudang*/
		$whereLaporanGudang = array(
									"produk_id" => 	$dataLaporanGudang["produk_id"],
									"status"	=>	$dataLaporanGudang["status"],
								);
		$this->db->where($whereLaporanGudang);
		$this->db->update("laporan_gudang",$dataLaporanGudang);
		/*end update for laporan gudang*/

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else { 
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function transactionDelete($id)
	{
		$this->db->trans_start(); // Query will be rolled back

		/*delete for master produk*/
		$this->db->delete("master_produk",array("id" => $id));

		/*delete for laporan gudang*/
		$this->db->delete("laporan_gudang",array("produk_id" => $id));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else { 
		    $this->db->trans_commit();
		    return true;
		}
	}

}

/* End of file Produk_model.php */
/* Location: ./application/models/master/Produk_model.php */