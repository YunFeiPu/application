<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 *
 * @author YunFei
 *        
 */
class Groupproductprice_m extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function insert($arr) {
		$this->db->insert ( 'groupproductprice', $arr );
	}
	function update($id, $arr) {
		$this->db->where ( 'id', $id );
		$this->db->update ( 'groupproductprice', $arr );
	}
	function delete($id) {
		$this->db->where ( 'id', $id );
		$this->db->delete ( 'groupproductprice' );
	}
	function get($id) {
		$this->db->where ( 'id', $id );
		$this->db->select ( '*' );
		$query = $this->db->get ( 'groupproductprice' );
		$query1 = $query->result ();
		return $query1 [0];
	}
	function getall() {
		$query = $this->db->query ( "select a.id, groupname, pname, price from (select groupname,price,productid,p.id from customgroup as c left join groupproductprice p on c.id =p.groupid) as a left join product p on a.productid = p.id where price is not null " );
		return $query->result ();
	}
	function getallprice() {
		$this->db->select ( 'product.*,productcategory.description' );
		$this->db->from ( 'product' );
		$this->db->join ( 'productcategory', 'product.categoryid = productcategory.id', 'left' );
		$this->db->where ( 'productcategory.description', $description );
		$query = $this->db->get ();
		return $query->result ();
	}
	function AssembleData() {
		$groupid = $_POST ['v_groupid'];
		$productid = $_POST ['v_productid'];
		$price = $_POST ['v_price'];
		$arr = array (
				'groupid' => $groupid,
				'productid' => $productid,
				'price' => $price 
		);
		return $arr;
	}
	function getprice($groupid, $productid) {
		$this->db->select ( 'price' );
		$this->db->from ( 'groupproductprice' );
		$this->db->where ( 'groupid', $groupid );
		$this->db->where ( 'productid', $productid );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	function getsprice($groupid, $productid) {
		$sql = "select  `groupproductprice` .*,ifnull(`product` .sprice,'') as sprice from groupproductprice left join product on groupproductprice.productid = product.id where groupid =? and productid= ?";
		$query = $this->db->query ( $sql, array (
				$groupid,
				$productid 
		) );
		if ($query->num_rows () > 0) {
			return $query->row ();
		} else {
			return null;
		}
	}
	function gpp_is_exsit($gpp) {
		$this->db->select ( '*' );
		$this->db->from ( 'groupproductprice' );
		$this->db->where ( 'groupid', $gpp ['groupid'] );
		$this->db->where ( 'productid', $gpp ['productid'] );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
	function gpp_update($arr) {
		$sql = "update groupproductprice set price = ? where groupid = ? and productid = ?";
		$this->db->query ( $sql, array (
				$arr ['price'],
				$arr ['groupid'],
				$arr ['productid'] 
		) );
	}
}
