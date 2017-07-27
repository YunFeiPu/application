<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {
	function index(){
		parent::islogin();

		redirect('mobile/addorder');
	}
	
	function checkorder(){
		parent::islogin();
		$product_name = urldecode($this->uri->segment(3, ""));
		$order_date = urldecode($this->uri->segment(4,""));
		$this->load->model('config_m');
		$data['order_date'] = $this->config_m->get_item('order_date');
		
		$this->load->model('product_m');
		$data['product_list'] = $this->product_m->getallnamelist();
		
		
		if($product_name<>"" && $order_date<>""){
			$this->load->model('order_m');
			$data["item_list"] = $this->order_m->getorderbysearch($product_name,$order_date);
			$data['list_date'] = $order_date;
			$data['list_pname'] = $product_name;
		
		}
		
		$this->load->view('mobile/checkorder',$data);
	}
	
	function addorder(){
		parent::islogin();
        	$this->load->model('config_m');
        	$this->load->model('custom_m');
        	$this->load->model('productcategory_m','category_m');
        	$this->load->model('product_m');
        	$data['product_list'] = $this->product_m->getallnamelist();
        	$data['order_date'] = $this->config_m->get_item('order_date');
        	$data['category_list'] = $this->category_m->getbypid(0);
        	$data['custom_list'] = $this->custom_m->getall();	
		$this->load->view('mobile/addorder',$data);
	}
	
	function  checkjinhuodan(){
		parent::isLogin();
		//传参
		$gongyingshang_name = urldecode($this->uri->segment(4, ""));
		$order_date = urldecode($this->uri->segment(3,""));
		
		$this->load->model('config_m');
		$this->load->model('order_m');
		if($order_date==""){
			$order_date = $this->config_m->get_item('order_date');
		}
		$gys_list = $this->order_m->getgys_namelistbydate($order_date);
		if(isset($gys_list)){
			$data['gys_list'] = $gys_list;
		}
		if($gongyingshang_name<>""){
			$data['gys_name'] = $gongyingshang_name;
			$data['item_list'] = $this->order_m->getproductbuylistbygys_name($gongyingshang_name,$order_date);
			//var_dump($data[''])
		}
		$data['order_date'] = $order_date;
		
		$this->load->view('mobile/checkjinhuodan',$data);
		
	}
	
}