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
    
    function getbyname($cname){
        $this->db->select('*');
        $this->db->from('custom');
        $this->db->where('cname',$cname);
        $query = $this->db->get();
        $query =  $query->result();
        return $query[0];
        
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
}
?>