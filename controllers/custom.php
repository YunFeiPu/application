<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom extends CI_Controller {
	
	public function index(){
		parent::islogin();
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'custom/index/';
		$config['total_rows'] = 200;
		$config['per_page'] = 20; 
		
		$this->pagination->initialize($config); 
		$data['pages'] = $this->pagination->create_links();
        $this->load->model('custom_m');
        $data['item_list'] = $this->custom_m->getCustomAndGroupList();
        $this->load->view('custom/custom_show',$data);
	}
        
    public function add(){
    	parent::islogin();
        $this->load->model('custom_m');
        $data['custom_list']=$this->custom_m->getall();
        $this->load->model('customgroup_m');
        $data['group_list'] = $this->customgroup_m->GetGroupSelect();
        $this->load->view('custom/custom_add',$data);            
    }
        
    public function insert(){
    	parent::islogin();
        if($_SERVER['REQUEST_METHOD']!='POST') {
            redirect('/custom/add');
        }            
        $this->load->model('custom_m');
        $arr = $this->custom_m->AssembleData();
        
        $this->custom_m->insert($arr);
        redirect('custom/add');
    }
        
    public function modi(){
    	parent::islogin();
    	$this->load->model('customgroup_m');
        $data['group_list'] = $this->customgroup_m->GetGroupSelect();
        
        $this->load->model('custom_m');
        $cid = $this->uri->segment(3,0);
        
        $query = $this->custom_m->get($cid);

        if(!empty($query))
        {
            $data['custom'] = $query;                
        }
        else{
            redirect('custom_add');
        }
        $this->load->view('custom/custom_add',$data);
            
   
    }
        
        

	public function update(){
		parent::islogin();
		$this->load->model('custom_m');
		$arr = $this->custom_m->AssembleData();
		$id = $this->input->post('id');                       
		$this->custom_m->update($id,$arr);            
		redirect('custom/add');
	}
                public function dele(){
        	$this->load->model('custom_m');
        	$id =  $this->uri->segment(3,0);
        	$this->custom_m->delete($id);
        	redirect('custom/');
        }
        
        
            
        
}