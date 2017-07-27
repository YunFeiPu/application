<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * 发货单
 *
 * @author asus
 */
class ShipOrder_m extends CI_Model{
    
	 const tblName = 'shiporder';
	 const keyName = 'idshiporder';
	
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
    	$this->db->insert(ShipOrder_m::tblName,$arr);
    }
    
    function update($id,$arr){
    	$this->db->where(ShipOrder_m::keyName,$id);
    	$this->db->update(ShipOrder_m::tblName,$arr);
    }
    
    function delete($id){
    	$this->db->where(ShipOrder_m::keyName, $id);
    	$this->db->delete(ShipOrder_m::tblName);
    }
    
    function AssembleData(){
    	$shipCateName = $_POST['v_ShipCateName'];

    	$arr = array(
    			'ShipCateName' => $shipCateName
    	);
    	return $arr;
    }
    
    /*
     * 
     * */
    function getShipOrderList($date){
    	$sql = "select bb.* , IF ( shiporder.ShipCateId is null , 0 , shiporder.ShipCateId) ShipCateId from(

SELECT cname, aa . *  FROM ( 
SELECT oid, cid,order_state, SUM( ptotal ) as ptotal , otime FROM  `order` WHERE otime = ? GROUP BY oid 
)aa LEFT JOIN custom ON custom.id = aa.cid order by otime desc
) bb left join shiporder on bb.oid = shiporder.OrderNum order by ShipCateId asc";
    	$query =  $this->db->query($sql,array($date));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    }
    
    function getShipOrder($OrderNum){
    	$sql = "select * from shiporder where ordernum = ? ";
    	$query =  $this->db->query($sql,array($OrderNum));
    	if ($query->num_rows()>0){
    		$row = $query->row();
    		return $row;
    	}
    	else{
    		return null;
    	}
    }
    
    function getproductlistbyshipcateid($shipcateid,$otime){
    	$sql = "select * from product right join (
select pid, sum(qty) qty from  (
select * from `order` left join shiporder  on `order`.oid = shiporder.ordernum where otime = ? and shipcateid = ?
)aa group by pid )bb on product.id = bb.pid order by categoryid ,pname  ";
    	$query =  $this->db->query($sql,array($otime,$shipcateid));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    	
    }
    
}