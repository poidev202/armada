<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("transaksi_penjualan");
	}

	public function transactionInsert($dataLaporanGudang,$data,$dataLpKas)
	{
		// $this->db->trans_begin();
		$this->db->trans_start(); // Query will be rolled back

		/*insert laporan gudang*/
		$this->db->insert('laporan_gudang', $dataLaporanGudang);
		$laporan_gudang_id = $this->db->insert_id();

		/*insert transaksi penjualan*/
		$data["laporan_gudang_id"] = $laporan_gudang_id;
		$this->db->insert("transaksi_penjualan",$data);
		$penjualan_id = $this->db->insert_id();

		/*insert laporan account kas*/
		$dataLpKas["penjualan_id"] = $penjualan_id;
		$this->db->insert('laporan_account_kas', $dataLpKas);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return FALSE;
		} else { 
		    $this->db->trans_commit();
		    return TRUE;
		}
	}

	public function transactionUpdate($data,$dataLaporanGudang)
	{
		$this->db->trans_start(); // Query will be rolled back

		/*update for transaksi penjualan */
		$this->db->where("id",$data["id"]);
		$this->db->update("transaksi_penjualan",$data);
		/*end update for transaksi penjualan */

		/*update for laporan gudang*/
		// if ($dataLaporanGudang["id"] != NULL) {
			$this->db->where("id",$dataLaporanGudang["id"]);
			$this->db->update("laporan_gudang",$dataLaporanGudang);
		// }
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

	public function transactionDelete($id,$id_laporan)
	{
		$this->db->trans_start(); // Query will be rolled back

		/*delete for master produk*/
		$this->db->delete("transaksi_penjualan",array("id" => $id));

		/*delete for laporan gudang*/
		$this->db->delete("laporan_gudang",array("id" => $id_laporan));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else { 
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function findDataPenjualan($where=false,$select=false,$orderBy=false,$search=false,$join=false,$limit=0,$offset=0)
	{
		$this->db->from($this->_table);

		if($where) {
			if ($where["data"] != null) {
				$this->db->where($where["data"]);
			}
			if ($where["tanggal"] != null) {
				$this->db->group_start()->where($where["tanggal"])->group_end();
			}
		}
		if ($select) { 
			$select = is_array($select) ? implode(",", $select) : $select;
			$this->db->select($select);
		}
		if ($orderBy) {
		   $orderBy = is_array($orderBy) ? implode(",", $orderBy) : $orderBy;
		   $this->db->order_by($orderBy);
		}

		if ($search) {
			$this->db->group_start()->or_like($search)->group_end();
		}	

		if($join){
			foreach ($join as $j) {
				$this->db->join($j[0],$j[1],isset($j[2]) ? $j[2] : "INNER");
			}
		} 

		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		/*result_array is true or false*/
		return $query->result();
	}

	public function getCountPenjualan($where=false,$select=false,$search=false,$join=false)
	{
		$this->db->from($this->_table);
		if($where) {
			if ($where["data"] != null) {
				$this->db->where($where["data"]);
			}
			if ($where["tanggal"] != null) {
				$this->db->group_start()->where($where["tanggal"])->group_end();
			}
		}
		if ($select) { 
			$select = is_array($select) ? implode(",", $select) : $select;
			$this->db->select($select);
		}
		if ($search) {
			$this->db->group_start()->or_like($search)->group_end();
		}
		if($join){
			foreach ($join as $j) {
				$this->db->join($j[0],$j[1],isset($j[2]) ? $j[2] : "INNER");
			}
		} 
		return $this->db->count_all_results();
	}

	public function findDataTablePenjualan($where=false,$select=false,$columnsOrderBy=false,$search=false,$join=false)
	{
		$input = $this->input;
		$orderBy = false;

		if ($columnsOrderBy) {	
			if (isset($_POST['order'])) {
				$valColumnName = $columnsOrderBy[$_POST['order']['0']['column']];
				$valKeyword = $_POST['order']['0']['dir'];
				$orderBy = array($valColumnName." ".$valKeyword);
			}
		}
		if ($search) {
			$dataSearch = array();
			foreach ($search as $val) {
				$dataSearch[$val] = $this->input->post("search")["value"];
			}
			$search = $dataSearch;
		}
		$data = $this->findDataPenjualan($where,$select,$orderBy,$search,$join,$input->post("length"),$input->post("start"));
		$no = $this->input->post("start");
		foreach ($data as &$item) {
			$no++;
			$item->no = $no;
		}
		return $data;
	}

	public function findDataTableOutputPenjualan($data=null,$where=false,$select=false,$search=false,$join=false)
	{
		$input = $this->input;
		if ($search) {
			$dataSearch = array();
			foreach ($search as $val) {
				$dataSearch[$val] = $this->input->post("search")["value"];
			}
			$search = $dataSearch;
		}
		$response = new stdClass();

		$response->draw = !empty($input->post("draw")) ? $input->post("draw"):null;
		$response->recordsTotal = $this->getCountPenjualan($where,$select,$search,$join);
		$response->recordsFiltered = $this->getCountPenjualan($where,$select,$search,$join);
		$response->data = $data;

		parent::json($response);
	}
}

/* End of file Penjualan_model.php */
/* Location: ./application/models/transaksi/Penjualan_model.php */