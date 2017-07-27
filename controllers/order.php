<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
	
	function ajaxOrderPicUpdate(){
		 $oid =  $_POST["oid"];
		 $content = $_POST["content"];
		 $this->load->model('order_pic_m');
		 $this->order_pic_m->insert_or_update($oid,$content);
	}
	
	function update_order_state(){
		parent::islogin();
		$isFirstTag = true;
		$orderid = $this->uri->segment(3,0);
		$order_state = $this->uri->segment(4,0);
		$this->load->model('order_m');
		$this->order_m->updateOrderState($orderid , $order_state);
		@ $startdate = $_GET['s'];
		@ $enddate = $_GET['e'];
		@ $orderstate = $_GET['o'];
		@ $sort = $_GET['sort'];
		$uri_str = "order/index/";
		if(isset($startdate)){
			if($isFirstTag){
				$uri_str .= "?";
				$isFirstTag = false;
			}
			else{
				$uri_str .= "&";
			}
			$uri_str .= "s=" . $startdate;
		}
		if(isset($enddate)){
			if($isFirstTag){
				$uri_str .= "?";
				$isFirstTag = false;
			}
			else{
				$uri_str .= "&";
			}
			$uri_str .= "e=" . $enddate;
		}
		
		if(isset($orderstate)){
			if($isFirstTag){
				$uri_str .= "?";
				$isFirstTag = false;
			}
			else{
				$uri_str .= "&";
			}
			$uri_str .= "o=" . $orderstate;
		}
		
		if(isset($sort)){
			if($isFistTag){
				$uri_str .= "?";
				$isFirstTag = false;
			}
			else{
				$uri_str .= "&";
			}
			$uri_str .= "sort=" . $sort;
		}
		
		redirect($uri_str);
		
		
		
		
		//var_dump($_SERVER['REQUEST_URI']);
		//redirect($uri);	
	}
	
	public function dele_item(){
		parent::islogin();
		$id_list = implode(',',$_POST["order_item"]);
		$this->load->model('order_m');
		$this->order_m->delete_id_in($id_list);
	}
	
	
	//各种查询
	public function search(){
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
		
		}
		$this->load->view('order/search',$data);
	}
	
	
	
	public function index(){
		parent::islogin();	
		$this->load->library('validate');
		$uri = "order/index"; //要拼接的url
		$uri_str = "";
		$arr_where = array();
		$arr_sort = "";
		
		/*echo $_GET['sort'];
		if(isset($_GET['abc'])){
		var_dump( $_GET['abc']);
		}
		return;*/
		/*
		 * url模式
		 * order/?s=2015-04-13&e=2015-04-15&o=[1]&sort=[otime_desc|otime_asc|cname_desc|cname_asc|total_desc|total_asc]
		 * */
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$startdate = $_REQUEST['v_sdate'];
			$enddate = $_REQUEST['v_edate'];
			$orderstate = $_REQUEST['v_ostate'];
			$sort = 'total_desc';
		}
		else{
			@ $startdate = $_GET['s'];
			@ $enddate = $_GET['e'];
			@ $orderstate = $_GET['o'];
			@ $sort = $_GET['sort'];
		}
		$datetime1;
		$datetime2;
		//时间1必须有效 否则赋默认值
		if($startdate && $this->validate->is_date($startdate)){
			$uri .= "?s=".$startdate;
			$datetime1 = date_create($startdate);
		}
		else{
			$uri .= "?s=".date('Y-m-d');
			$datetime1 = date('Y-m-d');
			$startdate = date('Y-m-d');
			
		}
		$uri_str .= "?s=".$startdate;
		//时间2必须有效 而且要大于时间1；
		if($this->validate->is_date($enddate)){
			$datetime2 = date_create($enddate);
			@ $interval = date_diff($datetime1, $datetime2);
			if($interval){
				if($interval->days>0){
					$uri .= "&e=".$enddate;
					$uri_str .= "&e=".$enddate;
				}
			}
		}
		if(!isset($orderstate))
		{
			$orderstate = "not3";
			
		}
		$data['v_ostate'] = $orderstate;
		$uri .= "&o=" . $orderstate;
		$uri_str .= "&o=" . $orderstate;
		if(!$sort){
			$sort = "total_desc";
		}
		
		
		
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			redirect ($uri);
		}
		else{
			$data['v_sdate'] = $startdate;
			$arr_where['s_otime'] = $startdate;
			if($enddate){
				$data['v_edate'] = $enddate;
				$arr_where['e_otime'] = $enddate;
			}
			$data['v_ostate'] = $orderstate;
			$arr_where['order_state'] = $orderstate;
			$arr_sort = $sort;
			
			$data['sort'] = $sort;
			$data['uri_str'] = $uri_str;
			
		}
			
			
			/*if($s_date == ''){
				$s_date = 0;
			}
		
			if($e_date == ''){
				$e_date = 0;
			}
			$uri = 'order/index/'.$s_date.'/'.$e_date.'/otime/0/not3';
		
			redirect($uri);
			*/
			$this->load->model('order_m');
			$data['item_list'] = $this->order_m->getOrderListByArr($arr_where,$arr_sort);
		
			$this->load->view('order/list', $data);
		
		return;
		
		
		
		
		
		
		//old
