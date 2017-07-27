<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {
	
	//
	function index(){
		parent::islogin();
		 $this->load->model('custom_m');
            $data['item_list'] = $this->custom_m->getCustomAndGroupList();
            $this->load->view('custom_show',$data);
	}
	
	function set_order_date(){
		parent::islogin();
		$item_value = $_POST['item_value'];
		$this->load->model('config_m');
		$this->config_m->set_item('order_date',$item_value);
	}
}