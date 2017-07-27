<?php

class tableexport extends CI_Controller {

    function __construct()
    {
    parent::__construct();

    // Here you should add some sort of user validation
    // to prevent strangers from pulling your table data
    }
    
    
    
    function exportBill(){
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
        $this->load->model('order_m');
        $arr = $this->order_m->checkitem();
        foreach($arr as $a){
            echo "<a href='http://localhost/erp/order/showinfo/".$a."'>".$a."</a><br/>";
        };
    }
    
    function test(){
        
        if(isset($_POST['v_sdate'])){
            $date =  $_POST['v_sdate'];
        }
        
        
        
        if(!isset($date) || $date == 0){
            $this->load->view('/tableexport/download');
            return;
        }
        
        
        
        $this->load->helper('file');
        //delete_files('C:\erp\download\\');
            $this->load->model('order_m');
            $this->load->library('zip');            
            $orderid_list = $this->order_m->getOrderListByDate($date);
            
            if(!isset($orderid_list)){
                return ;
            }
            $apath = getcwd().'\download\\'.$date;
             if (!file_exists($apath))
             {
             mkdir($apath, 0777);
            }

            
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
        $PHPExcel = $reader->load("/erp/template/peisong.xls");
        }
        else{
             $PHPExcel = $reader->load("/erp/template/peisong2.xls");
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
        foreach ($query as $item){
            
                $index = $i+$j;
                $PHPExcel->getActiveSheet()->setCellValue( 'C'.$index, $item->pname);
                $PHPExcel->getActiveSheet()->setCellValue( 'E'.$index, $item->pset);
                $PHPExcel->getActiveSheet()->setCellValue( 'G'.$index,  number_format($item->pprice,2));
                $PHPExcel->getActiveSheet()->setCellValue( 'F'.$index, $item->qty);
                $PHPExcel->getActiveSheet()->setCellValue( 'H'.$index, $item->ptotal);
                $i++;

        }
        $objWriter = IOFactory::createWriter($PHPExcel, 'Excel5');
        $cname = iconv("UTF-8","GB2312//IGNORE",$data['cname']);
        $objWriter ->save(getcwd().'\download\\'.$data['otime'].'\\'.$_ic.'-'.$data['otime'].'-'.$cname.'.xls');
        $_ic++;
        }
        
        
        
      
        

        //$path = '/download/';
        $path='/erp/download/'.$data['otime'].'/';
        $this->zip->read_dir($path,false); 

        // 将文件下载到你的桌面上，命名为 "my_backup.zip"
        $this->zip->download($data['otime'].'.zip');
 
    }

    function index(){
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
        $PHPExcel = $reader->load("/erp/template/peisong.xls");
        $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起

        $PHPExcel->setActiveSheetIndex(0);
        
   
        
        $width = $PHPExcel->getActiveSheet()->getColumnDimension('I')->getWidth();
         $PHPExcel->getActiveSheet()->setCellValue('D2', $data['cname']);
         $PHPExcel->getActiveSheet()->setCellValue('H2', $data['otime']);
          $PHPExcel->getActiveSheet()->setCellValue('D3', $data['ctel']);
         $PHPExcel->getActiveSheet()->setCellValue('H3', " ".strval($orderid));
        $i = 1;
        $j = 4;
        foreach ($query as $item){
            if($i<=13){
                $index = $i+$j;
                $PHPExcel->getActiveSheet()->setCellValue( 'C'.$index, $item->pname);
                $PHPExcel->getActiveSheet()->setCellValue( 'E'.$index, $item->pset);
                $PHPExcel->getActiveSheet()->setCellValue( 'G'.$index,  number_format($item->pprice,2));
                $PHPExcel->getActiveSheet()->setCellValue( 'F'.$index, $item->qty);
                $PHPExcel->getActiveSheet()->setCellValue( 'H'.$index, $item->ptotal);
                $i++;
            }
            else{
                    
            }
        }
        
       
      
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');  
        header('Content-Disposition: attachment;filename="'.$data['otime'].'-'.$data['cname'].'.xls"');  
        header('Cache-Control: max-age=0');  
        IOFactory::createWriter($PHPExcel, 'Excel5')->save('php://output');
        
        
        
        
        
        
        
    }
    
     /*$_widthOffSet = 1.1;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.13+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.75+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(0.62+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4.25+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(19.13+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.88+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10.5+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.5+$_widthOffSet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17.38+$_widthOffSet);
        //行高
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(29);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(14.25);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(14.25);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(22.5);
        
        //第五行开始为循环体
        
        */
        
        /*

        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('B2:D2')->setCellValue('B2', '收货单位:');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setName('仿宋');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3')->setCellValue('B3', '联系电话:');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setName('仿宋');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('I2', '订单编号:');
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setName('仿宋');
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I3', '配送日期:');
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setName('仿宋');
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        
        
        $objPHPExcel->getActiveSheet()->setCellValue('C5','123');
        //echo $highestColumn;
        

$objWriteHTML = new PHPExcel_Writer_HTML($PHPExcel); //输出网页格式的对象

//这样在需要预览的地方加入如下语句即可预览出来：
	$objWriteHTML->save("php://output");*/
    
}