/*
		$data = array();
		$uri = "";
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$s_date = urlencode($_REQUEST['v_sdate']);
			$e_date = urlencode($_REQUEST['v_edate']);
			if($s_date == ''){
				$s_date = 0;
			}
				
			if($e_date == ''){
				$e_date = 0;
			}
				$uri = 'order/index/'.$s_date.'/'.$e_date.'/otime/0/not3';
				
			redirect($uri);
		}
		
		$uri_count = $this->uri->total_segments();

		if($uri_count == 1 || $uri_count == 2){
			$uri ='order/index/'. date('Y-m-d') .'/0/otime/0/not3';
			redirect($uri);
		}
		if($uri_count == 3){
			$uri='order/index/'. $this->uri->segment(3,0).'/0/otime/0/not3';
			redirect();
		}
		if($uri_count == 4){
			$uri = 'order/index/'. $this->uri->segment(3,0).'/'.$this->uri->segment(4,0).'/otime/0/not3';
			redirect($uri);
		}
		if($uri_count == 5){
			$uri = 'order/index/'. $this->uri->segment(3,0).'/'.$this->uri->segment(4,0).'/'.$this->uri->segment(5,0).'/0/not3';
			redirect($uri);
		}
		
		//setcookie('back_url',$uri);
		$s_date = $this->uri->segment(3,0);
		$e_date = $this->uri->segment(4,0);
		$sortname = $this->uri->segment(5,'otime');
		$sort = $this->uri->segment(6,0);
		$order_state = $this->uri->segment(7,'not3');
		$data['sortname'] = $sortname;
		if($sort == 0){
			$_sort = 1;
		}
		else{
			$_sort = 0;
		}
		$data['sort'] = $_sort;
		$data['uri'] = base_url().'order/index/'.$s_date.'/'.$e_date.'/';

		$arr_where = array();
		$arr_sort = array();
		if($s_date <> 0){
			$data['v_sdate'] = $s_date;
			$arr_where['s_otime'] = $s_date;
		}
		
		if($e_date <> 0 ){
			$data['v_edate'] = $e_date;
			$arr_where['e_otime'] = $e_date;
		}
		if($sortname == 'otime'){
			if($sort == 0 ){
			$arr_sort['otime'] = 'desc';
			}
			else{
				$arr_sort['otime'] = 'asc';
			}
		}
		elseif($sortname == 'cname'){
		if($sort == 0 ){
			$arr_sort['cname'] = 'desc';
			}
			else{
				$arr_sort['cname'] = 'asc';
			}
		}
		elseif ($sortname == 'ptotal'){
			if($sort == 0 ){
				$arr_sort['ptotal'] = 'desc';
			}
			else{
				$arr_sort['ptotal'] = 'asc';
			}
		}

		$arr_where['order_state'] = $order_state;
		
		$this->load->model('order_m');
		
		
		
		$data['item_list'] = $this->order_m->getOrderListByArr($arr_where,$arr_sort);
		$this->load->view('order/list', $data);
	*/	
		
		/*
            if(isset($_POST['v_sdate'])){
                 $this->load->model('order_m');
            $data['item_list'] = $this->order_m->getorderlistbydate($_POST['v_sdate']);
           // print_r($data);
            $this->load->view('order/list',$data);
            }
            else{
            $this->load->model('order_m');
            $data['item_list'] = $this->order_m->getorderlist();
           // print_r($data);
            $this->load->view('order/list',$data);
           }
           */

	}
        
        public function productbuy(){
            if(isset( $_POST['v_sdate']) ){
            $date = $_POST['v_sdate'];  
            $data['date'] = $date;
             $this->load->model('order_m'); 
             $data['product_list'] = $this->order_m->getProductBuyList($date);
              $this->load->view('order/productbuy',$data);
            }
            else{
                 $data['product_list'] ="";
                 $this->load->view('order/productbuy');
            }
            
           
        }
        
        public function productbuysp(){
            if(isset( $_POST['v_sdate']) ){
            $date = $_POST['v_sdate'];  
            $data['date'] = $date;
             $this->load->model('order_m'); 
             $data['item_list'] = $this->order_m->getOrderListByDate($date);
              $this->load->view('order/productbuysp',$data);
            }
            else{
                 $data['item_list'] ="";
                 $this->load->view('order/productbuysp');
            }            
           
        }
        
        
        /***
         * 鍔犺浇淇敼鍟嗗搧椤甸潰
         */
        public function modi(){
        	parent::islogin();

            $this->load->model('custom_m');
            $data['custom_list'] = $this->custom_m->getall();
            $this->load->model('productcategory_m','category_m');
            
            $data['category_list'] = $this->category_m->getbypid(0);
            $this->load->model('order_m');
            $orderid = $this->uri->segment(3,0);
			$this->load->model('order_pic_m');
			$content = $this->order_pic_m->getcontent($orderid);
			$data['content'] = $content;
            $query = $this->order_m->getlistbyorderid($orderid);
            if(empty($query)){
                redirect('/order/','refresh');    
            }
            foreach($query as $item){
                $data['cname'] = $item->cname;
                $data['otime'] = $item->otime;
                $data['cid'] = $item->cid;
                $data['oid'] = $item->oid;
                break;
            }     
            $this->load->model('product_m');
            $data['product_list'] = $this->product_m->getallnamelist();

            $data['orderlist'] = $query;
            $this->load->view('order/modi',$data);
        }
        
        public function delebyoid(){
        	parent::islogin();
            $orderid = $this->uri->segment(3,0);
            $this->load->model('order_m');
            $this->order_m->deleByOid($orderid);
            redirect('order/');
        }
        
        
        public function showinfo(){
        	parent::islogin();
            $this->load->model('order_m');
            $orderid =  $this->uri->segment(3,0);
            $query = $this->order_m->getlistbyorderid($orderid);            
            if(empty($query)){
                redirect('/order/','refresh');    
            }
            foreach($query as $item){
                $data['cname'] = $item->cname;
                $data['otime'] = $item->otime;
                $data['oid'] = $item->oid;
                $data['ctel'] = $item->ctel;
                break;
            }            
            $data['orderlist'] = $query;
            $this->load->view('order/showinfo',$data);
        }
        
        
        /*
         * 添加订单页面*/
         public function add(){
         	parent::islogin();
         	$this->load->model('config_m');
            $this->load->model('custom_m');
            $this->load->model('productcategory_m','category_m');
            $this->load->model('product_m');
          	$data['product_list'] = $this->product_m->getallnamelist();
            $data['order_date'] = $this->config_m->get_item('order_date');       
            $data['category_list'] = $this->category_m->getbypid(0);           
            $data['custom_list'] = $this->custom_m->getall();            
            $this->load->view('order_add',$data); 
        }
        /***
         * 测试  行式添加产品
         */
        public function addtest(){
        	parent::islogin();
        	$this->load->model('config_m');
        	$this->load->model('custom_m');
        	$this->load->model('productcategory_m','category_m');
        	$this->load->model('product_m');
        	$data['product_list'] = $this->product_m->getallnamepylist();
        	$data['order_date'] = $this->config_m->get_item('order_date');
        	$data['category_list'] = $this->category_m->getbypid(0);
        	$data['custom_list'] = $this->custom_m->getall();
        	$this->load->view('order_addintest',$data);
        }
        
        /***
         * 正在编写中的 改版添加订单
        */
        public function test(){
        	parent::islogin();
        	$this->load->model('config_m');
        	$this->load->model('custom_m');
        	$this->load->model('productcategory_m','category_m');
        	$this->load->model('product_m');
        	$data['product_list'] = $this->product_m->getallnamelist();
        	$data['order_date'] = $this->config_m->get_item('order_date');
        	$data['category_list'] = $this->category_m->getbypid(0);
        	$data['custom_list'] = $this->custom_m->getall();
        	$this->load->view('neworder_add',$data);
        }
        
        
        
        public function save(){
            /* 
             * $this->load->model('order_m');
            $cid = $this->input->post('id');
            $cart = $this->cart->contents();
            $oid = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1000, 2000);
            foreach ($cart as $item){
               $data = array(
                    'oid'    =>$oid,
                    'pid'    =>$item['id'],
                    'cid'    =>$cid,
                    'qty'    =>$item['qty'],
                    'pprice' =>$item['price'], 
                    'otime'  =>date("Y-m-d"),
                    'timestamp'=>date("Y-m-d H:i:s")
                );
               echo("<pre>");
               //print_r($data);
               $this->order_m->insert($data);
              
            }
             $this->cart->destroy();
             redirect("order/add");
             * 
             */
        }
        
        
        
        /*ajax  add order list*/
        public function ajax_save(){
        	parent::islogin();
            $this->load->model('order_m');
            $order = $_POST['order'];
            $oid = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1000, 2000);
            $a = json_decode($order);
            $this->load->model('custom_m');
            $this->load->model('product_m');
            $custom = $this->custom_m->getByCname($a->cname);
            if(!isset($custom)){
                return ;
            }
            
            $products = $a->products;
            if(sizeof($products)>0){                
                for ($i = 0 ; $i<sizeof($products); $i++){
                   $product = $this->product_m->getByPName($products[$i]->pname);
                    $data = array(
                    'oid'    =>$oid,
                    'pid'    =>$product->id,
                    'cid'    =>$custom->id,
                    'qty'    =>$products[$i]->qty,
                    'pprice' =>$products[$i]->pprice, 
                    'ptotal' =>$products[$i]->ptotal,
                    'otime'  =>$a->otime,
                    'timestamp'=>date("Y-m-d H:i:s")
                    );
                    if($custom->id == 4){
                    	$data['order_state'] = 0;
                    }
                    else{
                    	$data['order_state'] = 0;
                    }
                     $this->order_m->insert($data);
                }
            }
            $this->load->model('config_m');
            $this->config_m->set_item('check_order_item','0');
        }
        
        
        public function insert(){
        	parent::islogin();
          $this->load->model('product_m');
          $query = $this->product_m->get($this->input->post('id'));
          //print_r($query);
         // print_r($this->input->post('id'));
          //echo $query->pname;
         $data = array(
            'id' => $this->input->post('id'),
              'name'     =>   '-',
              'qty'      => 1,
              'price'    =>$query->pprice
          );
          $this->cart->insert($data);
          //redirect('order/add');
          
        }
        
      
      public function dele(){
      	parent::islogin();
           $this->load->model('order_m');
           $id =  $this->uri->segment(3,0);
           $this->order_m->delete($id);
           redirect('order/');
      }
      
      public function categoryproduct(){
      	parent::islogin();
         $this->load->model('order_m');
         $date = '2013-12-19';
         $data['list'] = $this->order_m->getsumbydate($date);
         $this->load->view('categoryproduct',$data);
      }
      
      public function categorycustom(){
          
      }
      
      
        /**
         * ajax鎻愪氦鏁版嵁鏇存柊鏁版嵁搴撻噷鐨勮鍗�
         */
        public function ajaxOrderUpdate(){
        	parent::islogin();
            $_orderInfo = json_decode($_POST['order']);
            $this->load->model('product_m');
            $_product =$this->product_m->getByPname($_orderInfo->pname);
            if(!isset($_product)){
                echo "该用户已经添加过订单";
                return;
            }
            
            $this->load->model('custom_m');
            $_custom = $this->custom_m->getByCname($_orderInfo->cname);
            if(!isset($_custom)){
                echo "该用户已经添加过订单";
                return;
            }         
            
            $this->load->model('order_m');
            $_order = $this->order_m->getByOid($_orderInfo->id);

            if(!isset($_order)){
                echo "该用户已经添加过订单";
                return;
            }
                $arr = array(
                'oid' => $_order->oid,
                'pid' => $_product->id,
                'cid' => $_custom->id,
                'qty' => $_orderInfo->qty,
                'pprice' => $_orderInfo->price,
                'otime' => $_order->otime,
                'ptotal'=>$_orderInfo->total,
                'timestamp' => $_order->timestamp
            );
            $this->order_m->update($_orderInfo->id,$arr);  
            $this->load->model('config_m');
            $this->config_m->set_item('check_order_item','0');
            echo "产品修改成功";
        }
        
        public function OrderModiAddProduct(){
        	parent::islogin();           
            $order = $_POST['order'];
            $a = json_decode($order);
            $this->load->model('order_m');
            $this->load->model('custom_m');
            $this->load->model('product_m');
            $orderid = $a->orderid;
            $custom = $this->custom_m->getByCname($a->cname);
            if(!isset($custom)){
                return ;
            }
            $products = $a->products;
            if(sizeof($products)>0){                
                for ($i = 0 ; $i<sizeof($products); $i++){
                   $product = $this->product_m->getByPName($products[$i]->pname);
                    $data = array(
                    'oid'    =>$orderid,
                    'pid'    =>$product->id,
                    'cid'    =>$custom->id,
                    'qty'    =>$products[$i]->qty,
                    'pprice' =>$products[$i]->pprice, 
                    'ptotal' =>$products[$i]->ptotal,
                    'otime'  =>$a->otime,
                    'timestamp'=>date("Y-m-d H:i:s")
                    );
                     $this->order_m->insert($data);
                }
            }
        }
        
        
        /**
         * dele item by oid
         */
        public function ajaxOrderItemDele(){
        	parent::islogin();
            $oid = $_POST['oid'];
            $this->load->model('order_m');
            $this->order_m->delete($oid);
            echo $oid;
        }
      
        
        
        /**
         * get order by oid; ajax
         */
        public function ajaxGetOrderByOId(){
        	parent::islogin();            
            $oid = $_POST['oid'];
            $this->load->model('order_m');
            $order_list = $this->order_m->getListByOrderId($oid);
            if(isset($order_list)){
                echo json_encode($order_list);
            }
            
        }
        
        public function checkcustom(){
        	parent::islogin();
            $info = $_POST['info'];
            $a = json_decode($info);
            $cname = $a->cname;
            $otime = $a->otime;
            $this->load->model('order_m');
            $this->load->model('custom_m');
            $aaa = $this->order_m->checkorder($cname,$otime);
            echo $aaa;    
            
        }
        
}