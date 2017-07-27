<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shiporder extends CI_Controller {

	/**
	 * 采购分单 
	 */
	function index(){
		/*load pre-set date in datebase
		 * */
		 parent::islogin();
		$this->load->model('config_m');
		$data['order_date'] = $this->config_m->get_item('order_date');
		
		
		$_uri = 'shiporder/index';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->config_m->set_item('check_order_item','0');
			$date = urlencode($_REQUEST['v_date']);
			$_uri .= '/' . $date;
			redirect($_uri);
			return;
		}
		$date = $this->uri->segment(3,$data['order_date']);
		$this->load->model('shiporder_m');
		$this->load->library('validate');
		$check_item = $this->config_m->get_item('check_order_item');

		$data['v_date'] = $date ;
		$this->load->model('order_m');
		if($check_item == '0'){
		$arr = $this->order_m->checkitem($date);
		}
		if(!empty($arr)){
			$this->config_m->set_item('check_order_item','0');
			echo "发现一个可能存在的错误:<br />以下订单可能存在重复项目清检查<br/>";
			foreach($arr as $a){
				echo "<a href='".base_url()."order/showinfo/".$a."'>".$a."</a><br/>";
			};
		}
		else{
			$this->config_m->set_item('check_order_item','1');
			$data['item_list'] = $this->shiporder_m->getShipOrderList($date);
			$this->load->view('shiporder/index',$data);
		}
	}
	
	function showshiporder(){
		parent::islogin();
		$_uri = 'shiporder/showshiporder';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$date = urlencode($_REQUEST['v_date']);
			$_uri .= '/' . $date;
			redirect($_uri);
		}
		
		$otime = $date = $this->uri->segment(3,date('Y-m-').(date('d')+1));
		$data['v_date'] = $otime;
		$this->load->model('shiporder_m');
		$data['n0'] = $this->shiporder_m->getproductlistbyshipcateid(0,$otime);
		$data['n1'] =  $this->shiporder_m->getproductlistbyshipcateid(1,$otime);
		$data['n2'] = $this->shiporder_m->getproductlistbyshipcateid(2,$otime);
		//var_dump($data['n1'] );
		$this->load->view('shiporder/showshiporder',$data);
	}
	
	function dele(){
		
	}
	
	function modilist(){
		parent::islogin();
		$arr = $_POST["order_item"];
		$ShipCateId = $_POST["hidden_shipid"];

		
		
		
		if($ShipCateId === "auto"){
			$this->load->model('order_m');
			$this->load->model('custom_m');
			$this->load->model('shiporder_m');
			if(count($arr)>0){
				foreach ($arr as $OrderNum){
					$item_order = $this->order_m->getByOrderNum($OrderNum);
					if(is_null($item_order)){
						continue;
					}
					$item_custom = $this->custom_m->get($item_order->cid);
					if(is_null($item_custom)){
						continue;
					}
					$_num ;
					switch ($item_custom->cname) {
						case "爱米粒":
							case "食字路口":
								case "常州周茉食品超市":
									case "无锡周茉食品超市阳光店":
										case "无锡周茉食品超市阳光新店":
											case "无锡周茉食品超市（门店）":
						$_num = 2;
						break;
						
						default:
							$_num = 1;
						break;
					}
					
					$item = $this->shiporder_m->getShipOrder($OrderNum);
					if(is_null($item)){
						$this->shiporder_m->insert(array(
								'OrderNum' => $OrderNum,
								'ShipCateId' => $_num
						));
					}else{
						//echo $item->IdShipOrder;
						$this->shiporder_m->update($item->IdShipOrder,array(
								'ShipCateId' => $_num
						));
					}
			
				}
			}
			
		}
		else{
			
		
			$this->load->model('shiporder_m');
			if(count($arr)>0){
				foreach ($arr as $OrderNum){
					$item = $this->shiporder_m->getShipOrder($OrderNum);
					if(is_null($item)){
						$this->shiporder_m->insert(array(
							'OrderNum' => $OrderNum,
							'ShipCateId' => $ShipCateId
						));
					}else{
						//echo $item->IdShipOrder;
						$this->shiporder_m->update($item->IdShipOrder,array(
								'ShipCateId' => $ShipCateId
							));
					}
		
				}
			}
		}
		redirect('shiporder/index');
	}
	
	function modi(){
		parent::islogin();
		$OrderNum = $this->uri->segment(3,0);
		$ShipCateId = $this->uri->segment(4,0);
		$this->load->model('shiporder_m');
		$item = $this->shiporder_m->getShipOrder($OrderNum);
		if(is_null($item)){
			$this->shiporder_m->insert(array(
				'OrderNum' => $OrderNum,
				'ShipCateId' => $ShipCateId
			));
		}else{
			//echo $item->IdShipOrder;
			$this->shiporder_m->update($item->IdShipOrder,array(
					'ShipCateId' => $ShipCateId
			));
		}
		$uri = str_replace('_', '/', $this->uri->segment(5,"shiporder/index"));
		//var_dump($_SERVER['REQUEST_URI']);
		redirect($uri);
	}
	
	function save(){
		
		
	}
}