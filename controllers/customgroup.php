<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customgroup extends CI_Controller {

	public function index()
	{
		parent::islogin();
            $this->load->model('customgroup_m','item');
            $data['item_list'] = $this->item->getall();
            $this->load->view('customgroup/showgrouplist',$data);
	}
        
 
        
        
        public function add(){
        	parent::islogin();
            $this->load->model('customgroup_m','item');
           $data['item_list']=$this->item->getall();
            $this->load->view('customgroup/add',$data);            
        }
        
        public function insert()
        {
        	parent::islogin();
            if($_SERVER['REQUEST_METHOD']!='POST') {
                redirect('/customgroup/add');
            }            
            $this->load->model('customgroup_m','item');
            $arr = $this->item->AssembleData();
            
            $this->item->insert($arr);
            redirect('customgroup/add');
        }
        
        
        public function managecustom(){
        	parent::islogin();
            $this->load->model('custom_m',"item");
            $data['item_list']=$this->item->getCustomAndGroupList();            
            $this->load->view('customgroup/list',$data);
        }
        
        public function modi(){
        	parent::islogin();
             $this->load->model('customgroup_m','item');
            $cid = $this->uri->segment(3,0);
            
            $query = $this->item->get($cid);

            if(!empty($query))
            {
                $data['customgroup'] = $query;                
            }
            else{
                redirect('customgroup/');
            }
            $this->load->view('customgroup/add',$data);
            
   
        }
        
        

            public function update(){
            	parent::islogin();
            $this->load->model('customgroup_m');
            $arr = $this->customgroup_m->AssembleData();
            $id = $this->input->post('id');                       
            $this->customgroup_m->update($id,$arr);            
            redirect('customgroup/add');
            
        }

        public function dele(){
        	parent::islogin();
        	$this->load->model('customgroup_m');
        	$id =  $this->uri->segment(3,0);
        	$this->customgroup_m->delete($id);
        	redirect('customgroup/list');
        }
        
            
        
}