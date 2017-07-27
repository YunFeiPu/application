<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tableexport extends CI_Controller {

    function __construct()
    {
    parent::__construct();

    // Here you should add some sort of user validation
    // to prevent strangers from pulling your table data
    }
    
    
    
    
    function testprint_r(){
    	
    }
    
    
    function exportBill(){
    	parent::islogin();
        $arr = array();
        $arr['cname'] = '无锡周茉食品超市（门店）';
        $arr['atime'] = '2014-11-01';
        $arr['btime'] ='2014-12-31';
        $this->load->model('order_confirm_m','item');
        $query = $this->item->getOrderList($arr);
        if(!isset($query)){
            return;
        }
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $reader = IOFactory::createReader('Excel2007');
        $PHPExcel = $reader->load("/erp/template/duizhangdan.xlsx");
        /**
         * C6,D6开始 产品名称   2,6
         * C2，D2产品单价
         * C3，D3 产品计数综合
         * C4，D4 产品单项金额
         * C5 当月产品总金额
         * B7，B8 开始 日期
         * C7，C8 数量
         * A7，A8 当天产品总金额
         *  
         */
        
        $PHPExcel->setActiveSheetIndex(0);
        
       
        foreach($query->result() as $item){
            
            
        $datapname = str_replace('【融字号】','',$item->pname);
        $col =0;
        $row = 0;
        $haspname = false;
        $hasotime = false;
            //$item->pname
            //$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow()
            for($i = 2;$i<30;$i++){
                $pname = $PHPExcel->getActiveSheet()->getCellByColumnAndRow($i,6)->getValue();
                if(strlen($pname)<= 0){
                    $col = $i;
                    break;
                }
                else{
                    if($pname == $datapname){
                        $haspname = true;
                        $col = $i; 
                        break;
                    }
                }
            }
            
            if($haspname == false){
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,6,$datapname);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,2,$item->pprice);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,3,0);
            }
            
            for($j = 4 ; $j<40;$j++){
                 $otime = $PHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$j*2-1)->getValue();
                 if(strlen($otime)<= 0){
                    $row = $j;
                    //echo "break";
                    break;
                }
                else{
                    if($otime == $item->otime){
                        $hasotime = true;
                       // echo "hasotiem";
                        $row = $j; 
                       // echo $j;
                        break;
                    }
                }
            }
            
            if($hasotime == false){
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row*2-1,$item->otime);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row*2,$item->otime);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row*2-1,0);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row*2,0);
            }
            if($item->qty>=0){
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row*2-1,$item->qty);
            $ptt=$item->qty *  $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,2)->getValue();//当前项目的金额合计
            $rowtt = $PHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$row*2-1)->getValue() + $ptt;
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row*2-1,$rowtt);
            }
            else{
                //$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row*2,$item->qty);
                $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row*2,$item->qty);
            $ptt=$item->qty *  $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,2)->getValue();//当前项目的金额合计
            $rowtt = $PHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$row*2)->getValue() + $ptt;
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row*2,$rowtt);
            }
            $qty = $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,3)->getValue()+$item->qty;
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,3,$qty);
            $tt= $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,2)->getValue() * $qty;
            $PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,4,$tt);
            

            
        }
        
        
        

        
        
        
        
        
        
        $objWriter = IOFactory::createWriter($PHPExcel, 'Excel2007');
        $cname = iconv("UTF-8","GB2312//IGNORE",$arr['cname']);
        $objWriter ->save(getcwd().'\download\\'.$cname.'.xlsx');

    }
    
    
    function paybill(){
    	parent::islogin();
    	
    	$date = '2014-08-21';
    	$this->load->model('order_m');
    	
    	
    	
    	
    	
    	$this->load->library('PHPExcel');
    	$this->load->library('PHPExcel/IOFactory');
    	$reader = IOFactory::createReader('Excel2007');
    	$PHPExcel = $reader->load("/erp/template/paybill.xlsx");

    	$productlist = $this->order_m->getProductBuyList($date);
    	if(! is_null($productlist)){
    		$cateid = 0;
    		$atotal = 0;
    		$count = 0;
    		$a_col = 1;
    		$a_row = 12;
	    	foreach($productlist as $item)
	    	{
	    		
	    		if($cateid == $item->categoryid){
	    			$atotal += $item->qty*$item->pprice;
	    		}
	    		elseif($cateid != 0){
	    			//不相等 说明 是 一个大类已经结束；输出该大类的金额总计
	    			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($a_col+1,$a_row+$count,$atotal);
	    			$count ++;
	    			$atotal = 0;
	    			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($a_col,$a_row+$count,$item->description);
	    			$cateid = $item->categoryid;
	    			$atotal += $item->qty*$item->pprice;
	    		}else{ 
	    			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($a_col,$a_row+$count,$item->description);
	    			$cateid = $item->categoryid;
	    			$atotal += $item->qty*$item->pprice;
	    		}
	    	}
	    	$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($a_col+1,$a_row+$count,$atotal);
    	}
    	
    	
    	//订单统计区域 
    	
    	$this->load->model('shiporder_m');
    	$shiporderlist = $this->shiporder_m->getShipOrderList($date);
    	//var_dump($shiporderlist);
    	$ship1 = array(
    			'count_3' => 0,
    			'total_3' =>0,
    			'count_0' =>0,
    			'total_0' =>0
    	);
    	$ship2 = array(
    			'count_3' => 0,
    			'total_3' =>0,
    			'count_0' =>0,
    			'total_0' =>0
    	);
    	
    	
    	$b_col = 4;
    	$b_row = 13;
    	$b_count = 0;
    	
    	foreach($shiporderlist as $item){
    		if($item->ShipCateId == 1){
    			if($item->order_state == 3){
    				$ship1['count_3'] ++;
    				$ship1['total_3'] += $item->ptotal;
    			}
    			else{
    				$ship1['count_0'] ++;
    				$ship1['total_0'] += $item->ptotal;
    			}
    		}
    		elseif($item->ShipCateId == 2){
    			if($item->order_state == 3){
    				$ship2['count_3'] ++;
    				$ship2['total_3'] += $item->ptotal;
    			}
    			else{
    				$ship2['count_0'] ++;
    				$ship2['total_0'] += $item->ptotal;
    			}
    		}
    		
    		if($item->order_state != 3){
    			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($b_col,$b_row+$b_count,$item->cname);
    			$PHPExcel->getActiveSheet()->setCellValueByColumnAndRow($b_col+2,$b_row+$b_count,$item->ptotal);
				$b_count++;
    		}
    		
    		
    	}
    	$PHPExcel->getActiveSheet()->setCellValue('D4', $ship1['count_3']);
    	$PHPExcel->getActiveSheet()->setCellValue('F4', $ship1['total_3']);
    	$PHPExcel->getActiveSheet()->setCellValue('D5', $ship1['count_0']);
    	$PHPExcel->getActiveSheet()->setCellValue('F5', $ship1['total_0']);
    	$PHPExcel->getActiveSheet()->setCellValue('D7', $ship2['count_3']);
    	$PHPExcel->getActiveSheet()->setCellValue('F7', $ship2['total_3']);
    	$PHPExcel->getActiveSheet()->setCellValue('D8', $ship2['count_0']);
    	$PHPExcel->getActiveSheet()->setCellValue('F8', $ship2['total_0']);
    	$PHPExcel->getActiveSheet()->setCellValue('C2', $date);
    	
    	
    	
    	$objWriter = IOFactory::createWriter($PHPExcel, 'Excel2007');
    	$cname = iconv("UTF-8","GB2312//IGNORE",'应付总单');
    	$objWriter ->save(getcwd().'\download\\'.$cname.$date.'.xlsx');
    }
    
    function check(){
    	parent::islogin();
        $this->load->model('order_m');
        $arr = $this->order_m->checkitem();
        foreach($arr as $a){
            echo "<a href='http://localhost/erp/order/showinfo/".$a."'>".$a."</a><br/>";
        };
    }
    
    /***
     * 2017-04-14
     * 
     */
    function exportorder(){
    	parent::islogin();
    	ini_set('memory_limit','1024M');
    	if(isset($_POST['v_sdate1'])){
    		$date =  $_POST['v_sdate1'];
    	}
    	
    	
    	if(!isset($date) || $date == 0){
    		$this->load->view('/tableexport/download');
    		return;
    	}
    	$this->suodan($date);
    	$this->load->helper('file');
    	//delete_files('C:\erp\download\\');
    	$this->load->model('order_m');
    	$this->load->library('zip');
    	$orderid_list = $this->order_m->getOrderListByDate($date);
    	
    	if(!isset($orderid_list)){
    		return ;
    	}
    	$apath = getcwd().'/download/'.$date;
    	if (!file_exists($apath))
    	{
    		mkdir($apath);
    		// chmod($apath,0777);
    	}
    	else{
    		//文件夹已经存在
    		$dh=opendir($apath);
    		
    		while ($file=readdir($dh))
    		{
    			if($file!="." && $file!="..")
    			{
    				$fullpath=$apath."/".$file;
    		
    				if(!is_dir($fullpath))
    				{
    					unlink($fullpath);
    				}
    				else
    				{
    					deldir($fullpath);
    				}
    			}
    		}
    		
    		closedir($dh);
    	}
    	
    	//echo file_exists('/template/peisong.xls').'1111<br>';
    	
    	$_ic = 1;
    	foreach($orderid_list as $item_order){
    	
    		$orderid =  $item_order->oid;
    	
    		$query = $this->order_m->getlistbyorderid($orderid);
    		if(empty($query)){
    			redirect('/order/','refresh');
    		}
    		foreach($query as $item){
    			$data['cname'] = $item->cname;
    			$data['otime'] = $item->otime;
    			$data['oid'] = $item->oid;
    			$data['ctel'] = $item->ctel;
    			break;
    		}
    		$data['orderlist'] = $query;
    	
    		 
    		$this->load->library('PHPExcel');
    		$this->load->library('PHPExcel/IOFactory');
    	
    		$objPHPExcel = new PHPExcel();
    		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
    	
    	
    	
			$recordcount = sizeof($query);    	
    		$reader = IOFactory::createReader('Excel5');
    		if($recordcount<=15){
    			$PHPExcel = $reader->load(getcwd()."/peisong2-15.xls");
    		}
    		else if($recordcount>15 && $recordcount<=17){
    			$PHPExcel = $reader->load(getcwd()."/peisong2-16-17.xls");
    			
    		}
    		else if($recordcount>=18 && $recordcount<=25){
    			$PHPExcel = $reader->load(getcwd()."/peisong2-18-20.xls");
    			 
    		}
    		else if($recordcount>=26 && $recordcount<=44){
    			$PHPExcel = $reader->load(getcwd()."/peisong2-21-44.xls");
    			 
    		}
    		else if($recordcount>=45 && $recordcount<=50){
    			$PHPExcel = $reader->load(getcwd()."/peisong2-45-50.xls");
    		
    		}
    		else{
    			$PHPExcel = $reader->load(getcwd()."/peisong2-51.xls");
    		}
    	
    		$sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起
    	
    		$PHPExcel->setActiveSheetIndex(0);
    	  
    	
    		$width = $PHPExcel->getActiveSheet()->getColumnDimension('I')->getWidth();
    		$PHPExcel->getActiveSheet()->setCellValue('D2', $data['cname']);
    		$PHPExcel->getActiveSheet()->setCellValue('H2', $data['otime']);
    		$PHPExcel->getActiveSheet()->setCellValue('D3', $data['ctel']);
    		$PHPExcel->getActiveSheet()->setCellValue('H3', " ".strval($orderid).'-'.$_ic.'-'.$item_order->ShipCateId);
    		$i = 1;
    		$j = 4;
    		$count = count($query);
    		if($count>13)
    		{
    			$PHPExcel->getActiveSheet()->insertNewRowBefore(6, $count-13);
    		}
    		foreach ($query as $item){
    	
    			$index = $i+$j;
    			$PHPExcel->getActiveSheet()->setCellValue( 'B'.$index, $i);
    			$PHPExcel->getActiveSheet()->setCellValue( 'C'.$index, $item->pname);
    			$PHPExcel->getActiveSheet()->setCellValue( 'E'.$index, $item->pset);
    			$PHPExcel->getActiveSheet()->setCellValue( 'G'.$index,  number_format($item->pprice,2));
    			$PHPExcel->getActiveSheet()->setCellValue( 'F'.$index, $item->qty);
    			$PHPExcel->getActiveSheet()->setCellValue( 'H'.$index, $item->ptotal);
    			$i++;
    	
    		}
    		$objWriter = IOFactory::createWriter($PHPExcel, 'Excel5');
    	
    	
    		$cname = mb_convert_encoding($data['cname'], 'gbk');
    		//$cname = iconv("UTF-8","'gbk//ignore",$data['cname']);
    		$tag = "";
    		$objWriter ->save(getcwd().'/download/'.$data['otime'].'/'.$tag.$_ic.'-'.$data['otime'].$cname.'.xls');
    	
    	
    		$_ic++;
    	}
    	
    	
    	
    	
    	
    	
    	//$path = '/download/';
    	$path=getcwd().'/download/'.$data['otime'].'/';
    	$this->zip->read_dir($path,false);
    	
    	// 将文件下载到你的桌面上，命名为 "my_backup.zip"
    	$this->zip->download($data['otime'].'.zip');
    	
    	}
    	 
    private function suodan($date){
    	//锁单
    	$this->load->model('gonghuodan_m'); 
    	
    	$sql = "select * from gonghuodan_bak where gonghuodan_bak.ghd_date = ? ";
    	 
    	$query = $this->db->query($sql,array($date));
    	if($query->num_rows()>0){
    		//echo $date."已经有了<br>";
    		//删除原来的锁单，生成新的锁单
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
    	
    	}
    	
    }
    
    function test(){
    	parent::islogin();
        ini_set('memory_limit','1024M');
        if(isset($_POST['v_sdate'])){
            $date =  $_POST['v_sdate'];
        }
        
        
        if(!isset($date) || $date == 0){
            $this->load->view('/tableexport/download');
            return;
        }
        $this->suodan($date);
  
        
        $this->load->helper('file');
        //delete_files('C:\erp\download\\');
            $this->load->model('order_m');
            $this->load->library('zip');            
            $orderid_list = $this->order_m->getOrderListByDate($date);
            
            if(!isset($orderid_list)){
                return ;
            }
            $apath = getcwd().'/download/'.$date;
             if (!file_exists($apath))
             {
              mkdir($apath);
             // chmod($apath,0777);
            }
            
            //echo file_exists('/template/peisong.xls').'1111<br>';

            $_ic = 1;
            foreach($orderid_list as $item_order){
            
            $orderid =  $item_order->oid;

            $query = $this->order_m->getlistbyorderid($orderid);            
            if(empty($query)){
                redirect('/order/','refresh');    
            }
            foreach($query as $item){
                $data['cname'] = $item->cname;
                $data['otime'] = $item->otime;
                $data['oid'] = $item->oid;
                $data['ctel'] = $item->ctel;
                break;
            }            
            $data['orderlist'] = $query;
            
           
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        
        
        

        $reader = IOFactory::createReader('Excel5');
		if(sizeof($query)<=13){
        $PHPExcel = $reader->load(getcwd()."/peisong1.xls");
        }
		else if(sizeof($query)<=42){
             $PHPExcel = $reader->load(getcwd()."/peisong2.xls");
        }
		else{
			$PHPExcel = $reader->load(getcwd()."/peisong3.xls");
		}

        $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起

        $PHPExcel->setActiveSheetIndex(0);
        
        $PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('仿宋');
        $PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(18);
        $PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $PHPExcel->getActiveSheet()->setCellValue('B1', '陶陶乐商品送货单');
        
        $width = $PHPExcel->getActiveSheet()->getColumnDimension('I')->getWidth();
         $PHPExcel->getActiveSheet()->setCellValue('D2', $data['cname']);
         $PHPExcel->getActiveSheet()->setCellValue('H2', $data['otime']);
          $PHPExcel->getActiveSheet()->setCellValue('D3', $data['ctel']);
         $PHPExcel->getActiveSheet()->setCellValue('H3', " ".strval($orderid).'-'.$_ic.'-'.$item_order->ShipCateId);
        $i = 1;
        $j = 4;
		$count = count($query);
		if($count>13)
		{
			$PHPExcel->getActiveSheet()->insertNewRowBefore(6, $count-13);
		}
        foreach ($query as $item){
            
                $index = $i+$j;
				$PHPExcel->getActiveSheet()->setCellValue( 'B'.$index, $i);
                $PHPExcel->getActiveSheet()->setCellValue( 'C'.$index, $item->pname);
                $PHPExcel->getActiveSheet()->setCellValue( 'E'.$index, $item->pset);
                $PHPExcel->getActiveSheet()->setCellValue( 'G'.$index,  number_format($item->pprice,2));
                $PHPExcel->getActiveSheet()->setCellValue( 'F'.$index, $item->qty);
                $PHPExcel->getActiveSheet()->setCellValue( 'H'.$index, $item->ptotal);
                $i++;

        }
        $objWriter = IOFactory::createWriter($PHPExcel, 'Excel5');
		

			
       		$cname = mb_convert_encoding($data['cname'], 'gbk');
        	//$cname = iconv("UTF-8","'gbk//ignore",$data['cname']);
			$tag = "";
        	if(sizeof($query)>42){
            	$tag = "notice-";
        	}
        	$objWriter ->save(getcwd().'/download/'.$data['otime'].'/'.$tag.$_ic.'-'.$data['otime'].$cname.'.xls');

        
        $_ic++;
        }
        
        
        
      
        

        //$path = '/download/';
        $path=getcwd().'/download/'.$data['otime'].'/';
        $this->zip->read_dir($path,false); 

        // 将文件下载到你的桌面上，命名为 "my_backup.zip"
        $this->zip->download($data['otime'].'.zip');
 
    }

    /** 打印单个页面的内容 */
    function index(){
    	parent::islogin();
		        // Starting the PHPExcel library
            $this->load->model('order_m');
            $orderid =  $this->uri->segment(3,0);
            $query = $this->order_m->getlistbyorderid($orderid);            
            if(empty($query)){
                redirect('/order/','refresh');    
            }
            foreach($query as $item){
                $data['cname'] = $item->cname;
                $data['otime'] = $item->otime;
                $data['oid'] = $item->oid;
                $data['ctel'] = $item->ctel;
                break;
            }            
            $data['orderlist'] = $query;
       /* <?php $i = 1;?>
            <?php foreach ($orderlist as $item)://custom_list?>
                <tr>    
                    <td><?php echo $i; 
                    $i++?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->pset;?></td>
                    <td><?php echo number_format($item->pprice,2);?></td>                    
                    <td><?php echo $item->qty;?></td>
                    <td><?php echo number_format($item->ptotal,2);?></td>
                    <td>修改 删除</td>
                </tr>
        <?php endforeach;?>
        */
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        
        


        $reader = IOFactory::createReader('Excel5');

  if(sizeof($query)<=13){
        $PHPExcel = $reader->load(getcwd()."/peisong1.xls");
        }
		else if(sizeof($query)<=42){
             $PHPExcel = $reader->load(getcwd()."/peisong2.xls");
        }
		else{
			$PHPExcel = $reader->load(getcwd()."/peisong3.xls");
		}

        $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起

        $PHPExcel->setActiveSheetIndex(0);
        
   
        
        $width = $PHPExcel->getActiveSheet()->getColumnDimension('I')->getWidth();
         $PHPExcel->getActiveSheet()->setCellValue('D2', $data['cname']);
         $PHPExcel->getActiveSheet()->setCellValue('H2', $data['otime']);
          $PHPExcel->getActiveSheet()->setCellValue('D3', $data['ctel']);
         $PHPExcel->getActiveSheet()->setCellValue('H3', " ".strval($orderid));
        $i = 1;
        $j = 4;
		$count = count($query);
		$mindex = $count-13;
		if($count>13)
		{
			$PHPExcel->getActiveSheet()->insertNewRowBefore(6, $mindex);
		}
        foreach ($query as $item){
                $index = $i+$j;
				$PHPExcel->getActiveSheet()->setCellValue( 'B'.$index, $i);
                $PHPExcel->getActiveSheet()->setCellValue( 'C'.$index, $item->pname);
                $PHPExcel->getActiveSheet()->setCellValue( 'E'.$index, $item->pset);
                $PHPExcel->getActiveSheet()->setCellValue( 'G'.$index,  number_format($item->pprice,2));
                $PHPExcel->getActiveSheet()->setCellValue( 'F'.$index, $item->qty);
                $PHPExcel->getActiveSheet()->setCellValue( 'H'.$index, $item->ptotal);
                $i++;
        }
        
       
        $cname = iconv("UTF-8","'gb2312//ignore",$data['cname']);
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');  
        header('Content-Disposition: attachment;filename="'.$data['otime'].$cname.'.xls"');  
        header('Cache-Control: max-age=0');  
        IOFactory::createWriter($PHPExcel, 'Excel5')->save('php://output');

	}
}    

