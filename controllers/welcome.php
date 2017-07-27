<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
			if ( ! $this->session->userdata("username") ){
				redirect ( '/welcome/login' );
			}
			else{
				$data['username'] =$this->session->userdata('username');
				$this->load->view('default',$data);
			}
	}
	
	function check(){
		$this->load->model('ci_admin_m');
		if(!isset($_POST['account'])){
			redirect ( '/welcome/login' );
		}
		$username = $_POST['account'];
		$password = $_POST['password'];
		$admin = $this->ci_admin_m->getadmin($username);
		if(isset($admin)){
			if(sha1($password) == $admin->password){
				$newdata = array(
						'username'  => $admin->username,
						'logged_in' => TRUE
				);
				$this->session->set_userdata($newdata);
			}
			
		}
		$this->load->library("validate");
		$a = $this->validate->isMobile();
		if($a){redirect('mobile/index');}
		else{
		redirect(base_url());
		}	
		}
	
	function login(){
		$this->load->library('validate');
		$temp = $this->validate->isMobile();
		if($temp){
			$this->load->view("mobile/login");
		}
		else{
			$this->load->view('login');
		}
	}
	
	function logout(){
		$arr = array(
				'username' => '',
				'level' =>''
		);
		$this->session->unset_userdata($arr);
		redirect('/welcome/login','refresh');
	}
	
	function  hello(){
		parent::islogin();
		$this->load->view('welcome');
	}
	
	function qrcode() {
		parent::islogin();
		$this->load->library("Qrcode"); //二维码生成
		@ $uri =urldecode($_GET["t"]); 
		echo $this->qrcode->png( $uri); //显
		
	}
	
	function aprint(){
		parent::islogin();
		$this->load->view("print");
	}
	
	function pieview(){
		parent::islogin();
		$this->load->view('chart');
	}
	
	function barview(){
		parent::islogin();
		$this->load->model('chart_m');
		$val = $this->chart_m->getvalbymonth();
		$arr_year = array();
		$arr_month = array();
		$arr_val= array();
		foreach($val as $month){
			if(!in_array($month->y,$arr_year)){
				array_push($arr_year,$month->y);
				$arr_val[$month->y] = array("0","0","0","0","0","0","0","0","0","0","0","0",);
			}
			$arr_index =  ((int)$month->m)-1;
			$arr_val[$month->y][$arr_index] = $month->val;
		}
		
		$arr_val_string = array();
		for($i = 0 ;$i<count($arr_year);$i++){
			$arr_val_string[$arr_year[$i]] = implode(',', $arr_val[$arr_year[$i]]);
		}
		//var_dump($arr_val_string);
		
		$data['category'] = $arr_year;
		$data['item'] = $arr_val_string;
		$this->load->view('barbasic',$data);
	}
	
	function lirunyue(){
		parent::islogin();
		$this->load->model('chart_m');
		$val = $this->chart_m->getlirunbymonth();
		$arr_year = array();
		$arr_month = array();
		$arr_val= array();
		foreach($val as $month){
			if(!in_array($month->y,$arr_year)){
				array_push($arr_year,$month->y);
				$arr_val[$month->y] = array("0","0","0","0","0","0","0","0","0","0","0","0",);
			}
			$arr_index =  ((int)$month->m)-1;
			$arr_val[$month->y][$arr_index] = $month->val;
		}
		
		$arr_val_string = array();
		for($i = 0 ;$i<count($arr_year);$i++){
			$arr_val_string[$arr_year[$i]] = implode(',', $arr_val[$arr_year[$i]]);
		}
		//var_dump($arr_val_string);
		
		$data['category'] = $arr_year;
		$data['item'] = $arr_val_string;
		$this->load->view('lirunyue',$data);
	}
	
	/**
	*当月所有产品销量
	*/
	function xiaoliangquxian(){
		parent::islogin();
		$aaaa = new Nodiscount(20, 20);
		echo $aaaa->count_pprice()."<br/>";
		$bbbb = new Rebatediscount(20, 20, 0.87);
		echo $bbbb->count_pprice()."<br/>";
		echo $bbbb->count_total()."<br/>";
		
		$cccc = new Reduceqtydiscount(8, 30, array("base"=>30,"reduce"=>10));
		echo $cccc->count_total();
		$this->load->model('chart_m');
		$data['item_list'] = $this->chart_m->getproductqtybymonth();
		$this->load->view('xiaoliangquxian',$data);
	}
	//单个产品销量
	function checkquxian(){
		parent::islogin();
		$pid = $this->uri->segment(3,0);
		$this->load->model('chart_m');
		$item_list = $this->chart_m->getproductqtybymonth($pid,12);
		$index = 1;
		$str_cate = "";
		$str_qtycount= "";
		$pname = "";
		foreach($item_list as $item){
			if($index >1){
				$str_cate = $str_cate ."," . "'".$item->t."'";
				$str_qtycount  = $str_qtycount.",".$item->total_count;
			}
			else{
				$str_cate =  "'".$item->t."'";
				$str_qtycount  = $item->total_count;
				$pname = $item->pname;
				}
				$index ++;
		}
		$data["pname"] = $pname;
		$data['str_cate'] = $str_cate;
		$data['str_qtycount'] = $str_qtycount;
		$this->load->view('product_lirun',$data);
	}
	
	function test1(){
		parent::islogin();
	/*	if(isset($_POST['producttest'])){
		$this->load->model('product_m');
		$product = $this->product_m->getbypname($_POST['producttest']);
		echo '产品条码:'.$product->pname."<br/>";
		echo '产品价格:'.$product->pprice."<br/>";
		}*/
		
		$sql = " call lirunpernian()"	;
		$query = $this->db->query($sql);
		var_dump($query->result()) ;
		
		$this->load->view("test_product");
	}
	
	
	function lirunzuhe(){
		parent::islogin();
		$this->load->model('chart_m');
		$val = $this->chart_m->lirunzuhe('2015');
		$arr_cate = array();//分类 
		$arr_month = array();
		$arr_val= array();
		foreach($val as $month){
			if(!in_array($month->cate,$arr_cate)){
				array_push($arr_cate,$month->cate);
				$arr_val[$month->cate] = array("0","0","0","0","0","0","0","0","0","0","0","0",);
			}
			$arr_index =  ((int)$month->m)-1;
			$arr_val[$month->cate][$arr_index] = $month->val;
		}
		
		$arr_val_string = array();
		for($i = 0 ;$i<count($arr_cate);$i++){
			$arr_val_string[$arr_cate[$i]] = implode(',', $arr_val[$arr_cate[$i]]);
		}

		$data['category'] = $arr_cate;
		$data['item'] = $arr_val_string;
		/**
		 * 
		 */
		
		$val1 = $this->chart_m->lirunzuhe('2016');
		$arr_cate1 = array();//分类
		$arr_month1 = array();
		$arr_val1= array();
		foreach($val1 as $month){
			if(!in_array($month->cate,$arr_cate1)){
				array_push($arr_cate1,$month->cate);
				$arr_val[$month->cate] = array("0","0","0","0","0","0","0","0","0","0","0","0",);
			}
			$arr_index =  ((int)$month->m)-1;
			$arr_val1[$month->cate][$arr_index] = $month->val;
		}
		
		$arr_val_string1 = array();
		for($i = 0 ;$i<count($arr_cate1);$i++){
			$arr_val_string1[$arr_cate1[$i]] = implode(',', $arr_val1[$arr_cate1[$i]]);
		}
		
		$data['category1'] = $arr_cate1;
		$data['item1'] = $arr_val_string1;
		
		
		$this->load->view('lirunzu',$data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */