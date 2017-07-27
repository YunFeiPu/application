<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Productcategory_m extends CI_Model {
	private $dbt_name = 'productcategory';
	
	function __construct() {
		parent::__construct ();
		//$this->load->model ( 'gongyingshang_m' );
	}
	
	/**
	 * *
	 * 添加產品分類
	 *
	 * @param unknown $arr        	
	 * @return insert id
	 */
	function insert($arr) {
		//如果pid = 0 则添加新的供应商
		if($arr["pid"] == 0){
			$ci  = get_instance();
			$ci->load->model('gongyingshang_m');
			$ci->gongyingshang_m->add_gys ( $arr ["description"] );
		}
		$this->db->insert ( 'productcategory', $arr );
		return $this->db->insert_id ();
	}
	function update($id, $arr) {
		$query = $this->get($id);
		
		if($query->pid == 0 && $arr["pid"] == 0){
			$ci  = get_instance();
			$ci->load->model('gongyingshang_m');
			
			if(isset($query)){
				$query_gys = $ci->gongyingshang_m->getbyname($query->description);
				if(isset($query_gys)){
					$ci->gongyingshang_m->modi_gys($arr["description"],$query_gys->tel,$query_gys->gys_id);		
				}
			}
		}
		
		
		
		$this->db->where ( 'id', $id );
		$this->db->update ( 'productcategory', $arr );
	}
	
	/**
	 * 更新类别的显示状态(事务操作)
	 *
	 * @param int $id        	
	 * @param int $isdel        	
	 */
	function updatestate($id, $isdel) {
		$sql1 = "update product set isdel = ? where categoryid = ?";
		$sql2 = "update productcategory set isdel = ? where id = ?";
		$this->db->trans_begin ();
		$this->db->query ( $sql1, array (
				$isdel,
				$id 
		) );
		$this->db->query ( $sql2, array (
				$isdel,
				$id 
		) );
		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
		} else {
			$this->db->trans_commit ();
		}
	}
	function delete($id) {
		$this->db->where ( 'id', $id );
		$this->db->delete ( 'productcategory' );
	}
	function get($id) {
		$results = $this->db->get_where ( 'productcategory', array (
				'id' => $id 
		) );
		if($results->num_rows()>0){
			return $results->row();
		}else{
			return null;
		}
	}
	
	/**
	 * 显示分类
	 *
	 * @param number $pid
	 *        	= 0 一级大类
	 * @param number $displayall
	 *        	= 0不显示删除的 = 1显示全部
	 */
	function getbypid($pid = 0, $displayall = 0) {
		$this->db->select ( '*' );
		$this->db->where ( 'pid', $pid );
		
		if ($displayall == 0) {
			$this->db->where ( 'isdel', 0 );
		}
		
		$query = $this->db->get ( 'productcategory' );
		return $query->result ();
	}
	
	// 输出Array(id->$description)
	function getbyselect() {
		$this->db->select ( 'id,description' );
		$array = array ();
		$array ['0'] = "--请选择--";
		$query = $this->db->get ( 'productcategory' );
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $rows ) {
				$array [$rows->id] = $rows->description;
			}
		}
		return $array;
	}
	
	function getbydescription($description){
		$this->db->where ( 'description', $description );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	
	
	
	function isexist($description) {
		$query = $this->getbydescription( $description );
	
		if (is_null ( $query )) {
			return false;
		} else {
			return true;
		}
	}
	
}
