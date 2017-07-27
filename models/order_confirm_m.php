<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Code
 *
 * @author asus
 */
class Order_confirm_m extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }   
    
    function insert($arr){
        $this->db->insert('order_confirm',$arr);        
    }
    
    
    function update($id,$arr){
        $this->db->where('id',$id);
        $this->db->update('order_confirm',$arr);
    }
    
    function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('order_confirm');
    }
    
    function get($id){
        $this->db->where('id',$id);
        $this->db->select('*');
        $query = $this->db->get('order_confirm');
        $query1 = $query->result();
        return $query1[0];
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
     * 
     * @param type $arr
     * @return type
     */
    function getOrderList($arr){
        
        
        $sql = " select `order`.* from `order`  left join `custom` on `order`.cid = `custom`.id  where 1=1 ";

        if(isset($arr['cname'])){
            //$this->db->join('custom','order.cid = custom.id','left');
           // $this->db->where('cname',$arr['cname']);
             $sql .= " and `custom`.cname = '{$arr['cname']}' ";
        }
        
        if(isset($arr['otime'])){
            $sql .= " and otime = '{$arr['otime']}' ";
        }
        else if(isset($arr['atime']) && isset($arr['btime'])){
            $sql .= " and otime between '{$arr['atime']}' and '{$arr['btime']}' ";
        }
        $sql .= " order by  otime asc ";
        
        $sqlwrap = "select a1.*,product.pname from (" . $sql .") a1 left join product on a1.pid = product.id  ";
        
        
        
        
        $query = $this->db->query($sqlwrap);
       // return $sqlwrap;
        if($query->num_rows()>0){
            return $query;
        }
        else{
            return null;
        }
        
    }
    
    
    
   
}
