<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		parent::islogin();
		$pname = $this->uri->segment(3,FALSE);
		$this->load->model('product_m');
		$data['product_list'] = $this->product_m->getallnamelist();
		if($pname){ 
			$pname = urldecode($pname);
			$sql = "select * from product where pname=?";
			$query = $this->db->query($sql,array($pname));
			if($query->num_rows()>0){
				$row = $query->row();
				$data['item_list'] =array($row);
			}
		}
		else{
    	$this->load->model('product_m');
    	$data['item_list']=$this->product_m->getall();
    	}
		$this->load->view('product/list',$data);
	}
        
        public function add(){
        	parent::islogin();
            $this->load->model('product_m');
           $data['product_list']=$this->product_m->getall();
            $this->load->model('custom_m');
            $data['custom_list'] = $this->custom_m->getall();
           $this->load->model('productcategory_m');
            $data['category_list'] = $this->productcategory_m->getbyselect();
           // var_dump($data['category_list']);
           // return;
           // $this->load->view('product/product_modi',$data);            
			$this->load->view('product/addproduct',$data);
        }
        
        public function insert()
        {
        	parent::islogin();
            if($_SERVER['REQUEST_METHOD']!='POST') {
                redirect('/product/add');
            }
            $this->load->model('product_m');
            $arr = $this->product_m->AssembleData();
            $isExsit = $this->product_m->isNameExsits($arr['pname']);
            if(!$isExsit){
            $this->product_m->insert($arr);
            redirect('product/add');
            }
            else{
                echo "该产品已经存在!";
            }

        }
        
        public function modi(){
            parent::islogin();
            $this->load->model('productcategory_m');
            $data['category_list'] = $this->productcategory_m->getbyselect();
            $this->load->model('product_m');

            $pid = $this->uri->segment(3,0);
            $query = $this->product_m->get($pid);
//            $data['product_list'] = $this->product_m->getallselect();
            
            if(!empty($query))
            {
                $data['product'] = $query;
            }
            else{
                redirect('product/add');
            }
            $this->load->view('product/product_modi',$data);
        }


		public function modigroupprice(){
			parent::islogin();
			$arr = $_POST['select_item'];
			$price = (float)$_POST['price'];
			$sql = "update group_price set price = ? where id in(".implode(',', $arr).")";
			$query = $this->db->query($sql,array($price));
			redirect( "/product/groupprice/".urlencode($_POST['txtpname']));
			//$query = $this->db->query($sql,array($price));
		}
		
		/**
		 * segment(3)pname
		 */
		public function groupprice(){
			parent::islogin();
			$pname = $this->uri->segment(3,FALSE);
			$this->load->model('product_m');
			$data['product_list'] = $this->product_m->getallnamelist();
			
			if($pname){ 
			$pname = urldecode($pname);
			$sql = "select * from product where pname=?";
			$query = $this->db->query($sql,array($pname));
			if($query->num_rows()>0){
				$row = $query->row();
				$pid = (int)$row->id;
			}
			$sql = "select * from group_price where productid=? order by price asc";
			$query = $this->db->query($sql,array($pid));
			if($query->num_rows()>0){
				$data["item_list"] = $query->result();
			}
			}
			$data['pname'] = $pname;
			$this->load->view("product/groupprice",$data);
		}


        public function update(){
        	parent::islogin();
            $this->load->model('product_m');
           	$arr = $this->product_m->AssembleData();
            $id = $this->input->post('id');                       
            $this->product_m->update($id,$arr);            
            redirect('product/add');           
        }
        
        public function dele(){
        	parent::islogin();
           $this->load->model('product_m');
           $id =  $this->uri->segment(3,0);
           $this->product_m->delete($id);
           redirect('product/');
        }
		
        public function updatestate(){
        	parent::islogin();
        	//(Json){data id: _id, state: _ishot, type: "ishot"}
        	if($_SERVER["REQUEST_METHOD"] == "POST"){
  
        		$arr = array();

        		switch ($_POST['type']) {
        			case "ishot":
        				$arr["ishot"] = $_POST["state"] == 1 ? 0 : 1;
        				break;
        			case "isnew":
        				$arr["isnew"] = $_POST["state"] == 1 ? 0 : 1;
        				break;
        			case "isdel":
        				if($_POST["state"] == 0){
        					$arr["ishot"] = 0;
        					$arr["isnew"] = 0;
        					$arr["isdel"] = 1;
        				}else{
        					$arr["isdel"] = 0;
        				}
        				break;
        			default:
        				return;
        				break;
        		}
        		$this->load->model('product_m');
        		$this->product_m->update( $_POST["id"], $arr );
        	}
        	
        	
        }
        
}