<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * @author YunFei
 *        
 */
class Productgrouppricelog_m extends CI_Model {
	private $dbt_name = 'productgrouppricelog';
	private $keyid = "id";
	function __construct() {
		parent::__construct ();
		$this->load->database ();
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
	
	
	/***
	 * rebulid 添加用户组价格
	 * @param unknown $sdate
	 * @param unknown $groupid
	 * @param unknown $pid
	 * @param unknown $groupprice
	 */
	public function insertgrouppricelog($sdate,$groupid,$pid,$groupprice){
		$dbhost = $this->db->hostname;  // mysql服务器主机地址
		$dbuser = $this->db->username;            // mysql用户名
		$dbpass = $this->db->password;          // mysql用户名密码
		$dbname = $this->db->database;
		$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		/* check connection */
		if(mysqli_connect_errno()){
			printf('连接数据库错误 %s', mysqli_connect_error());
			exit();
		}
		
		$sql_check_eq_sdate = "select id from productgrouppricelog where pid = ? and groupid = ? and sdate = ?";
		$stmt = $mysqli->prepare($sql_check_eq_sdate);
		$stmt->bind_param('iis', $pid,$groupid,$sdate) ;
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		return;
		//检查有没有 sdate = $sdate的 获取 update
		$sql = " ";
		$query = $this->db->query($sql,array($pid,$groupid,$sdate));
		if($query->num_rows()>0)
		{
			$sql = "update productgrouppricelog set groupprice = ? where pid = ? and groupid = ? and sdate = ?";
			$this->db->query($sql, array($inprice, $sprice, $pid,$groupid, $sdate));
			return;
		}
		
		
		//检查有没有 edate = $sdate的 update edate -1  insert sdate = $sdate
		$sql = "select id from productgrouppricelog where pid = ? and groupid = ? and edate = ?";
		$query = $this->db->query($sql,array($pid,$groupid,$sdate));
		if($query->num_rows()>0)
		{
			$sql = "update productgrouppricelog set edate = date_sub(?,interval 1 day) where pid = ? and groupid = ?";
			$this->db->query($sql, array($sdate,$pid,$groupid));
			$sql = "INSERT INTO `productgrouppricelog`
					(
					`pid`,
					`sdate`,`edate`,
					`groupprice`,
					`groupid`
					)
					VALUES(?,?,?,?,?)";
			$this->db->query($sql,array($pid,$sdate,$sdate,$groupprice,$groupid));
			return;
		}
		
		$sql = "select * from productgrouppricelog where ? bet
				
				ween sdate and edate and pid = ? and groupid = ?";
		$query = $this->db->query($sql, array($sdate, $pid, $groupid));
		if($query->num_rows()>0){
			$item = $query->row();
			$sql = "update productgrouppricelog set edate = date_sub(?,interval 1 day) where id = ?";
			$this->db->query($sql,array($sdate,$item->id));
			$sql ="INSERT INTO `productpricelog`
					(
					`pid`,
					`sdate`,`edate`,
					`groupprice`,
					`groupid`
					)
					VALUES (?,?,?,?,?)";
			$this->db->query($sql, array($pid,$sdate,$item->edate,$groupprice,$groupid));
		}
	}
	
	public function getpricelog($sdate,$pid){
		$sql = "select * from productgrouppricelog where pid = ? and groupprice = ? and ? between sdate and edate ";
		$query = $this->db->query($sql, array($pid,$sdate));
		if($query->num_rows()>0){
			return $this->query->row();
		}
		else{
			return null;
		}
		
		
	}
	
}
