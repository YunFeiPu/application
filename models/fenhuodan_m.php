<?php
class Fenhuodan_m extends CI_Model {
	const TBLNAME = "fenhuodan";
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 添加分货单到数据库
	 * 
	 * @param array() $arr        	
	 */
	function insert($arr) {
		$this->db->insert ( TBLNAME, $arr );
	}
	
	/**
	 * 修改分货单
	 * 
	 * @param int $id        	
	 * @param array() $arr        	
	 */
	function update($id, $arr) {
		$this->db->where ( 'id', $id );
		$this->db->update ( TBLNAME, $arr );
	}
	
	/**
	 * 删除分货单
	 * 
	 * @param unknown $id        	
	 */
	function delete($id) {
		$this->db->where ( 'id', $id );
		$this->db->delete ( TBLNAME );
	}
	function getByByOrderNum() {
	}
}