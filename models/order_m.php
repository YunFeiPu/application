<?php
class Order_m extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
        $this->db->insert('order',$arr);
    }
    
    function update($id,$arr){
        $this->db->where('id',$id);
        $this->db->update('order',$arr);
    }
    
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('order'); 
    }
	
	function delete_id_in($ids){
		$sql = "delete from `order` where id in(".$ids.")"	;
		$this->db->query($sql);
	}
    
    function getall(){
        $query = $this->db->query('SELECT `custom`.cname, b . *
FROM (

SELECT `order`.id, `oid` , `pid` , `cid` , `product`.`pname` AS pname, `order`.qty AS qty, `order`.pprice AS pprice, `order`.otime
FROM `erp`.`order`
LEFT JOIN `product` ON `order`.`pid` = `product`.`id`
)b
LEFT JOIN `custom` ON `custom`.id = b.cid
ORDER BY oid DESC , id ASC ');
        return $query->result();
    }
    
    
    function getorderbysearch($pname,$otime){
    	$sql = "select `order`.id as idorder, cname, otime,qty,pprice,ptotal,oid  from `order` left join custom on `order`.cid = custom.id where pid in(SELECT id from product where pname = ?) and otime =?  order by qty desc ";
    	$query = $this->db->query($sql,array($pname,$otime));
    	return $query->result();
    }
    
    
    
    
    function getorderlist(){
        $query = $this->db->query('SELECT cname, aa . * 
FROM (

SELECT oid, cid, SUM( ptotal ) as ptotal , otime
FROM  `order` 
GROUP BY oid
)aa
LEFT JOIN custom ON custom.id = aa.cid order by otime desc');
         return $query->result();
    }
    

    
    function getsumbydate($date){
        $sql = "select product.pname,c.pid,c.qty from  (SELECT pid, sum( qty ) AS qty FROM ( SELECT pid, qty FROM `order` WHERE otime = ? )b GROUP BY pid) c  left join product on c.pid = product.id";
        $query =  $this->db->query($sql,array($date));
        return $query->result();
    } 
    
    
    function AssembleData(){
        $oid = $_POST['v_oid'];
        $pid = $_POST['v_pid'];
        $cid = $_POST['v_cid'];
        $qty = $_POST['v_qty'];
        $pprice = $_POST['v_pprice'];
        $otime = $_POST['v_otime'];
        $timestamp = $_POST['v_timestamp'];
        $arr = array(
            'oid' => $oid,
            'pid' => $pid,
            'cid' => $cid,
            'qty' => $qty,
            'pprice' => $pprice,
            'otime' => $otime,
            'timestamp' => $timestamp
        );
        return $arr; 
    }
    
    /**
     * 返回数组形式的列表
     * @param type $orderid
     */
    function getListByOrderIdArr($orderid){
         //$sql = "CALL P_GET_ORDER('$orderid');";
         $sql = "select A1.*, custom.cname,custom.ctel from (SELECT `order`.* , `product`.pname,`product`.pset FROM `order` LEFT JOIN `product` on `order`.pid = `product`.id  where `order`.oid = ?) as A1 LEFT JOIN `custom` on A1.cid = `custom`.id order by pname";
        $query = $this->db->query($sql,array($orderid));
         if ($query->num_rows()>0){
            return $query->result_array();
        }
        else{
            return null;
        }
    }
    
    
    function getOrderListByOrderId($orderid){
    	$sql = "SELECT `order`.* FROM `order` where `order`.oid = ?";
    	$query = $this->db->query($sql,array($orderid));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    }
    
    
    
    function getlistbyorderid($orderid){
         $sql = "select A1.*, custom.cname,custom.ctel from (SELECT `order`.* , `product`.pname,`product`.pset FROM `order` LEFT JOIN `product` on `order`.pid = `product`.id  where `order`.oid = ?) as A1 LEFT JOIN `custom` on A1.cid = `custom`.id order by pname";
        $query = $this->db->query($sql,array($orderid));
         if ($query->num_rows()>0){
            return $query->result();
        }
        else{
            return null;
        }
    }
    
    /**
     * 根据order表主键 ID 获取OrderInfo（single） 如果 没有 返回空
     * 
     * @param integer $orderid
     */
    function getByOid($orderid){
        $this->db->from('order');
        $this->db->where('id',$orderid);
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }else{
            return null;
        }
    }
    
    /***
     * 根据订单编号获取orderinfo
     * @param unknown $orderNum
     * @return unknown|NULL
     */
    function getByOrderNum($orderNum){
    	$this->db->from('order');
    	$this->db->where('oid',$orderNum);
    	$query= $this->db->get();
    	if($query->num_rows()>0){
    		return $query->row();
    	}else{
    		return null;
    	}
    }
    
    /**
     * 根据订单号删除整个订单
     * @param type $oid
     */
    function deleByOid($oid){
        $this->db->where('oid', $oid);
        $this->db->delete('order'); 
    
    }
    
    /**
     * 获取某一天的采购订单
     * @param date $date
     * @return unknown|NULL
     */
    function getProductBuyList($date){
        $sql = "select b1.*,productcategory.description from(select a1.*,product.pname,product.pprice,product.categoryid from (SELECT pid,sum(qty)  as qty  FROM `order` where otime =?  group by pid order by pid )as a1 left join product on a1.pid = product.id) as b1 left join productcategory on b1.categoryid = productcategory.id  order by description,pname";
        $query =  $this->db->query($sql,array($date));
        if ($query->num_rows()>0){
            return $query->result();
        }
        else{
            return null;
        }
    }
    
    /**
     * 获取某一天的采购订单总表，显示某一个供应商定了多少金额的货
     * @param unknown $date
     * @return unknown|NULL
     */
    function getbuylisttotal($date){
    	$sql = "SELECT `productcategory`.`id`, `aa`.`total` , `productcategory`.`description` from(
SELECT sum(`order`.`qty`* (`product`.`pprice`))  as `total`, `product`.`categoryid`  from `order` LEFT JOIN `product` on `order` .`pid`  = `product` .id WHERE 
`order`.`otime` = ? group by `product`.`categoryid` 
    ) as `aa` 
LEFT JOIN `productcategory`  on `aa`.`categoryid` = `productcategory`.`id`";
    	$query =  $this->db->query($sql,array($date));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    }
    
    
    /***
     * 返回一个某天有进货的供应商名字列表
     * @param unknown $date
     * @return unknown|NULL
     */
    function getgys_namelistbydate($date){
    	$sql = "SELECT `productcategory`.`description`  from  (
    			select `categoryid` from `order` 
    			left join `product` on `order`.pid = `product`.`id` 
    			where otime=? GROUP BY `categoryid` 
 				) as a1 
    			LEFT JOIN `productcategory`  
    			on `productcategory` .`id`  = a1.`categoryid`";
    	$query = $this->db->query($sql,array($date));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    }
    
    /***
     * 查找某一天某个供应商的进货单
     * @param string $gys_name
     * @param date $date
     */
    function getproductbuylistbygys_name($gys_name, $date){
    	$sql = "select b1.*,productcategory.description 
    			from(
    			select a1.*,product.pname,product.pprice,product.categoryid 
    			from (
    			SELECT pid,sum(qty)  as qty  
    			FROM `order` 
    			where otime =?  group by pid order by pid 
    			)as a1 
    			left join product 
    			on a1.pid = product.id
    			) as b1 
    			left join productcategory 
    			on b1.categoryid = productcategory.id 
    			where productcategory.description = ?
    			order by description,pname";
    	$query =  $this->db->query($sql,array($date,$gys_name));
    	if ($query->num_rows()>0){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    }
    
    /**
     * 根据送货日期 返回订单总表
     * @param type $date
     * @return null
     */
    function getOrderListByDate($date){
         $sql = 'SELECT MM.*, shiporder.ShipCateId FROM (
SELECT cname, aa . *  FROM ( SELECT oid, cid, SUM( ptotal ) as ptotal , otime FROM  `order` WHERE otime = ? GROUP BY oid )aa LEFT JOIN custom ON custom.id = aa.cid
) MM left join shiporder on MM.oid = shiporder.OrderNum order by ShipCateId asc,ptotal desc';
         $query =  $this->db->query($sql,array($date));
        if ($query->num_rows()>0){
            return $query->result();
        }
        else{
            return null;
        }
        
    }
    
    
    function checkorder($cname,$otime){
        $sql = 'select * from `order` left join custom on `order`.cid = custom.id  where otime = ? and cname = ?';
        $query = $this->db->query($sql,array($otime,$cname));
        if ($query->num_rows()>0){
            return $query->row()->oid;
        }
        else{
            return 0;
        }
    }
    
    
    /*检查订单 有没有重复项目*/
    function checkitem($date){
    	$this->load->library('validate');
    	$arr = array();
    	if($this->validate->is_date($date)){
       		
	        $sql = "SELECT  RIGHT (aaa.`pco`,18) as oid from (select concat_ws(',',`pid`,`cid` ,`oid` ) AS 'pco'   from `order` where otime = ?    GROUP BY pco HAVING  COUNT(pco)>1)AS  aaa  ORDER BY  oid DESC ";
	        $query = $this->db->query($sql, array($date));
	         if ($query->num_rows()>0){
	             foreach($query->result() as $item){
	                 array_push($arr,$item->oid);
	             }
	        }
    	}
    	return $arr;
    }
    
    /**
     * 
     * @param type $arr_where
     * @param type $arr_orderby
     * @return null
     */
    function getOrderListByArr($arr_where,$arr_orderby){
    	$this->load->library('validate');

    	
        $sql = "SELECT cname, aa . *  FROM ( SELECT oid, cid, SUM( ptotal ) as ptotal , order_state, otime "
                . "FROM  `order` WHERE 1=1 ";
        $_arr = array();

        if( array_key_exists('s_otime',$arr_where) && $this->validate->is_date($arr_where['s_otime']) && array_key_exists('e_otime',$arr_where) && $this->validate->is_date($arr_where['e_otime'])){
            $sql .= " and otime between ? and ? ";
            array_push($_arr, $arr_where['s_otime']);
            array_push($_arr, $arr_where['e_otime']);

        }
        elseif(array_key_exists('s_otime',$arr_where) && $this->validate->is_date($arr_where['s_otime'])){
            $sql .= " and otime = ? ";
            array_push($_arr, $arr_where['s_otime']);

        }
        
        if( array_key_exists('order_state',$arr_where)){
        	if($arr_where['order_state'] == 'not3'){
        		$sql .= " and (order_state = 0 or order_state = 1 or order_state = 2)  ";
        	}
        	else if($arr_where['order_state'] == '1_2')
        	{
        		$sql .= " and (order_state = 1 or order_state = 2) ";
        	}
        	else if($arr_where['order_state'] == '3_4')
        	{
        		$sql .= " and (order_state = 3 or order_state = 4) ";
        	}
        	else if($arr_where['order_state'] == 'all'){
        		$sql .= " and order_state <> 5 ";
        	}
        	else{
        		$sql .= " and order_state = ? ";
        		array_push($_arr, $arr_where['order_state']);
        	}
        }
        
        
        $sql .= " GROUP BY oid )aa LEFT JOIN custom ON custom.id = aa.cid where 1=1 order by  ";
        if(isset($arr_where['cname'])){
            $sql .= "and cname = ? ";
            array_push($_arr, $arr_where['cname']);
        }
        /*
        if(isset ($arr_orderby['cname'])){
            $sql .= " cname ".$arr_orderby['cname'];
        }
        if(isset ($arr_orderby['otime'])){
             $sql .= " otime ".$arr_orderby['otime'];
        }
        if(isset ($arr_orderby['ptotal'])){
             $sql .= " ptotal ".$arr_orderby['ptotal'];
        }
        */
        
        switch ($arr_orderby)
        {
        	case "total_asc":
        		$sql .= " ptotal asc " ;
        		break;
        	case "otime_desc":
        		$sql .= " otime desc " ;
        		break;
        		case "otime_asc":
        			$sql .= " otime asc " ;
        			break;
        			case "cname_desc":
        				$sql .= " cname desc " ;
        				break;
        				case "cname_asc":
        					$sql .= " cname asc " ;
        					break;
        	default:
        		$sql .= " ptotal desc " ;
        }
        
        
        
        
        
        $query = $this->db->query($sql,$_arr);
    	if ( $query->num_rows()>0 ){
    		return $query->result();
    	}
    	else{
    		return null;
    	}    	
    }
    
    
    
    /**
     * 
     * @param $arr_where : order_state|order_num
     * @return object array or NULL
     */
    function getList($arr_where){
    	$sql = " SELECT A1.*, custom.cname,custom.ctel from (
    			SELECT `order`.* , `product`.pname,`product`.pset 
    			FROM `order` LEFT JOIN `product` 
    			on `order`.pid = `product`.id  where 1=1  ";
                 
    	$_arr = array();
    	
    	if(isset($arr_where['order_state'])){
    		$sql .= " and order_state = ? ";
    		array_push($_arr, $arr_where['order_state']);
    	}
    	if(isset($arr_where['order_num'])){
    		$sql .= " and oid = ? ";
    		array_push($_arr, $arr_where['order_num']);
    	}
    	    	
    	$sql .= " ) as A1 LEFT JOIN `custom` on A1.cid = `custom`.id order by otime desc  ";
    	
    	$query = $this->db->query($sql,$_arr);
    	if ( $query->num_rows()>0 ){
    		return $query->result();
    	}
    	else{
    		return null;
    	}    	
    	
    }
    
    
    
    /**
     * 用来查看各种状态的订单
     * @param unknown $arr_where
     * @return NULL
     */
    function getOrderMain($arr_where =array()){
    	$sql = "SELECT cname, aa . *  FROM ( SELECT oid, cid, SUM( ptotal ) as ptotal , otime , order_state FROM  `order` WHERE 1=1 ";    			 
    	
    	$_arr = array();
    	 
    	if(isset($arr_where['order_state'])){
    		$sql .= " and order_state = ? ";
    		array_push($_arr, $arr_where['order_state']);
    	}
    	if(isset($arr_where['order_num'])){
    		$sql .= " and oid = ? ";
    		array_push($_arr, $arr_where['order_num']);
    	}
    	
    	$sql .= " GROUP BY oid )aa LEFT JOIN custom ON custom.id = aa.cid order by otime desc ";
    	 
    	$query = $this->db->query($sql,$_arr);
    	if ( $query->num_rows()>0 ){
    		return $query->result();
    	}
    	else{
    		return null;
    	}
    	 
    }
    
    
    function updateOrderState($orderid,$order_state){
    	$sql = " update `order` set order_state = ? where oid = ? ";
    	$query = $this->db->query($sql,array($order_state,$orderid));
    }
    
    
    /***
     * 2017-04-10
     * 判断某一个供应商某天是否有订货单
     * @param unknown $order_date
     * @param unknown $gys_name
     * return ture|false
     */
    function isdingdanexsited($order_date, $gys_name){
    	$result = self::getproductbuylistbygys_name($gys_name, $order_date);
    	return isset($result);
    }
    
    /***
     * 2017-04-10
     * 获取某一个供应商某天的订货单
     * @param unknown $order_date
     * @param unknown $gys_name
     * return ture|false
     */
    function getdingdan($order_date,$gys_name){
    	$result = self::getproductbuylistbygys_name($gys_name, $order_date);
    	$total = 0;
    	foreach($result as $item){
    		$total += $item->pprice*$item->qty;
    	}
    	$data['total'] = $total;
    	$data['item_list'] = $result;
    	return $data;
    }
    
    

}