<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang_model extends MY_Model {

	public function __construct()
	{
		parent::__construct("laporan_gudang");
	}

	public function findDataLpGudang($where=false,$select=false,$orderBy=false,$search=false,$join=false,$limit=0,$offset=0)
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

	public function getCountLpGudang($where=false,$select=false,$search=false,$join=false)
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

	public function findDataTableLpGudang($where=false,$select=false,$columnsOrderBy=false,$search=false,$join=false)
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
		$data = $this->findDataLpGudang($where,$select,$orderBy,$search,$join,$input->post("length"),$input->post("start"));
		$no = $this->input->post("start");
		foreach ($data as &$item) {
			$no++;
			$item->no = $no;
		}
		return $data;
	}

	public function findDataTableOutputLpGudang($data=null,$where=false,$select=false,$search=false,$join=false)
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
		$response->recordsTotal = $this->getCountLpGudang($where,$select,$search,$join);
		$response->recordsFiltered = $this->getCountLpGudang($where,$select,$search,$join);
		$response->data = $data;

		parent::json($response);
	}

}

/* End of file Gudang_model.php */
/* Location: ./application/models/laporan/Gudang_model.php */