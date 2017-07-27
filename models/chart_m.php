<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * 试图，数据表！
 *
 * @author YunFei
 */
class Chart_m extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    } 
    
	/**
	 * 每个月的销售额
	 */
	function getvalbymonth(){
		 $query = $this->db->query("select floor(sum(`ptotal`)) as val ,DATE_FORMAT(`otime`, '%Y') as y,DATE_FORMAT(`otime`, '%m') as m  from `order` where `otime` > '2014-01-01' group by DATE_FORMAT(`otime`, '%Y-%m')  order by y asc, m asc");
		 return $query->result();
	}
	
	/**
	 * 月利润
	 */
	function getlirunbymonth(){
		$query = $this->db->query("select floor( sum((`pprice`-`inprice`)*qty)) as val,DATE_FORMAT(`otime`, '%Y') as y,DATE_FORMAT(`otime`, '%m') as m  from `order_product` where `otime` > '2014-01-01' group by DATE_FORMAT(`otime`, '%Y-%m')  order by y asc, m asc");
		return $query->result();
	}
	
	function lirunzuhe($str_year){
		$s_t = $str_year."-01-01";
		$s_e = $str_year."-12-31";
		$query = $this->db->query("select floor( sum((`pprice`-`inprice`)*qty)) as val,DATE_FORMAT(`otime`, '%Y') as y,DATE_FORMAT(`otime`, '%m') as m ,description as cate from `order_product` where `otime` between ? and ? group by description, DATE_FORMAT(`otime`, '%Y-%m')  order by y asc, m asc,categoryid asc;",array($s_t,$s_e));
		return $query->result();
	}
	
	/**
	 * 列出从某个月起倒数几个月的，每种产品的月销量
	 * @param unknown $str_year
	 * @param unknown $month
	 * @param number $backcount
	 */
	function getproductqtybymonth($pid = 0,$backcount = 1){
		$d_last = date("Y-m-d ",mktime(23,59,59,date("m"),date("t"),date("Y")));//本月最后一天
		//$d_first = date("Y-m-d ",mktime(0, 0 , 0,date("m"),1,date("Y"))); //本月第一天
		$a_first = date("Y-m-d ",mktime(0, 0 , 0,date("m")-$backcount,1,date("Y")));
		//$sql = "select sum(qty) as total_count,pname,pid, DATE_FORMAT(`otime`, '%Y-%m') as t from `order_product` where `otime` between ? and ? group by DATE_FORMAT(`otime`, '%Y-%m') , pname order by   t desc, total_count desc";
		if($pid > 0)
		{
			$query = $this->db->query("select sum(qty) as total_count,pname,pid, DATE_FORMAT(`otime`, '%Y-%m') as t from `order_product` where `pid` = ? and `otime` between ? and ? group by DATE_FORMAT(`otime`, '%Y-%m') , pname order by   t ASC, total_count desc",array($pid,$a_first,$d_last));
		}
		else{
			$query = $this->db->query("select sum(qty) as total_count,pname,pid, DATE_FORMAT(`otime`, '%Y-%m') as t from `order_product` where `otime` between ? and ? group by DATE_FORMAT(`otime`, '%Y-%m') , pname order by   t ASC, total_count desc",array($a_first,$d_last));
		}
		return  $query->result();
		
	}
	
	
	
}