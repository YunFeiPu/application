<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_m extends CI_Model{

function __construct() {
parent::__construct();
$this->load->database();
}

function insert($arr){
$this->db->insert('product',$arr);
}

function update($id,$arr){
$this->db->where('id',$id);
$this->db->update('product',$arr);
}

function delete($id){
$this->db->where('id',$id);
$this->db->delete('product');
}

function get($id){
$this->db->where('id',$id);
$this->db->select('*');
$query = $this->db->get('product');
$query1 = $query->result();
return $query1[0];
}

function getall(){
	$this->db->select('*');
	$this->db->order_by('ishot','desc');
	$this->db->order_by('isnew','desc');
	$this->db->order_by('isdel','asc');
	$this->db->order_by('pname','asc');
	$query = $this->db->get('product');
	return $query->result();
}

function getallselect(){
    $this->db->select('id,pname');
    	$array = array();
    	$array['0'] = "--请选择--";
    	$query = $this->db->get('product');
    	
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
$pname = $_POST['v_pname'];
$categoryid = $_POST['v_categoryid'];
$pprice = $_POST['v_pprice'];
$pset = $_POST['v_pset'];
$pbak1 = $_POST['v_pbak1'];
$updatetime = date('y-m-d h:i:s',time());
$setqty = $_POST['v_setqty'];//包装数量
$sprice = $_POST['v_sprice'];//标准批发价
$rprice = $_POST['v_rprice'];//建议售价
$setprice =  $_POST['v_setprice'];
$py = $_POST['v_py'];

$arr = array(
'pname' => $pname,
'py' => $py,
'categoryid' => $categoryid,
'pprice' => $pprice,
'pset' => $pset,
'pbak1' => $pbak1,
'setqty' => $setqty,
'sprice' => $sprice,
'rprice' => $rprice,
'setprice' => $setprice

);
return $arr;
} 
    
    
    function getbycategorydescription($description,$isdel = 0){
        $this->db->select('product.*,productcategory.description');
        $this->db->from('product');
        $this->db->join('productcategory','product.categoryid = productcategory.id','left');
        $this->db->where('productcategory.description',$description);
        $this->db->where('product.isdel',$isdel);
        $this->db->order_by('product.ishot','desc');
        $this->db->order_by('product.isnew','desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getByPname($pname){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('pname',$pname);
        $query = $this->db->get();
        if($query->num_rows()>0){
        $query =  $query->row();
        return $query;
        }
        else{
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
        $this->db->from('product');
        $this->db->where('pname',$pname);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return true;
        }
        else{
            return false;
        }   
    }
    
    function getallnamelist($isdel = 0){
    	$this->db->select('pname');
    	$this->db->from('product');
    	$this->db->where('isdel',$isdel);
    	$query = $this->db->get();
    	return $query->result();
    }
	
	function getallnamepylist($isdel = 0){
		$sql = "select concat(`pname`,',',`py`) as `pname` from product where isdel = ?";
		$query = $this->db->query($sql,array($isdel));
    	return $query->result();
	}
        
}
?>
