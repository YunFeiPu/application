<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gonghuodan extends CI_Controller {
	
	
	function testupload(){
		parent::islogin();
		$this->load->view('gonghuodan/testupload');
	}

	function dele(){
		$id = $this->uri->segment(3,0);
		$sql = "delete from gonghuodan where ghd_id = ?";
		$this->db->query($sql, array($id));
	}
	
	/***
	 * 供货单
	 */
	function index(){
		parent::islogin();
		$order_date = "";
		if(isset( $_POST['v_sdate']) ){
			$order_date = $_POST['v_sdate'];
		}
		else {
			$this->load->model('config_m');
			if($order_date==""){
				$order_date = $this->config_m->get_item('order_date');
			}
		}

		$data['order_date'] = $order_date;
		
		$this->load->model('gonghuodan_m');
		$data['ghd_list'] = $this->gonghuodan_m->getghdlistbydate($order_date);
		
		$this->load->view('gonghuodan/index',$data);
		
	}
	
	function getghdlistbygys(){
		parent::islogin();
		$gys_id = $this->uri->segment(3,0);
		$this->load->model('gonghuodan_m');
		$query = $this->gonghuodan_m->getghdlistbygysid($gys_id);
		if(isset($query)){
			$data["ghd_list"] = $query;
		}
		
		/** 直接用数据库掉用数据测试 */
		$this->load->model("gongyingshang_m");
		$gys = $this->gongyingshang_m->getbygys_id($gys_id);
		if(!isset($gys)){
			return "找不到供应商";
		}
		
		$sql = "SELECT DATE_FORMAT(`otime`,'%Y-%m-%d') as `otime`,sum(qty*`inprice`) as `total`  from(

SELECT a1.* from(
SELECT `order`.*,`product`.`categoryid`,`product`.`pprice` as `inprice`  from `order` LEFT JOIN `product` on `order`.`pid`  = `product`.`id` 
    where otime BETWEEN '2017-06-01' and '2017-06-31'
    )as a1 

LEFT JOIN `productcategory` on   a1.categoryid = `productcategory`.`id` where `productcategory`.`description` = ? )
as b1 GROUP BY DATE_FORMAT(`otime`,'%Y-%m-%d')";
		$query = $this->db->query($sql,array($gys->gys_name));
		if($query->num_rows>0){
			$data["data_list"] = $query->result();
		}
		
		$this->load->view('gonghuodan/ghdgyslist',$data);
	}
	
	/***
	 * controller p2
	 */
	function add(){
		parent::islogin();
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$gys_name = $_POST['v_gys_name'];
			$order_date = $_POST['v_order_date'];
			redirect('/gonghuodan/add/'.urlencode($order_date).'/'.urlencode($gys_name));
		}
		
		
		$data = array();
		$gys_list ;
		
		//需要两个参数 $order_date, $gys_name;
		$order_date = urldecode($this->uri->segment(3,date("Y-m-d")));
		$gys_name = urldecode($this->uri->segment(4,''));
		$data['order_date'] = $order_date;
		
		if($gys_name == ''){
			//需要选择供应商
			$this->load->model('productcategory_m','productcategory');
			$data['gys_list'] = $this->productcategory->getbypid(0);
			

		}
		else{
			$data['gys_name'] = $gys_name;
			//为转单不需要选择供应商
			$this->load->model('gonghuodan_m');
			$ghd_id = $this->gonghuodan_m->isghdexsited($order_date,$gys_name);
			if($ghd_id === 0){
				//表示没有供货单
				$this->load->model('order_m');
				$result =$this->order_m->isdingdanexsited($order_date,$gys_name);
				if($result){
					$data['dingdan'] = $this->order_m->getdingdan($order_date,$gys_name);
				}
				
			}else{
				//有供货单
				$data['gonghuodan'] = $this->gonghuodan_m->getghdbyid($ghd_id);
			}
			
			
		}
		
		$this->load->view('gonghuodan/add',$data);
		
		
	}
	
	/***
	 * controller p2
	 */
	function saveorupdate(){
		parent::islogin();
		$ghd = $_POST['ghd'];
		echo $ghd["ghd_mx"][1]["pname"];
	}
	
	/*function test(){
		parent::islogin();
		$a = '`ghd_mx_id`,`ghd_id`,`p_id`,`p_qty`,`ghd_inprice`,`ghd_mx_heji`,`ghd_mx_state`,`ghd_mx_beizhu`';
		echo $a .'<br/>';
		$b = str_replace('`','',$a);
		$arr = explode(",",$b);
		
		$bianliang_key = '$'.$arr[0];
		$key = $arr[0];
		$canshunokey = ''; //没有主键的 方法参数 $a,$b
		$i = 0;
		foreach ($arr as $item){
			if($i ==1){
				$canshunokey .= '$'.$item;
			}
			if($i >1)
			{
				$canshunokey .= ', $'.$item;
			}
		
			$i++;
		}
		echo $canshunokey;
		$canshu = '$'.$arr[0].','.$canshunokey;
		echo $canshu;
		
		$arr_zuhe_nokey = "";
		$arr_zuhe_nokey .= '$arr = array (';
		$i = 0;
		foreach ($arr as $item){
			if($i ==1){
				$arr_zuhe_nokey .= "'".$item."'". "=>"."$". $item;
			}
			if($i >1)
			{
				$arr_zuhe_nokey .=",
							'".$item."'". "=>"."$". $item;
			}
				
			$i++;
		}
		$arr_zuhe_nokey.= ')';
		echo $arr_zuhe_nokey;
		
// insert
		$str = 'private function insert(';
		foreach($arr as $item){
			$item = trim($item);
		}
		
		$i = 0;
		foreach ($arr as $item){
			if($i ==1){
				$str .= "$$item";
			}
			if($i >1)
			{
				$str .= ', $'.$item;
			}
		
			$i++;
		}
	
		$str .= ') {
			$arr = array (';
			$i = 0;
			foreach ($arr as $item){
				if($i ==1){
					$str .= "'".$item."'". "=>"."$". $item;
				}
				if($i >1)
				{
					$str .=", 
							'".$item."'". "=>"."$". $item;
				}
			
				$i++;
			}
		$str.= ');
			$this->db->insert ( $this->dbt_name, $arr );
			return $this->db->insert_id ();}';
		
		// insert off
		
		// update 
		
		$str .= "<br>update<br>";
		
		$str .= '	private function update('.$canshunokey.', $where_id) {
		$this->db->where ( '.$key.', $where_id );'.$arr_zuhe_nokey.';
		$this->db->update ( $this->dbt_name, $arr );
	}' ;
		
echo $str;
		
	}
	*/
	

	/***
	 * 创建某一天的供货单
	 */
	function creategonghuodan(){
		parent::islogin();
		if(!isset( $_POST['v_sdate']) ){
			return;
		}
		$date = $_POST['v_sdate'];
		$sql = "select * from gonghuodan where gonghuodan.ghd_date = ? ";
		
		$query = $this->db->query($sql,array($date));
		if($query->num_rows()>0){
			echo "已经有了";
			return;
		}

			$this->load->model('gonghuodan_m');
			$this->gonghuodan_m->createghd($date);

			$query = $this->gonghuodan_m->createghdmx($date);
			if($query->num_rows()>0){
				$list = $query->result();
			};
			
		foreach ($list as $arr)
			{
				
				$sql = "INSERT INTO `gonghuodan_mingxi`
(
`ghd_id`,
`p_id`,
`p_qty`,
`ghd_inprice`,
`ghd_mx_heji`,
`ghd_mx_state`,
`ghd_mx_beizhu`)
VALUES
(?,?,?,?,?,1,'')";
						$this->db->query($sql, array($arr->ghd_id,$arr->pid,$arr->qty,$arr->pprice,$arr->heji));
			}
			redirect('gonghuodan/index');
	}
	
	function createghd(){
		$order_date = "";
		if(isset( $_POST['v_sdate']) ){
			$order_date = $_POST['v_sdate'];
		}
		else {
			$this->load->model('config_m');
			if($order_date==""){
				$order_date = $this->config_m->get_item('order_date');
			}
		}
		
		$data['order_date'] = $order_date;
		$sql = "select sum(ghd_jine) as heji ,ghd_date,count(*) as jishu from gonghuodan group by ghd_date order by ghd_date desc limit 0,30;";
		$query= $this->db->query($sql,array($order_date));
		$data['item_list'] = $query->result();

		$this->load->view('gonghuodan/create',$data);
	}
	
	/***
	 * 查询明细
	 */
	function mx(){
		parent::islogin();
		$ghd_id = $this->uri->segment(3,0);
		$this->load->model('gonghuodan_mingxi_m','mx');
		$query = $this->mx->getghdmxlistbyghdid($ghd_id);
		if(isset($query)){
			$data['item_list'] = $query;
			foreach ($query as $item){
				$data['gys_name'] = $item->gys_name;
				$data['ghd_date'] = $item->ghd_date;
				$data['id_gys'] = $item->id_gys;
				break;
			}
			
			$this->load->model("gongyingshang_m");
			$data["product_list"] = $this->gongyingshang_m->getnamelistbygysid($data['id_gys']);
		}
		
		$this->load->view("gonghuodan/mx",$data);
	}
	
	/***
	 * 锁单后 会保存当前系统中的供货单数据！无法修改
	 */
	function suodan(){
		parent::islogin();
		$order_date = "";
		if(isset( $_POST['v_sdate']) ){
			$order_date = $_POST['v_sdate'];
		}
		else {
			$this->load->model('config_m');
			if($order_date==""){
				$order_date = $this->config_m->get_item('order_date');
			}
		}
		
		$data['order_date'] = $order_date;
		
		$sql = "select sum(ghd_jine) as heji ,ghd_date,count(*) as jishu from gonghuodan_bak group by ghd_date order by ghd_date desc limit 0,7;";
		$query= $this->db->query($sql,array($order_date));
		$data['item_list'] = $query->result();
		
		
		
		$this->load->view('gonghuodan/suodan',$data);
	}
	
	
	function updatemx(){
		parent::islogin();
		//return "aaa";
		$modi_mx = json_decode($_POST['item']);

		/*
		$modi_mx = (object) array(
				'ghd_mx_id' => '1212',
				'p_qty' => '54',
				'ghd_inprice' => '22.00',
				'ghd_date' => '2017-07-14',
				'p_id' => '3122',
				'id_gys' => '164'
		);*/
		
		$this->load->model('gonghuodan_mingxi_m');
		$c_mx = $this->gonghuodan_mingxi_m->getghdmxbymxid($modi_mx->ghd_mx_id);
		$sql = "select gonghuodan_mingxi_bak.* 
from gonghuodan_mingxi_bak 
left join gonghuodan_bak 
on gonghuodan_mingxi_bak.ghd_id = gonghuodan_bak.ghd_id  
where gonghuodan_bak.ghd_date = ? 
and gonghuodan_bak.id_gys = ? 
and gonghuodan_mingxi_bak.p_id = ? ";
		$query = $this->db->query($sql, array($modi_mx->ghd_date,$modi_mx->id_gys,$modi_mx->p_id));
		if($query->num_rows()>0){
			$org_mx = $query->row();
		}

		//三个数据进行比较，org_mx 为锁单数据，最为原始，modi_mx：要保存的数据，c_mx：当前供货单的数据
		if(isset($org_mx)){
			if($modi_mx -> ghd_inprice != $org_mx -> ghd_inprice){
				//即将修改的数据小于锁单数值，表示 缺货

				$c_mx -> ghd_mx_beizhu = str_replace("价格变更,","价格变更,",$c_mx -> ghd_mx_beizhu,$a);
				if($a == 0){
					$c_mx -> ghd_mx_beizhu .= "价格变更,";
				}
			
			}
			elseif ($modi_mx -> ghd_inprice == $org_mx -> ghd_inprice){
				$c_mx -> ghd_mx_beizhu =str_replace("价格变更,","",$c_mx -> ghd_mx_beizhu,$a);
			}
		}
		
		
			if($modi_mx -> p_qty < $org_mx -> p_qty){
				//即将修改的数据小于锁单数值，表示 缺货
				
				$c_mx -> ghd_mx_beizhu =str_replace("缺货,","缺货,",$c_mx -> ghd_mx_beizhu,$a);
				$c_mx -> ghd_mx_beizhu =str_replace("库存,","缺货,",$c_mx -> ghd_mx_beizhu,$b);
				if($a+$b == 0){
					$c_mx -> ghd_mx_beizhu .= "缺货,";
				}
				
			}elseif($modi_mx -> p_qty == $org_mx -> p_qty){
				
				$c_mx -> ghd_mx_beizhu =str_replace("缺货,","",$c_mx -> ghd_mx_beizhu,$a);
				$c_mx -> ghd_mx_beizhu =str_replace("库存,","",$c_mx -> ghd_mx_beizhu,$b);
			}elseif($modi_mx -> p_qty > $org_mx -> p_qty){
				//有库存
				$c_mx -> p_qty = $modi_mx -> p_qty;
				$c_mx -> ghd_mx_beizhu =str_replace("缺货,","库存,",$c_mx -> ghd_mx_beizhu,$a);
				$c_mx -> ghd_mx_beizhu =str_replace("库存,","库存,",$c_mx -> ghd_mx_beizhu,$b);
				if($a+$b == 0){
					$c_mx -> ghd_mx_beizhu .= "库存,";
				}
			}

			$c_mx -> ghd_inprice = $modi_mx -> ghd_inprice;
			$c_mx -> p_qty = $modi_mx -> p_qty;
			$c_mx ->ghd_mx_heji =  $modi_mx -> ghd_inprice*$modi_mx -> p_qty;
			
			$this->gonghuodan_mingxi_m->save_mx($c_mx);
			
		
	}
	

	function suodan_create(){
		parent::islogin();
		if(!isset( $_POST['v_sdate']) ){
			return;
		}
		$date = $_POST['v_sdate'];
		$sql = "select * from gonghuodan_bak where gonghuodan_bak.ghd_date = ? ";
		
		$query = $this->db->query($sql,array($date));
		if($query->num_rows()>0){
			echo "已经有了";
			return;
		}
	
		
		
		
		$sql = "Insert into gonghuodan_bak(id_gys, ghd_date, ghd_jine,ghd_jiesuan_jine,ghd_state,ghd_pic,ghd_beizhu) 		select gys_id,?,0,0,1,'','' from  (select description from (
        SELECT product.categoryid  FROM `order` left join `product` on
         `order`.`pid` =  `product`.`id`
							where `order`.`otime` =?)
                            as a1  left join productcategory on a1.categoryid = productcategory.id  group by description) as a2 left join gongyingshang on
                            a2.description = gongyingshang.gys_name";
		$query = $this->db->query($sql,array($date,$date));
		$sql = "
		select  gonghuodan_bak.ghd_id ,pid,qty,pprice,qty*pprice as heji
		from (
				select pid,qty, pprice ,description, gongyingshang.gys_id,gongyingshang.gys_name
				from (
						SELECT a2.pid ,qty ,pprice,description
						from (
								select pid ,qty, product.pprice, product.categoryid from (
										SELECT pid,sum(qty)  as qty  FROM `order`
										where otime =?
										group by pid
										) as a1
								left join product on a1.pid = product.id
								) as a2 left join productcategory on categoryid = productcategory.id
						) as a3 left join gongyingshang on a3.description = gongyingshang.gys_name
				) as a4 left join gonghuodan_bak on a4.gys_id = gonghuodan_bak.id_gys where gonghuodan_bak.ghd_date = ?					";
		$query = $this->db->query($sql, array($date,$date));
		if($query->num_rows()>0){
			$list = $query->result();
		};
			
		foreach ($list as $arr)
		{
		
			$sql = "INSERT INTO `gonghuodan_mingxi_bak`
(
`ghd_id`,
`p_id`,
`p_qty`,
`ghd_inprice`,
`ghd_mx_heji`,
`ghd_mx_state`,
`ghd_mx_beizhu`)
VALUES
(?,?,?,?,?,1,'')";
			$this->db->query($sql, array($arr->ghd_id,$arr->pid,$arr->qty,$arr->pprice,$arr->heji));
		}
	}
	
}