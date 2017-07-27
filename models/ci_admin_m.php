<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 管理员类
 *
 * @author asus
 */
class Ci_admin_m extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function insert($arr) {
		$this->db->insert ( 'ci_admin', $arr );
	}
	function update($username, $arr) {
		$this->db->where ( 'username', $username );
		$this->db->update ( 'ci_admin', $arr );
	}
	function delete($username) {
		$this->db->where ( 'username', $username );
		$this->db->delete ( 'ci_admin' );
	}
	function isexsit($username) {
		$this->db->where ( 'username', $username );
		$this->db->from ( 'ci_admin' );
	}
	function getadmin($username) {
		$this->db->where ( 'username', $username );
		$query = $this->db->get ( 'ci_admin' );
		return $query->row ();
	}
	
	/**
	 * *
	 * 
	 * @todo 更改密码
	 * @param unknown $username        	
	 * @param unknown $oldpass        	
	 * @param unknown $newpass        	
	 */
	function updatepassword($username, $oldpass, $newpass) {
		$admin = $this->getadmin ( $username );
		if (empty ( $admin )) {
			return false;
		}
		$arr = array (
				'password' => sha1 ( $newpass ),
				'level' => $admin->level 
		);
		if ($admin->password == sha1 ( $oldpass )) {
			$this->update ( $admin->username, $arr );
			return true;
		} else {
			return false;
		}
	}
	function getadminlist($pageindex, $pagesize) {
		$sql = "select count(*) as `recordcount` from `ci_admin`";
		$query = $this->db->query ( $sql );
		$arr = array ();
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
			
			$arr ["recordcount"] = $row ["recordcount"];
		} else {
			$arr ["recordcount"] = 0;
		}
		$sql = "select username,level from `ci_admin`";
		$startrow = ($pageindex - 1) * $pagesize;
		
		$query = $this->db->query ( "CALL `_PageQuery`('$sql' , $startrow, $pagesize)" );
		if ($query->num_rows () > 0) {
			$arr ["datalist"] = $query->result ();
		} else {
			$arr ["datalist"] = null;
		}
		return $arr;
	}
	function AssembleData() {
		$username = $_POST ['v_username'];
		$password = $_POST ['v_password'];
		$level = $_POST ['v_level'];
		
		$arr = array (
				'username' => $username,
				'password' => $password,
				'level' => $level 
		)
		;
		return $arr;
	}
}
