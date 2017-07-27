<?php
class Customgroup_m extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function insert($arr) {
		$this->db->insert ( 'customgroup', $arr );
	}
	function update($id, $arr) {
		$this->db->where ( 'id', $id );
		$this->db->update ( 'customgroup', $arr );
	}
	function delete($id) {
		$this->db->where ( 'id', $id );
		$this->db->delete ( 'customgroup' );
	}
	function get($id) {
		$this->db->where ( 'id', $id );
		$this->db->select ( '*' );
		$query = $this->db->get ( 'customgroup' );
		$query1 = $query->result ();
		return $query1 [0];
	}
	function getall() {
		$this->db->select ( '*' );
		$query = $this->db->get ( 'customgroup' );
		return $query->result ();
	}
	function AssembleData() {
		$groupname = $_POST ['v_groupname'];
		$description = $_POST ['v_description'];
		$arr = array (
				'groupname' => $groupname,
				'description' => $description 
		);
		return $arr;
	}
	
	// other
	function GetGroupSelect() {
		$this->db->select ( 'id,groupname' );
		$array = array ();
		$array ['0'] = "--请选择--";
		$query = $this->db->get ( 'customgroup' );
		
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $rows ) {
				$array [$rows->id] = $rows->groupname;
			}
		}
		
		return $array;
	}
	function get_by_name($gname) {
		$this->db->select ( '*' );
		$this->db->from ( 'customgroup' );
		$this->db->where ( 'groupname', $gname );
		$query = $this->db->get ();
		$query = $query->row ();
		return $query;
	}
	function get_by_cname($cname) {
		$this->db->select ( 'group_id,customgroup.groupname' );
		$this->db->from ( 'custom' );
		$this->db->join ( 'customgroup', 'custom.group_id=customgroup.id', 'left' );
		$this->db->where ( 'custom.cname', $cname );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			$query = $query->row ();
			return $query;
		} else {
			return null;
		}
	}
}
