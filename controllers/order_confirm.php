<?php
class Order_confirm extends CI_Controller {
    
    public function index(){
    	parent::islogin();
    	$this->load->model('order_m');
    	$data['item_list'] = $this->order_m->getOrderMain(array('order_state'=> 0));
        $this->load->view('order_confirm/index',$data);
    }
    
    
    /**
     * 订单结算
     * 修改订单实际发货数量，和收款金额，结款状态
     */
    public function modi(){
    	parent::islogin();
        $orderid = $this->uri->segment(3,0);
        $this->load->model('order_m');
        $query = $this->order_m->getlistbyorderid($orderid);
        if(empty($query)){
            redirect('/order_confirm/','refresh');    
        }
        
        $data['order_list'] = $query;
        foreach($query as $item){
        	$data['cname'] = $item->cname;
        	$data['otime'] = $item->otime;
        	$data['order_state'] = $item->order_state;
        	//var_dump($item);
        	break;
        }
        
        
        $this->load->view('order_confirm/modi',$data);
    }
    
    
    public function orderConfirmSave(){

       // $this->load->view('order_confirm/index');
    }
    
    /**
     * 直接保存没有变化的订单 订单状态不确定
     * @return NULL
     */
    public function orderConfirmSaveNoChange(){
    	parent::islogin();
        $_POST['arr_orderid'] = array('201406272349321220');
        $_POST['order_state'] = '已结清';
        $arr = array();
        if(!isset($_POST['arr_orderid']) && is_array($_POST['arr_orderid'])){
            return null;
        }
        $this->load->model('order_m');
        $this->load->model('order_main_m');
        $this->load->model('order_confirm_m');
        foreach($_POST['arr_orderid'] as $orderid){
            $query = $this->order_m->getOrderListByOrderId($orderid);
            $flag = TRUE;
            $_arr_order_list = array();
            $_arr = array();
			foreach($query as $item){
				if($flag){
					$_arr['order_num'] = $item->oid;
					$_arr['cid'] = $item->cid;
					$_arr['otime'] = $item->otime;
					$_arr['order_total_new'] = 0;
					$_arr['order_total_old'] = 0;
					$_arr['order_state'] = $_POST['order_state'];
					
					$flag = false;
				}				
				$_arr['order_total_old'] = $_arr['order_total_old'] + $item->ptotal;
				$_arr_order = array();
				$_arr_order['order_num'] = $item->oid;
				$_arr_order['pid'] = $item->pid;
				$_arr_order['qty_old'] = $item->qty;
				$_arr_order['qty_new'] = $item->qty;
				$_arr_order['pprice_old'] = $item->pprice;
				$_arr_order['pprice_new'] = $item->pprice;
				$_arr_order['ptotal_old'] = $item->ptotal;
				$_arr_order['ptotal_new'] = $item->ptotal;
				$_arr_order['bak'] = '';
				$this->order_confirm_m->insert($_arr_order);
			}
			$_arr['order_total_new'] = $_arr['order_total_old'] ;
			$id = $this->order_main_m->insert($_arr);
		}
        
    }
    
    
    
    
    
    
}