<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ci_admin extends CI_Controller {
	function index(){
		$this->load->model("ci_admin_m","ci_admin");
		$pageindex = $this->uri->segment(3,1);
		$result = $this->ci_admin->getadminlist($pageindex,20);
		$data["item_list"] = $result["datalist"];
		$data["recordcount"] = $result["recordcount"];
		$this->load->view('ci_admin/admin_list',$data);
	}
	
	
	
	
	function add_admin(){
		$this->load->model("ci_admin_m","ci_admin");
	}
	
	function insert_admin(){

		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			return;
		}
		$this->load->model("ci_admin_m","ci_admin");
		$data = array('name' => $name, 'email' => $email, 'url' => $url);

		$str = $this->db->insert_string('table_name', $data);
	}
	
	
	function update_admin(){
		
	}
	
	
}