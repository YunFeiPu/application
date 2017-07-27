<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Code
 * The cpnfig stored in database
 * 
 * @author asus
 */
class Config_m extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function insert($arr) {
		$this->db->insert ( 'cofig', $arr );
	}
	function update($id, $arr) {
		$this->db->where ( 'id', $id );
		$this->db->update ( 'config', $arr );
	}
	function delete($item_name) {
		$this->db->where ( 'item_name', $item_name );
		$this->db->delete ( 'cofig' );
	}
	function get_item($item_name) {
		$this->db->where ( 'item_name', $item_name );
		$this->db->select ( 'item_value' );
		$query = $this->db->get ( 'config' );
		if ($query->num_rows () > 0) {
			$query1 = $query->result ();
			return $query1 [0]->item_value;
		} else {
			return "";
		}
	}
	function set_item($item_name, $item_value) {
		$this->db->where ( 'item_name', $item_name );
		$this->db->select ( '*' );
		$query = $this->db->get ( 'config' );
		if ($query->num_rows () > 0) {
			$query1 = $query->result ();
			$id = $query1 [0]->id;
			$arr = array (
					'item_name' => $item_name,
					'item_value' => $item_value 
			);
			$this->update ( $id, $arr );
			return $id;
		} else {
			return 0;
		}
	}
}
