<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 供应商类
 *
 * @author asus
 */
class gongyingshang_m extends CI_Model {
	private $dbt_name = 'gongyingshang';
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	
	/**
	 * 添加供应商
	 *
	 * @param string $gys_name
	 *        	供应商名称必填
	 * @param string $gys_tel
	 *        	供应商电话
	 * @param number $gys_state
	 *        	供应商状态默认1， 0为删除
	 *        	return gys_id 如果为0则表示添加失败 否则返回最近添加的id
	 */
	private function insert($gys_name, $gys_tel = '', $gys_state = 1) {
		$arr = array (
				'gys_name' => $gys_name);
		if($gys_tel <>''){
			$arr['gys_tel'] = $gys_tel;
		}
		$arr['gys_state'] = $gys_state;

		$this->db->insert ( $this->dbt_name, $arr );
		return $this->db->insert_id ();
	}
	
	// 更新数据
	private function update($gys_name, $gys_tel, $where_id) {
		$this->db->where ( 'gys_id', $where_id );
		if($gys_tel == ''){
			$arr = array (
					'gys_name' => $gys_name
			);
		}
		else{
			$arr = array (
					'gys_name' => $gys_name,
					'gys_tel' => $gys_tel 
			);
		}
		$this->db->update ( $this->dbt_name, $arr );
	}
	
	// 删除供应商
	private function delete($gys_id) {
		$this->db->where ( 'gys_id', $gys_id );
		$arr = array (
				'gys_state' => 0 
		);
		$this->db->delete ( $this->dbt_name );
	}
	
	/**
	 * *
	 * 返回单个数据
	 *
	 * @param int $gys_id        	
	 * @return null | object 如果查询结果不存在，否则返回单个对象Object
	 */
	private function getbyid($gys_id) {
		$this->db->where ( 'gys_id', $gys_id );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	
	/**
	 * *
	 * 根据供应商名查找
	 *
	 * @param unknown $gys_name        	
	 * @return object|NULL
	 */
	public function getbyname($gys_name) {
		$this->db->where ( 'gys_name', $gys_name );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	
	public function getbygys_id ($gys_id){
		return $this->getbyid($gys_id);
	}
	
	/**
	 * *
	 * 添加新用户(外界调用)
	 *
	 * @param string $gys_name        	
	 * @param string $gys_tel        	
	 */
	function add_gys($gys_name, $gys_tel = '') {
		if ($this->isexist ( $gys_name )) {
			return 0;
		} else {
			return $this->insert ( $gys_name, $gys_tel );
		}
	}
	
	function modi_gys($gys_name,$gys_tel = '',$gys_id){
		if ($this->isexist ( $gys_name )) {
			return 0;
		} else {
			return $this->update ( $gys_name, $gys_tel, $gys_id );
		}
	}
	
	/**
	 * *
	 * 检查用户名是否存在重复
	 * 
	 * @param string $gys_name        	
	 * @return boolean
	 */
	function isexist($gys_name) {
		$query = $this->getbyname ( $gys_name );
		
		if (is_null ( $query )) {
			return false;
		} else {
			return true;
		}
	}
	
	function updategysname($old_gys_name,$new_gys_name){
		if($this->isexist($new_gys_name)){
			return "重复！";
		}
		$query = $this->getbyname ( $old_gys_name );
		if (!is_null ( $query )) {
			$this->update($new_gys_name, '', $query->gys_id);
		}
	}
	
	/***
	 * 根据供应商id 获取产品名称列表
	 * @param number $isdel
	 * @return unknown
	 */
	function getnamelistbygysid($gys_id,$isdel = 0){
		$sql = "
select pname from (
select pname,description,pid from product 
				left join productcategory on productcategory.id  = product.categoryid
				where product.isdel = ? 
				) as a1 left join gongyingshang on a1.description = gongyingshang.gys_name where gys_id = ? order by pid";
	
		$query = $this->db->query($sql, array($isdel,$gys_id));
		if($query->num_rows()>0){
		return $query->result();
		}else{
			return  null;
		}
	}
	
}
