<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
<script type="text/javascript">
    $((function($){
    $.datepicker.regional['zh-CN'] = {
        clearText: '清除',
        clearStatus: '清除已选日期',
        closeText: '关闭',
        closeStatus: '不改变当前选择',
        prevText: '<上月',
        prevStatus: '显示上月',
        prevBigText: '<<',
        prevBigStatus: '显示上一年',
        nextText: '下月>',
        nextStatus: '显示下月',
        nextBigText: '>>',
        nextBigStatus: '显示下一年',
        currentText: '今天',
        currentStatus: '显示本月',
        monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        monthNamesShort: ['一','二','三','四','五','六', '七','八','九','十','十一','十二'],
        monthStatus: '选择月份',
        yearStatus: '选择年份',
        weekHeader: '周',
        weekStatus: '年内周次',
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        dayStatus: '设置 DD 为一周起始',
        dateStatus: '选择 m月 d日, DD',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        initStatus: '请选择日期',
        isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
})(jQuery));
</script>
<script>
        $(function(){
            $( "#v_date" ).datepicker();
        });
         $(function(){
			$("#btnselectall").click(function(){
						$('input:checkbox').prop("checked",true);
			});
			
			$("#btnunselectall").click(function(){
						$('input:checkbox').removeProp("checked");
			});
			
			$("#btnInvert").click(function () {  
				$("input:checkbox").each(function () {  
            		this.checked = !this.checked;  
         		});
			});
			

			
       });
       
       $(function(){
       		$("#btn1").click(function(){
       			$("#hidden_shipid").val(1);
       			$("#aform").submit();
       		});
       		$("#btn2").click(function(){
       			$("#hidden_shipid").val(2);
       			$("#aform").submit();
       		});
       		$("#btn3").click(function(){
       			$('input:checkbox').prop("checked",true);
       			$("#hidden_shipid").val("auto");
       			$("#aform").submit();
       		});
       		
       });
</script>
        
</head>
<body>
<h3>管理</h3>
    <?php echo form_open('shiporder/index'); ?>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_date',
              'id'          => 'v_date',
              'value'       => isset($v_date)?$v_date:$order_date
            );
            echo form_input($data);
            ?>  
	<?php echo form_submit('mysubmit', '确定')?>
    <?php echo form_close()?>
    
<a href="<?php  ?>0">未处理</a> | <a href="<?php  ?>3_4">已结</a> | <a href="<?php  ?>1_2">未结</a>
 | <a href="<?php  ?>5">月结未付</a>
  | <a href="<?php  ?>all">全部不含月结</a><br />
  
  <input id="btn1" type="button" value="1号"/>
