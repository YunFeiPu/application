<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quickorder_m extends CI_Model{

function __construct() {
parent::__construct();
$this->load->database();
}

function insert($arr){
$this->db->insert('quickorder',$arr);
}

function update($id,$arr){
$this->db->where('id',$id);
$this->db->update('quickorder',$arr);
}

function delete($id){
$this->db->where('id',$id);
$this->db->delete('quickorder');
}

function get($id){
$this->db->where('id',$id);
$this->db->select('*');
$query = $this->db->get('quickorder');
$query1 = $query->result();
return $query1[0];
}

function getall(){
$this->db->select('*');
$this->db->order_by('id','asc');
$query = $this->db->get('quickorder');
return $query->result();
}

function getallselect(){
    $this->db->select('id,pname');
    	$array = array();
    	$array['0'] = "--请选择--";
    	$query = $this->db->get('quickorder');
    	
	    if ($query->num_rows() > 0)
		{
		  foreach ($query->result() as $rows)
		  {
		      $array[$rows->id] = $rows->pname;		      
		  }
		 
		}
    			
		return $array;
    
}




function AssembleData(){
$pid = $_POST['v_pid'];
$nickname = $_POST['v_nickname'];
$arr = array(
'pid' => $pid,
'nickname' => $nickname);
return $arr;
} 
    
/*
 * 根据简称查询完整的产品名字
 * 返回查询结果
 * 
 */
function Getbynickname($nickname){
	$this->db->select('product.id,product.pname');
	$this->db->from('quickorder');
	$this->db->join('product', 'quickorder.pid = product.id');
	$this->db->like('nickname', '|'.$nickname.'|');
	$query = $this->db->get();
	if($query->num_rows()>0){
		//找到返回pid，可能多个PID
		return $query;
	}
	else{
		//没有找到
		return null;
	}
}
    
  
    /**
     * 判断产品名称是否已经存在
     * @param string $pname
     * @return boolean
     */
    function isNameExsits($pname){
        $this->db->select('*');
        $this->db->from('quickorder');
        $this->db->where('nickname',$pname);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return true;
        }
        else{
            return false;
        }   
    }
        
}
?>
