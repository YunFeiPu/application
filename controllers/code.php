<?php
class Code extends CI_Controller {
    //put your code here
    
	
	//清空供应商数据表 并且 赋值数据
	function fjsdafjasklfjdsaklfjakl(){
		$this->db->truncate('gongyingshang');
		$sql = "insert into gongyingshang (gys_name) select description from productcategory order by id asc";
		$this->db->query($sql);
	}
	
	//清空锁单和供货单
    public function fjsdafjasklfjdsaksflfjakl()
    {
    	$this->db->truncate('gonghuodan');
    	$this->db->truncate('gonghuodan_bak');
    	$this->db->truncate('gonghuodan_mingxi');
    	$this->db->truncate('gonghuodan_mingxi_bak');
    	
    }
    
    
    function mmm(){

    }
    
    
    
    
    
    
    
    
    
    function assssdadfdfsda(){
    	$this->load->model('gonghuodan_m');
    	
    	$j = 0;
    for($i = strtotime('2017-07-01'); $i< strtotime('2017-07-31'); $i +=84600){
    $y = mktime(0,0,0,07,01,2017);
    $date = date("Y-m-d",$y+$j*24*3600);
    $j++;
    
    	//锁单
    	
    	$sql = "select * from gonghuodan_bak where gonghuodan_bak.ghd_date = ? ";
    	
    	$query = $this->db->query($sql,array($date));
    	if($query->num_rows()>0){
    		echo $date."已经有了<br>";
    		$this->gonghuodan_m->delegonghuodan_bakdatabydate($date);
    	}
    	
    	
    	
    	//创建主表的空白清单
    	$sql = "Insert into gonghuodan_bak(id_gys, ghd_date, ghd_jine,ghd_jiesuan_jine,ghd_state,ghd_pic,ghd_beizhu) 		select gys_id,?,0,0,1,'','' from  (select description from (
        SELECT product.categoryid  FROM `order` left join `product` on
         `order`.`pid` =  `product`.`id`
							where `order`.`otime` =?)
                            as a1  left join productcategory on a1.categoryid = productcategory.id  group by description) as a2 left join gongyingshang on
                            a2.description = gongyingshang.gys_name";
    	$query = $this->db->query($sql,array($date,$date));
    	$sql = "
		select  gonghuodan_bak.ghd_id ,pid,qty,pprice,qty*pprice as heji
		from (
			select pid,qty, pprice ,description, gongyingshang.gys_id,gongyingshang.gys_name
			from (
				SELECT a2.pid ,qty ,pprice,description
				from (
					select pid ,qty, product.pprice, product.categoryid 
    				from (
						SELECT pid,sum(qty)  as qty  
    					FROM `order`
						where otime =?
						group by pid
					) as a1
					left join product 
    				on a1.pid = product.id
				) as a2 
    			left join productcategory 
    			on a2.categoryid = productcategory.id
			) as a3 
    		left join gongyingshang 
    		on a3.description = gongyingshang.gys_name
		) as a4 
    	left join gonghuodan_bak 
    	on a4.gys_id = gonghuodan_bak.id_gys 
    	where gonghuodan_bak.ghd_date = ?					";
    	$query = $this->db->query($sql, array($date,$date));
    	if($query->num_rows()>0){
    		$list = $query->result();
    		foreach ($list as $arr){
    			 
    			$sql = "INSERT INTO `gonghuodan_mingxi_bak`
(
`ghd_id`,
`p_id`,
`p_qty`,
`ghd_inprice`,
`ghd_mx_heji`,
`ghd_mx_state`,
`ghd_mx_beizhu`)
VALUES
(?,?,?,?,?,1,'')";
    			$this->db->query($sql, array($arr->ghd_id,$arr->pid,$arr->qty,$arr->pprice,$arr->heji));
    		}
    		
    	};
    		
    	   	
    	
    	//供货单
    	$sql = "select * from gonghuodan where gonghuodan.ghd_date = ? ";
    	
    	$query = $this->db->query($sql,array($date));
    	if($query->num_rows()>0){
    		echo $date."已经有了<br>";//然后删掉主表 附表用触发器删掉
    		$this->gonghuodan_m->delegonghuodandatabydate($date);
    	}
    	
    	$this->load->model('gonghuodan_m');
    	$this->gonghuodan_m->createghd($date);
    	
    	$query = $this->gonghuodan_m->createghdmx($date);
    	if($query->num_rows()>0){
    		$list = $query->result();
    		foreach ($list as $arr)
    		{
    			 
    			$sql = "INSERT INTO `gonghuodan_mingxi`
(
`ghd_id`,
`p_id`,
`p_qty`,
`ghd_inprice`,
`ghd_mx_heji`,
`ghd_mx_state`,
`ghd_mx_beizhu`)
VALUES
(?,?,?,?,?,1,'')";
    			$this->db->query($sql, array($arr->ghd_id,$arr->pid,$arr->qty,$arr->pprice,$arr->heji));
    		}
    		
    	};
    		
    	    } 
    
    }
    
    //清空供货单
    public function test(){
    	
        $this->load->view("dele");
    }
    
}
