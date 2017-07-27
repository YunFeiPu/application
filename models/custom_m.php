<?php
class Custom_m extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
        $this->db->insert('custom',$arr);        
    }
    
    
    function update($id,$arr){
        $this->db->where('id',$id);
        $this->db->update('custom',$arr);
    }
    
    function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('custom');
    }
    
    function get($id){
        $this->db->where('id',$id);
        $this->db->select('*');
        $query = $this->db->get('custom');
        $query1 = $query->result();
        return $query1[0];
    }
     function getall(){
        $this->db->select('*');
        $this->db->order_by('cname','asc');
        $query = $this->db->get('custom');
        return $query->result();
    }
        
    function getlistbycname($cname){
        $this->db->select('*');
        $this->db->like('cname',$cname,'after');
        $this->db->or_like('cname',$cname);
        $this->db->or_like('cname',$cname,'before');
        $query = $this->db->get('custom');
        $query1 = $query->result();

        echo $query1[0]->cname;
        $arr = array();
         foreach ($query1 as $item){
            array_push($arr, $item->cname);
         }
        return $arr;
    }
    /*方法可能有错误*/
    function getbyname($cname){
        $this->db->select('*');
        $this->db->from('custom');
        $this->db->where('cname',$cname);
        $query = $this->db->get();
        $query =  $query->result();
        return $query[0];
        
    }
    
    function newgetbycname($cname){
    	
    	$sql = "select * from custom where custom.cname=?";
		$query = $this->db->query($sql,array($cname));
    	return $query->row();
    	
    }
    
    
    function AssembleData(){
            $cname = $_POST['v_cname'];
            $cusername = $_POST['v_cusername'];            
            $ctel = $_POST['v_ctel'];
            $caddress = $_POST['v_caddress'];
            $groupid = $_POST['v_group_id'];
            $cbak = $_POST['v_cbak'];
             $arr = array(
                'cname'=>$cname,
                'cusername'=>$cusername,
                'ctel'=>$ctel,
                'caddress' => $caddress,
                 'group_id'=>$groupid,
                'cbak'=>$cbak);    
             return $arr;
            
        }
        
        /**
         * 根据客户名称 获取客户Info，如果没有该客户则返回null;
         * @param string $cname
         */
        function getByCname($cname){
            $this->db->select('*');
            $this->db->from('custom');
            $this->db->where('cname',$cname);
            $query = $this->db->get();
            if($query->num_rows()>0){
                return $query->row();
            }else{
                return null;
            }
        }
		
        function getcustomlist($pages){
        	
        }
		
        function getCustomAndGroupList(){
	        $this->db->select('custom.*,customgroup.id as gid,customgroup.groupname');
	        $this->db->from('custom');
	        $this->db->join('customgroup','custom.group_id=customgroup.id','left');
	        $this->db->order_by('cname','asc');
	        $query = $this->db->get();
	        return $query->result();
        }
		
		/***
		 * 根据用户名获取，该用户某个时间段，某个状态的订单列表
		 * $cname =  用户名
		 * $monthcount = 1 默认最近一个月
		 * $orderstate = 订单状态
		 */
		function getorderlistbycustomname($cname,$monthcount=1,$orderstate = 0){
			$btime = date("Y-m-d");
			$atime = date("Y-m-d",strtotime("-".$monthcount." month"));
			//var_dump($btime);
			//$sql = "SELECT sum(`order`.`ptotal`) as `ptotal` , oid, cname,otime,order_state FROM `order` LEFT JOIN `custom`  ON `order`.`cid` = `custom` .id  WHERE `custom` .`cname` =? and `order`.`order_state` = ? and otime BETWEEN  ? and ? GROUP BY oid order by otime asc";
			$sql = "SELECT sum(`order`.`ptotal`) as `ptotal` , oid, cname,otime,order_state FROM `order` 
			LEFT JOIN `custom`  ON `order`.`cid` = `custom` .id  WHERE `custom` .`cname` =? 
			and `order`.`order_state` = ? and `otime` BETWEEN  ? and ? GROUP BY `oid`";
			
			$query = $this->db->query($sql, array($cname,$orderstate,$atime,$btime));
			//$query = $this->db->query($sql);
			if($query->num_rows()>0){
				return $query;
			}
			else {
				return null;
			}
		}
		
}
?>
