<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customorder extends CI_Controller {
	
	/***
	 * 列出某个客户的最近未付账单
	 */
	public function index(){
		//parent::islogin();
		$this->load->model('custom_m');
		$query = $this->custom_m->getorderlistbycustomname("南京吃货联盟-1");
		if(!is_null($query)){
			$data['itemlist'] = $query->result();
		}
		$this->load->view('customorder/customorderlist',$data);
	}
            
}