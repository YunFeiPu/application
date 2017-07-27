<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {


    
         public function ispnameexsits(){
         	
             $pname = $_POST['pname'];
             $this->load->model('product_m');
             if( $this->product_m->isNameExsits($pname)){
                 echo 1;
             }else{
                 echo 0;
             }
         }
    
    
        
	public function getcustom()
	{
			parent::islogin();
            $cname = $this->uri->segment(3,0);
            $this->load->model('custom_m');
            $data['arr'] = $this->custom_m->getbycname($cname);
            $this->load->view('ajax_custom_list',$data);
	}
	
	public function getpy(){
		parent::islogin();
		$pname = $_POST['pname'];
		$this->load->library('getpingying');
		$py = $this->getpingying->conv($pname);
		echo $py;
	}
        
        public  function getproductprice(){
        	parent::islogin();
            $cname =$_POST['cname'];
            $pname = $_POST['pname'];
            $this->load->model('product_m');
            $this->load->model('custom_m');
            $this->load->model('groupproductprice_m');
            $custom = $this->custom_m->getByCname($cname);
            if(! isset($custom)){
                return;
            }
            $product = $this->product_m->getByPname($pname);
            if(! isset($product)){
                return;
            }
           // print_r($custom);
           // print_r($product);
            $price = $this->groupproductprice_m->getprice($custom->group_id,$product->id);
            if(isset($price)){
                echo json_encode($price);
            }
            else{
                echo json_encode((object)(array('price'=>$product->sprice)));
            }
        }
		
		
		
		/**测试中的新方法
		 * 包含sprice
		 */
		public function getproductpricewithspriece(){
			parent::islogin();
			 $cname =$_POST['cname'];
            $pname = $_POST['pname'];
            $this->load->model('product_m');
            $this->load->model('custom_m');
            $this->load->model('groupproductprice_m');
            $custom = $this->custom_m->getByCname($cname);
            if(! isset($custom)){
                return;
            }
            $product = $this->product_m->getByPname($pname);
            if(! isset($product)){
                return;
            }
           // print_r($custom);
           // print_r($product);
            $price = $this->groupproductprice_m->getsprice($custom->group_id,$product->id);
            if(isset($price)){
                echo json_encode($price);
            }
            else{
                echo json_encode('');
            }
		}
        
       
        public function getProductAll(){
        	parent::islogin();
            echo "aaaaa";
        }
        
        public function getproductbydescription(){
        	parent::islogin();
            $description = $_POST['description'];
            $this->load->model('product_m');
            $arr = $this->product_m->getbycategorydescription($description);
            echo json_encode($arr);
        }
        
        public function getproductbyname(){
        	parent::islogin();
            $description = $_POST['description'];
            $this->load->model('product_m');
            $arr = $this->product_m->getByPname($description);
            echo json_encode($arr);
        }
        
        public function insertgroupprice(){
        	parent::islogin();
            $order = json_decode($_POST['order']);
            $this->load->model('product_m');
            $this->load->model('customgroup_m');
            $this->load->model('groupproductprice_m');
            $product = $this->product_m->getByPname($order->pname);
            
            if(!isset($product)){
                echo "producterror";
                return;
            }
            echo $product->id;
            
            $group = $this->customgroup_m->get_by_cname($order->cname);
            if(!isset($group)){
                echo "grouperr";
                return;
            }
            echo $group->group_id;
            echo $order->price;
            
            $arr = array(
                'productid' => $product->id,
                'groupid' =>$group->group_id,
                'price' => $order->price
            );
           
            

            //print_r($arr) ;
            $is_exsit = $this->groupproductprice_m->gpp_is_exsit($arr);
            //echo $is_exsit;;
            
            if($is_exsit){
                $this->groupproductprice_m->gpp_update($arr);
            }else{
                $this->groupproductprice_m->insert($arr);
                echo "true";
            }
            
             
            
            
            
        }
        
        
            
        
}