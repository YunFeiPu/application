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
    
	private $tblName = 'ShipCategory';
	private $keyName = 'IdShipCategory';
	
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($arr){
    	$this->db->insert($tblName,$arr);
    }
    
    function update($id,$arr){
    	$this->db->where($keyName,$id);
    	$this->db->update($tblName,$arr);
    }
    
    function delete($id){
    	$this->db->where($keyName, $id);
    	$this->db->delete($tblName);
    }
    
    function AssembleData(){
    	$shipCateName = $_POST['v_ShipCateName'];

    	$arr = array(
    			'ShipCateName' => $shipCateName
    	);
    	return $arr;
    }
    
}