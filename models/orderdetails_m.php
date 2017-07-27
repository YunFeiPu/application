<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * 订单汇总消息  包括订单的状态，订单编号，订单备注
 * @author asus
 */
class orderdetails_m extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
        $this->db->insert('orderdetails_m',$arr);        
    }
    
    
    function update($id,$arr){
        $this->db->where('id',$id);
        $this->db->update('orderdetails_m',$arr);
    }
    
    function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('orderdetails_m');
    }
    
    function get($id){
        $this->db->where('id',$id);
        $this->db->select('*');
        $query = $this->db->get('orderdetails_m');
        $query1 = $query->result();
        return $query1[0];
    }
     function getall(){
        $this->db->select('*');
        $this->db->order_by('id','asc');
        $query = $this->db->get('orderdetails_m');
        return $query->result();
    }
        
  
    
    
    function AssembleData(){
            $orderdetails_m = $_POST['v_orderdetails_m'];
             $arr = array(
                'orderdetails_m'=>$orderdetails_m);    
             return $arr;            
        }
}
