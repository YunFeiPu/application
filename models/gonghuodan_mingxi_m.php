<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * @author YunFei
 *        
 */
class Gonghuodan_mingxi_m extends CI_Model {
	private $dbt_name = 'gonghuodan_mingxi';
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	private function insert($ghd_id, $p_id, $p_qty, $ghd_inprice, $ghd_mx_heji, $ghd_mx_state, $ghd_mx_beizhu) {
		$arr = array (
				'ghd_id' => $ghd_id,
				'p_id' => $p_id,
				'p_qty' => $p_qty,
				'ghd_inprice' => $ghd_inprice,
				'ghd_mx_heji' => $ghd_mx_heji,
				'ghd_mx_state' => $ghd_mx_state,
				'ghd_mx_beizhu' => $ghd_mx_beizhu 
		);
		$this->db->insert ( $this->dbt_name, $arr );
		return $this->db->insert_id ();
	}
	
	/**
	 * **
	 * 更新供货单
	 *
	 * @param int $gys_id        	
	 * @param date $ghd_date        	
	 * @param double $ghd_jine
	 *        	自动计算金额
	 * @param double $ghd_jiesuan_jine
	 *        	实际结算金额
	 * @param string $ghd_pic        	
	 * @param string $ghd_beizhu        	
	 * @param int $where_id
	 *        	供货单id
	 */
	private function update($ghd_id, $p_id, $p_qty, $ghd_inprice, $ghd_mx_heji, $ghd_mx_state, $ghd_mx_beizhu, $where_id) {
		$this->db->where ( 'ghd_mx_id', $where_id );
		$arr = array (
				'ghd_id' => $ghd_id,
				'p_id' => $p_id,
				'p_qty' => $p_qty,
				'ghd_inprice' => $ghd_inprice,
				'ghd_mx_heji' => $ghd_mx_heji,
				'ghd_mx_state' => $ghd_mx_state,
				'ghd_mx_beizhu' => $ghd_mx_beizhu 
		);
		$this->db->update ( $this->dbt_name, $arr );
	}
	
	// 删除供货单
	/**
	 * **
	 * 删除供货单
	 *
	 * @param int $ghd_id        	
	 */
	private function delete($ghd_id) {
		$this->db->where ( 'ghd_id', $ghd_id );
		$arr = array (
				'ghd_state' => 0 
		);
		$this->db->update ( $this->dbt_name );
	}
	
	/**
	 * *
	 * 返回单个数据
	 *
	 * @param int $ghd_id        	
	 * @return null 如果查询结果不存在，否则返回单个对象Object
	 */
	private function getbyid($ghd_mx_id) {
		$this->db->where ( 'ghd_mx_id', $ghd_mx_id );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	
	/***
	 * 此方法是修正明细里面的价格和数量的时候用的；
	 * @param unknown $obj_mx
	 */
	public function save_mx($obj_mx){
		
		if(isset($obj_mx)){
			$this->update($obj_mx->ghd_id, $obj_mx->p_id, $obj_mx->p_qty, $obj_mx->ghd_inprice, $obj_mx->ghd_mx_heji, $obj_mx->ghd_mx_state, $obj_mx->ghd_mx_beizhu, $obj_mx->ghd_mx_id);
			
		}
	}
	
	
	/**
	 * **************************************************************
	 */
	
	/**
	 * *
	 * 根据日期获取供货单列表
	 *
	 * @param date $order_date        	
	 * @return object array |NULL
	 */
	function getghdmxlistbyghdid($ghd_id, $ghd_state = 1) {
		$sql = "select b1.*,product.pname from(
select a1.*,gongyingshang.gys_name from (
select gonghuodan_mingxi.*,gonghuodan.ghd_date,id_gys from gonghuodan_mingxi left join gonghuodan on gonghuodan.ghd_id = gonghuodan_mingxi.ghd_id where gonghuodan_mingxi.ghd_id = ?
) as a1 left join gongyingshang on gongyingshang.gys_id = a1.id_gys
) as b1 left join product on b1.p_id = product.id ";

		
		$query = $this->db->query ( $sql, array (
				$ghd_id 
		) );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return null;
		}
	}
	
	/***
	 * 返回某一行供货单明细
	 * @param unknown $mx_id
	 * @return unknown|NULL
	 */
	function getghdmxbymxid($mx_id){
		$sql = "select * from gonghuodan_mingxi where ghd_mx_id = ?";
		$query = $this->db->query($sql, array($mx_id));
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return null;
		}
	}
	
	
	/***
	 * 添加当天没有的供货单明细 可能是库存也可能是退货
	 */
	function addgonghuodanmingxi($ghd_id,$pid,$p_qty,$ghd_inprice,$ghd_mx_heji,$p_qty){
		$bak = "";
		if($p_qty>0)
		{
			$bak ="库存";
		}
		else{
			$bak = "缺货";
		}
		$this->insert($ghd_id, $p_id, $p_qty, $ghd_inprice, $ghd_mx_heji, $p_qty, $bak);
	}
	
}