<input id="btn2" type="button" value="2号"/>
<input id="btn3" type="button" value="自动"/>
<form id="aform" action="<?php echo base_url(); ?>shiporder/modilist" method="post" onsubmit="return confirm('您确定要修改分组吗？')">
   <input type="hidden" value="" id="hidden_shipid" name="hidden_shipid" />
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号<input id="btnselectall" type="button" value="全选"/>
                  <input id="btnunselectall" type="button" value="全不选" />
    <input id="btnInvert" type="button" value="反选" /></th><th>订单号</th><th>送货日期 </th><th>客户名称</th><th>合计金额</th><th>分配状态</th><th>结单状态</th><th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $_total= 0;
            $i = 1;
            $yishou = 0;
            ?>
            <?php if(isset ($item_list)):?>
            <?php 

            $n1 = array(0,0,0,0,0);
            $n2 = array(0,0,0,0,0);
            $n0 = 0;
            ?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><input name="order_item[]" type="checkbox" value="<?php echo $item->oid;?>"  /><?php echo $i; $i++;?></td>
                    <td><a href="<?php echo base_url() ?>order/showinfo/<?php echo $item->oid; ?>"><?php echo $item->oid;?></a></td>
                    <td><?php echo $item->otime;?></td>
                    <td><?php echo $item->cname;?></td>
                    <td><?php echo number_format($item->ptotal,2); $_total+=$item->ptotal;?></td>
                    <td><?php 
                    switch ($item->ShipCateId)
{
case 1:
	echo "<label class='green'>1号配送</label>";
	break;  
case 2:
	echo "<label class=''>2号配送</label>";
	break;
default:
  echo "<label class='red'>未分配</label>";
}?></td>
  <td><?php 
                    switch ($item->order_state)
{
case 1:
	echo "<label class='red'>现金未付</label>";
	if($item->ShipCateId == 1){
		$n1[0] += $item->ptotal;
	}else if($item->ShipCateId == 2){
		$n2[0] += $item->ptotal;
	}
	else{
		$n0 += $item->ptotal;
	}
	break;  
case 2:
	echo "<label class='red'>支付宝未付</label>";
	if($item->ShipCateId == 1){
		$n1[0] += $item->ptotal;
	}else if($item->ShipCateId == 2){
		$n2[0] += $item->ptotal;
	}
	else{
		$n0 += $item->ptotal;
	}
	break;
case 3:
  	echo "<label class='green'>现金已结</label>";
  	if($item->ShipCateId == 1){
  		$n1[1] += $item->ptotal;
  	}else if($item->ShipCateId == 2){
  		$n2[1] += $item->ptotal;
  	}
  	else{
  		$n0 += $item->ptotal;
  	}
  	$yishou += $item->ptotal;
	break;
case 4:
	echo "<label class='green'>支付宝已结</label>";
	if($item->ShipCateId == 1){
		$n1[2] += $item->ptotal;
	}else if($item->ShipCateId == 2){
		$n2[2] += $item->ptotal;
	}
	else{
		$n0 += $item->ptotal;
	}
	break;
	case 5:
		echo "<label class='green'>月结未付</label>";
		break;
default:
	if($item->ShipCateId == 1){
		$n1[3] += $item->ptotal;
	}else if($item->ShipCateId == 2){
		$n2[3] += $item->ptotal;
	}
	else{
		$n0 += $item->ptotal;
	}
  echo "<label class='red'>未处理</label>";
}?></td>
                    <td><a href="<?php echo base_url() ?>shiporder/modi/<?php echo $item->oid; ?>/0/<?php echo str_replace('/', '_', current_url());?>">未分配 </a>
                     |<a href="<?php echo base_url() ?>shiporder/modi/<?php echo $item->oid; ?>/1/<?php echo str_replace('/', '_', current_url());?>"> 1号配送 </a>
                      | <a href="<?php echo base_url() ?>shiporder/modi/<?php echo $item->oid; ?>/2/<?php echo str_replace('/', '_', current_url());?>">2号配送</a><br />
                      <br/><a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/3/<?php echo str_replace('/', '_', current_url());?>" ><label class="green">现金已结清</label></a>
                     | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/4/<?php echo str_replace('/', '_', current_url());?>" ><label class="green">支付宝已结清</label></a>
                     <br/><a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/1/<?php echo str_replace('/', '_', current_url());?>" ><label class="red">现金未结</label></a>
                     | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/2/<?php echo str_replace('/', '_', current_url());?>" > <label class="red">支付宝未结</label></a>
                     | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/5/<?php echo str_replace('/', '_', current_url());?>" > <label class="red">月结未付</label></a>
                     | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/0/<?php echo str_replace('/', '_', current_url());?>" > <label class="red">未处理</label></a>
                </td>
                </tr>
        <?php endforeach;?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="8">1号配送现金已结：<?php echo number_format($n1[1],2);?><br />
                1号配送支付宝已结：<?php echo number_format($n1[2],2);?><br />
                1号配送未付：<?php echo number_format($n1[0],2);?><br />
                1号配送未处理：<?php echo number_format($n1[3],2);?><br />
                2号配送现金已结：<?php echo number_format($n2[1],2);?><br />
                2号配送支付宝已结：<?php echo number_format($n2[2],2);?><br />
                2号配送未付：<?php echo number_format($n2[0],2);?><br />
                2号配送未处理：<?php echo number_format($n2[3],2);?><br />
               其它合计:<?php echo $n0;?>

                </th>
            </tr>
        </tfoot>
                <?php endif;?>
    </table>
   </form>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
