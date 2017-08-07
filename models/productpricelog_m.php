<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * @author YunFei
 *        
 */
class Productpricelog_m extends CI_Model {
	private $dbt_name = 'productpricelog';
	private $keyid = "id";
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	
	public function insert($pid,$sdate,$inprice,$sprice) {
		$arr = array (
				  'pid' => $pid,
				  'sdate' =>$sdate,
				  'inprice' =>$inprice,
					'sprice' =>$sprice
		);
		
		$this->db->insert ( $this->dbt_name, $arr );
		return $this->db->insert_id ();
	}
	

	public function update($pid,$sdate,$inprice,$sprice,$whereid) {
		$this->db->where ( $keyid, $whereid );
		$arr = array (
				'pid' => $pid,
				'sdate' =>$sdate,
				'inprice' =>$inprice,
				'sprice' =>$sprice
		);
		$this->db->update ( $this->dbt_name, $arr );
	}
	
	
	/**
	 * *
	 * 返回单个数据
	 *
	 * @param int $ghd_id        	
	 * @return null 如果查询结果不存在，否则返回单个对象Object
	 */
	public  function getbyid($where_id) {
		$this->db->where ( $keyid, $where_id );
		$query = $this->db->get ( $this->dbt_name );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	
	
	
	public function insertpricelog($sdate,$pid,$inprice,$sprice){
		//检查有没有 sdate = $sdate的 获取 update
		$sql = "select id from productpricelog where pid = ? and sdate = ?";
		$query = $this->db->query($sql,array($pid,$sdate));
		if($query->num_rows()>0)
		{
			$sql = "update productpricelog set inprice = ? , sprice = ? where pid = ? and sdate = ?";
			$this->db->query($sql, array($inprice, $sprice, $pid, $sdate));
			return;
		}
		
		
		//检查有没有 edate = $sdate的 update edate -1  insert sdate = $sdate
		$sql = "select id from productpricelog where pid = ? and edate = ?";
		$query = $this->db->query($sql,array($pid,$sdate));
		if($query->num_rows()>0)
		{
			$sql = "update productpricelog set edate = date_sub(?,interval 1 day) where pid = ?";
			$this->db->query($sql, array($sdate,$pid));
			$sql = "INSERT INTO `productpricelog`
					(
					`pid`,
					`sdate`,`edate`,
					`inprice`,
					`sprice`
					)
					VALUES(?,?,?,?,?)";
			$this->db->query($sql,array($pid,$sdate,$sdate,$inprice,$sprice));
			return;
		}
		
		$sql = "select * from productpricelog where ? between sdate and edate and pid = ?";
		$query = $this->db->query($sql, array($sdate, $pid));
		if($query->num_rows()>0){
			$item = $query->row();
			$sql = "update productpricelog set edate = date_sub(?,interval 1 day) where id = ?";
			$this->db->query($sql,array($sdate,$item->id));
			$sql ="INSERT INTO `productpricelog`
					(
					`pid`,
					`sdate`,`edate`,
					`inprice`,
					`sprice`
					)
					VALUES (?,?,?,?,?)";
			$this->db->query($sql, array($pid,$sdate,$item->edate,$inprice,$sprice));
		}
	}
	
	public function getpricelog($sdate,$pid){
		$sql = "select * from productpricelog where pid = ? and ? between sdate and edate ";
		$query = $this->db->query($sql, array($pid,$sdate));
		if($query->num_rows()>0){
			return $this->query->row();
		}
		else{
			return null;
		}
		
		
	}
	
}
