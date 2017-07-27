<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productcategory extends CI_Controller{
    
    function index(){
    	parent::islogin();
        $this->load->model('productcategory_m');
        $data['pcategory_list']=$this->productcategory_m->getbypid(0,1);       
        $this->load->view('productcategory/index',$data);
    }
    
    function add(){
        
    }
    
    
    function insert(){
    	parent::islogin();

           if($_SERVER['REQUEST_METHOD']!='POST') {
                return "failed";
           }
            
            $description  =$_POST["description"];
            $pid = $_POST["pid"];
                
            $this->load->model('productcategory_m');
            $this->load->model('gongyingshang_m');
            
            if(!$this->productcategory_m->isexist($description) &&  !$this->gongyingshang_m->isexist($description)){
            	$arr = array('description'=>$description,'pid'=>$pid,'lv'=>0); 
            	$id = $this->productcategory_m->insert($arr);
            	echo "添加成功！";
            }
            else{
            	echo "名称重复！";
            }
               

            
           

           // $data['id'] = $id;
           // $this->load->view('productcategory/success',$data);
    }
    
    function get(){
    	parent::islogin();
        $this->load->model('productcategory_m');
        $data['category_list'] = $this->productcategory_m->getbypid(0);
        $this->load->view('productcategory/category_list',$data);
    }
    
    /*修改*/
    function modi(){
    	parent::islogin();
    	$this->load->model('productcategory_m');
    	$this->load->library('validate');
    	if($_SERVER['REQUEST_METHOD'] != 'POST'){
    		return "error:not post!";
    	}
    	$_description = $_POST['description'];
    	$_id = $_POST['id'];
    	$_pid = $_POST['pid'];
    	$arr = array('description'=>$_description,'pid'=>$_pid,'lv'=>0);
    	$id = $this->productcategory_m->update($_id,$arr);

    	
    	return "修改成功";
    }
    
    /**
     * 修改显示状态
     * @return string
     */
    function modistate(){
    	parent::islogin();
    	//throw new Exception("这个方法不完整");
    	$this->load->model('productcategory_m');
    	if($_SERVER['REQUEST_METHOD'] != 'POST'){
    		return 'error:not post!';
    	}
    	$_id = $_POST['id'];
    	$_isdel = $_POST['isdel'];
    	if($_isdel == 0){
    		$_isdel = 1 ;
    	}
    	else{
    		$_isdel = 0 ;
    	}
    	
    	$arr = array('isdel' => $_isdel);
    	$this->productcategory_m->updatestate($_id,$_isdel);
    	return "msg:修改成功";
    	
    }
    
    
    
    function test(){
    	$this->load->model("productcategory_m","pcate_m");
    	$query = $this->pcate_m->get(175);
    	var_dump($query->pid);
    	var_dump(isset($query));
    	$query = $this->pcate_m->get(170);
    	var_dump($query->pid);
    	var_dump(isset($query));
    }
    
    
    
    
    
}

