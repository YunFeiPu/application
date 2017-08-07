<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * @author YunFei
 *        
 */
class Gonghuodan_m extends CI_Model {
	private $dbt_name = 'gonghuodan';
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	
	/**
	 * **
	 * 添加供货单
	 *
	 * @param 供应商id $gys_id        	
	 * @param 供货单日期 $ghd_date        	
	 * @param double $ghd_jine
	 *        	供货单金额
	 * @param double $ghd_jiesuan_jine
	 *        	实际结算金额
	 * @param string $ghd_pic        	
	 * @param string $ghd_beizhu        	
	 * @return unknown
	 */
	private function insert($gys_id, $ghd_date, $ghd_jine, $ghd_jiesuan_jine, $ghd_pic, $ghd_beizhu) {
		$arr = array (
				'gys_id' => $gys_id,
				'ghd_date' => $ghd_date,
				'ghd_jine' => $ghd_jine,
				'ghd_jiesuan_jine' => $ghd_jiesuan_jine,
				'ghd_state' => 1,
				'ghd_pic' => "",
				'ghd_beizhu' => $ghd_beizhu 
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
	private function update($gys_id, $ghd_date, $ghd_jine, $ghd_jiesuan_jine, $ghd_pic, $ghd_beizhu, $where_id) {
		$this->db->where ( 'ghd_id', $where_id );
		$arr = array (
				'gys_id' => $gys_id,
				'ghd_date' => $ghd_date,
				'ghd_jine' => $ghd_jine,
				'ghd_jiesuan_jine' => $ghd_jiesuan_jine,
				'ghd_pic' => "",
				'ghd_beizhu' => $ghd_beizhu 
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
	private function getbyid($ghd_id) {
		$this->db->where ( 'ghd_id', $ghd_id );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
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
	function getghdlistbydate($order_date, $ghd_state = 1) {
		$sql = "select `gys_name`,`ghd_id`,`ghd_date`,`gys_id`,`ghd_jine`, `ghd_jiesuan_jine` from `gonghuodan` left join `gongyingshang` 
				on `gonghuodan`.`id_gys`= `gongyingshang`.`gys_id` where ghd_date = ? ";
		if ($ghd_state == 1) {
			$sql .= " and ghd_state = 1 ";
		}
		
		
		$query = $this->db->query ( $sql, array($order_date));
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return null;
		}
	}
	
	/**
	 * *
	 * 2017-04-11
	 * 判断供货单是否存在
	 *
	 * @param unknown $order_date        	
	 * @param unknown $gys_name
	 *        	return true|false
	 */
	function isghdexsited($order_date, $gys_name) {
		$sql = "select * from `gonghuodan` left join `gongyingshang` on 
					gonghuodan.id_gys = gongyingshang.gys_id where `ghd_date` = ? and `gys_name` = ?";
		$query = $this->db->query ( $sql, array (
				$order_date,
				$gys_name 
		) );
		if ($query->num_rows () > 0) {
			return $query->row ()->ghd_id;
		} else {
			return 0;
		}
	}
	
	/**
	 * *
	 * 2017-04-11
	 * 根据供货单id 返回供货单，复合数据
	 *
	 * @param unknown $gyd_id        	
	 */
	function getghdbyid($ghd_id, $state = 1) {
		$sql = "select * from `gonghuodan` where ghd_id = ? and ghd_state = ?";
		$query = $this->db->query ( $sql, array (
				$gyd_id,
				$state 
		) );
		if ($query->num_rows () > 0) {
			$data ['gonghuodan'] = $query->row ();
			$sql = "select `gonghuodan_mingxi`.*,`product`.`pname` from `gonghuodan_mingxi` left join `product` 
					on `gonghuodan_mingxi`.`p_id` = `product`.id where id_ghd = ? and ghd_mx_state = ? ";
			$query = $this->db->query ( $sql, array (
					$gyd_id,
					$state 
			) );
			if ($query->num_rows () > 0) {
				$data ['gonghuodan_mx'] = $query->result ();
			}
		} else {
			return null;
		}
		return $data;
	}
	
	/***
	 *根據日期生成供貨單，$ghdid =0,生成所有，衹能生成一次，衹有衹能靠修改
	 * @param unknown $date
	 * @param number $gyd_id
	 */
	function createghd($date,$ghd_id = 0){
		$sql = "Insert into gonghuodan(id_gys, ghd_date, ghd_jine,ghd_jiesuan_jine,ghd_state,ghd_pic,ghd_beizhu) 		select gys_id,?,0,0,1,'','' from  (select description from (
        SELECT product.categoryid  FROM `order` left join `product` on
         `order`.`pid` =  `product`.`id`
							where `order`.`otime` =?)
                            as a1  left join productcategory on a1.categoryid = productcategory.id  group by description) as a2 left join gongyingshang on
                            a2.description = gongyingshang.gys_name";
		$query = $this->db->query($sql,array($date,$date));
	}
	
	function createghdmx($date){
		$sql = "
				
				select  gonghuodan.ghd_id ,pid,qty,pprice,qty*pprice as heji
					from (
						select pid,qty, pprice ,description, gongyingshang.gys_id,gongyingshang.gys_name 
						from (
							SELECT a2.pid ,qty ,pprice,description 
							from (
								select pid ,qty, product.pprice, product.categoryid from (
									SELECT pid,sum(qty)  as qty  FROM `order` 
									where otime =?
									group by pid 
									) as a1 
								left join product on a1.pid = product.id
								) as a2 left join productcategory on categoryid = productcategory.id
						) as a3 left join gongyingshang on a3.description = gongyingshang.gys_name
					) as a4 left join gonghuodan on a4.gys_id = gonghuodan.id_gys where gonghuodan.ghd_date = ?					";
		$query = $this->db->query($sql,array($date,$date));
		return $query;
	}
	
	/***
	 * 
	 * @param unknown $gys_id
	 * @return unknown|NULL
	 */
	function getghdlistbygysid($gys_id,$date=""){
		if($date == ""){
		$sql = "SELECT gongyingshang.gys_id,  gys_name,ghd_date,ghd_jine,ghd_jiesuan_jine,ghd_id FROM gonghuodan left join gongyingshang on gonghuodan.id_gys = gongyingshang.gys_id where gys_id = ? order by ghd_date asc ";
		
		$query = $this->db->query($sql,array($gys_id));
		}else{
			$sql = "SELECT gongyingshang.gys_id,  gys_name,ghd_date,ghd_jine,ghd_jiesuan_jine,ghd_id FROM gonghuodan left join gongyingshang on gonghuodan.id_gys = gongyingshang.gys_id where gys_id = ? and ghd_date between ? and ? order by ghd_date asc ";
			$query = $this->db->query($sql,array($gys_id, $date.'-01',$date.'-31'));
			
			
		}
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
		
	}
	
	/***
	 * 添加当天没有的供货单
	 */
	function addgonghuodan($gys_name,$ghd_date){
		$this->load->model("gongyingshang_m");
		$this->load->model("gonghuodan_m");
		$query = $this->gongyingshang_m->getbyname($gys_name);
		if(!isset($query)){
			return;
		}
		$this->insert($query->id_gys, $ghd_date, 0, 0, '', '');	
	}
	
	function delegonghuodan_bakdatabydate($date){
		$sql = "select ghd_id from gonghuodan_bak where ghd_date =?";
		$query = $this->db->query($sql,$date);
		if($query->num_rows()>0){
			foreach ($query->result() as $item){
				$sql = "delete from gonghuodan_mingxi_bak where ghd_id = ?";
				$this->db->query($sql,array($item->ghd_id));
			}
		}
		$sql = "delete from gonghuodan_bak where ghd_date = ?";
		$this->db->query($sql,array($date));
	}
	
	function delegonghuodandatabydate($date){
		$sql = "select ghd_id from gonghuodan where ghd_date =?";
		$query = $this->db->query($sql,$date);
		if($query->num_rows()>0){
			foreach ($query->result() as $item){
				$sql = "delete from gonghuodan_mingxi where ghd_id = ?";
				$this->db->query($sql,array($item->ghd_id));
			}
		}
		$sql = "delete from gonghuodan where ghd_date = ?";
		$this->db->query($sql,array($date));
	}
	
	
}
