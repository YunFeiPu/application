<?php
class Order_main_m extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
        $this->db->insert('order_main',$arr);
        return $this->db->insert_id();
    }
    
    function update($id,$arr){
        $this->db->where('id',$id);
        $this->db->update('order_main',$arr);
    }
    
    /**
     * 哈哈
     * @param unknown $id
     */
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('order_main'); 
    }
    
    
}

