<?php
class Groupproductprice extends CI_Controller {
    //put your code here
    
    public function index()
    {
    	parent::islogin();
        $this->load->model('groupproductprice_m' , 'item');
        $data['item_list'] = $this->item->getall();
        $this->load->view('groupproductprice/list',$data);
    }
        
    public function add(){
    	parent::islogin();
       $this->load->model('groupproductprice_m' , 'item');
       $this->load->model('customgroup_m');
       $this->load->model('product_m');
       
       $data['group_list'] = $this->customgroup_m->GetGroupSelect();
        $data['item_list']= $this->item->getall();
        $data['product_list'] = $this->product_m->getallselect();
        $this->load->view('groupproductprice/add',$data);            
    }
        
    public function insert()
    {
    	parent::islogin();
        if($_SERVER['REQUEST_METHOD']!='POST') {
            redirect('groupproductprice/add');
        }            
        $this->load->model('groupproductprice_m' , 'item');
        $arr = $this->item->AssembleData();

        $this->item->insert($arr);
        redirect('groupproductprice/add');
    }
        
    public function modi(){
    	parent::islogin();
       $this->load->model('groupproductprice_m' , 'item');
       $this->load->model('customgroup_m');
       $this->load->model('product_m');
       
       $data['group_list'] = $this->customgroup_m->GetGroupSelect();
        $data['item_list']= $this->item->getall();
        $data['product_list'] = $this->product_m->getallselect();

        $cid = $this->uri->segment(3,0);

        $query = $this->item->get($cid);

        if(!empty($query))
        {
            $data['item'] = $query;                
        }
        else{
            redirect('groupproductprice/add');
        }
        $this->load->view('groupproductprice/add',$data);


    }
        
        

    public function update(){
    	parent::islogin();
    $this->load->model('groupproductprice_m' , 'item');
    $arr = $this->item->AssembleData();
    $id = $this->input->post('id');                       
    $this->item->update($id,$arr);            
    redirect('groupproductprice/add');

    }
    
    function delete($id){
    	parent::islogin();
$this->db->where('id',$id);
$this->db->delete('groupproductprice');
}
    
    function AssembleData(){
    	parent::islogin();
$groupid = $_POST['v_groupid'];
$productid = $_POST['v_productid'];
$price = $_POST['v_price'];
$arr = array(
'groupid' => $groupid,
'productid' => $productid,
'price' => $price);
return $arr;
} 
}