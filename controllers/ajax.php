<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Ajax extends CI_Controller {
	function testproc(){
		

		
		$dbhost = $this->db->hostname;  // mysql服务器主机地址
		$dbuser = $this->db->username;            // mysql用户名
		$dbpass = $this->db->password;          // mysql用户名密码
		$dbname = $this->db->database;
		$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		/* check connection */
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		$city = 2;
		
		/* create a prepared statement */
		if ($stmt = $mysqli->prepare("select * from productgrouppricelog where pid = ?")) {
		
			/* bind parameters for markers */
			$stmt->bind_param("i", $city);
		
			/* execute query */
			$stmt->execute();
		
			/*sotre result*/
			$stmt->store_result();
			echo $stmt->num_rows();
			$stmt->free_result();
			
			
			/* bind result variables */
			$stmt->bind_result($district);
		
			/* fetch value */
			$stmt->fetch();
		
			printf("%s is in district %s\n", $city, $district);
		
		$stmt->close();
		}
		$mysqli->close();
		
	/*	$sql = "UPDATE `productgrouppricelog`
SET
`groupprice` = ?
WHERE `pid` = 1 and groupid = 2;
	";
		 $this->db->query($sql,array(5.00));
		$query = $this->db->get('productgrouppricelog');
		*/
		/*
		$query = $this->db->query("CALL test_cursor('1970-02-01',2, 1, 15.00)");
		$this->db->close();
		$query = $this->db->query("select * from productgrouppricelog");
		var_dump($query->result());*/
	}
	
	 function ispnameexsits() {
		parent::islogin ();
		$pname = $_POST ['pname'];
		$this->load->model ( 'product_m' );
		if ($this->product_m->isNameExsits ( $pname )) {
			echo 1;
		} else {
			echo 0;
		}
	}
	//修改产品的价格
	 function updateproductprice() {
		
		parent::islogin ();
		//$info = json_decode ( $_POST ['data'] );
		//$info = json_decode('{"pid":369,"pprice":13,"sprice":16,"groupprice":[{"old":15,"new":15},{"old":20,"new":20}],"sdate":"2017-05-02"}');
		//修改产品本身的价格
		
		
		//记录产品的价格的时间点
		$this->load->model('productpricelog_m');
		$this->productpricelog_m->insertpricelog($info->sdate,$info->pid,$info->pprice,$info->sprice);
	
		$sql = "update product set pprice =? ,sprice = ? where id = ?";
		$this->db->query($sql, array($info->pprice,$info->sprice,$info->pid));

	}
	
	 function getcustom() {
		parent::islogin ();
		$cname = $this->uri->segment ( 3, 0 );
		$this->load->model ( 'custom_m' );
		$data ['arr'] = $this->custom_m->getbycname ( $cname );
		$this->load->view ( 'ajax_custom_list', $data );
	}
	 function getpy() {
		parent::islogin ();
		$pname = $_POST ['pname'];
		$this->load->library ( 'getpingying' );
		$py = $this->getpingying->conv ( $pname );
		echo $py;
	}
	 function getproductprice() {
		parent::islogin ();
		$cname = $_POST ['cname'];
		$pname = $_POST ['pname'];
		$sdate = $_POST ['sdate'];
		$this->load->model( 'productpricelog_m' );
		$this->load->model ( 'product_m' );
		$this->load->model ( 'custom_m' );
		$this->load->model ( 'groupproductprice_m' );
		$custom = $this->custom_m->getByCname ( $cname );
		if (! isset ( $custom )) {
			return;
		}
		$product = $this->product_m->getByPname ( $pname );
		if (! isset ( $product )) {
			return;
		}
		$item = $this->productpricelog_m->getpricelog($sdate,$product->id);
		
		// print_r($custom);
		// print_r($product);
		$price = $this->groupproductprice_m->getprice ( $custom->group_id, $product->id );
		if (isset ( $price )) {
			echo json_encode ( $price );
		} else {
			echo json_encode ( ( object ) (array (
					'price' => $product->sprice 
			)) );
		}
	}
	
	/**
	 * 测试中的新方法
	 * 包含sprice
	 */
	 function getproductpricewithspriece() {
		parent::islogin ();
		$cname = $_POST ['cname'];
		$pname = $_POST ['pname'];
		$this->load->model ( 'product_m' );
		$this->load->model ( 'custom_m' );
		$this->load->model ( 'groupproductprice_m' );
		$custom = $this->custom_m->getByCname ( $cname );
		if (! isset ( $custom )) {
			return;
		}
		$product = $this->product_m->getByPname ( $pname );
		if (! isset ( $product )) {
			return;
		}
		// print_r($custom);
		// print_r($product);
		$price = $this->groupproductprice_m->getsprice ( $custom->group_id, $product->id );
		if (isset ( $price )) {
			echo json_encode ( $price );
		} else {
			echo json_encode ( '' );
		}
	}
	 function getProductAll() {
		parent::islogin ();
		echo "aaaaa";
	}
	 function getproductbydescription() {
		parent::islogin ();
		$description = $_POST ['description'];
		$this->load->model ( 'product_m' );
		$arr = $this->product_m->getbycategorydescription ( $description );
		echo json_encode ( $arr );
	}
	
	
	/***
	 * 在改动价格结构后，新的方法用来替代老的 getproductbyname 方法
	 */
	 function getproductinfobyname(){
		/*****
		 * 要返回的信息
		 * 1.商品基本信息
		 * 2.价格
		 */
	
		parent::islogin ();
		$info = json_decode ( $_POST ['data'] );
		$this->load->model ( 'product_m' );
		$this->load->model ( 'customgroup_m' );
		$this->load->model ( 'groupproductprice_m' );
		$product = $this->product_m->getByPname ( $info->pname );
		if(!isset($product)){
			echo json_encode ( ( object ) (array (
					'err' => "产品不存在！"
			)));
		}
		$group = $this->customgroup_m->get_by_cname ( $item->cname );
		if ( ! isset ( $group ) ) {
			//改用户没有分组 则加载默认的价格
		} else {
			//用户分了组 则加载组价格
		}
		
		
		
	}
	 function getproductbyname() {
		parent::islogin ();
		$description = $_POST ['description'];
		$this->load->model ( 'product_m' );
		$arr = $this->product_m->getByPname ( $description );
		echo json_encode ( $arr );
	}
	 function insertgroupprice() {
		parent::islogin ();
		$order = json_decode ( $_POST ['order'] );
		$this->load->model ( 'product_m' );
		$this->load->model ( 'customgroup_m' );
		$this->load->model ( 'groupproductprice_m' );
		$product = $this->product_m->getByPname ( $order->pname );
		
		if (! isset ( $product )) {
			echo "producterror";
			return;
		}
		echo $product->id;
		
		$group = $this->customgroup_m->get_by_cname ( $order->cname );
		if (! isset ( $group )) {
			echo "grouperr";
			return;
		}
		echo $group->group_id;
		echo $order->price;
		
		$arr = array (
				'productid' => $product->id,
				'groupid' => $group->group_id,
				'price' => $order->price 
		);
		
		// print_r($arr) ;
		$is_exsit = $this->groupproductprice_m->gpp_is_exsit ( $arr );
		// echo $is_exsit;;
		
		if ($is_exsit) {
			$this->groupproductprice_m->gpp_update ( $arr );
		} else {
			$this->groupproductprice_m->insert ( $arr );
			echo "true";
		}
	}
}