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
            $( "#v_sdate" ).datepicker();
            $( "#v_edate" ).datepicker();
        });

        $(function(){
        	//alert($("#h_ostate").val());
			if($("#h_ostate").val()!=""){
				$("#v_ostate").val($("#h_ostate").val());
			}
        });

        $(function(){
			$('form').submit(function(){
			    var d1 = $('#v_sdate').val();
				var d2 = $('#v_edate').val();
				if(d1 != '' && d2 != ''){
					d1Arr=d1.split('-');
			        d2Arr=d2.split('-');
			        v1=new Date(d1Arr[0],d1Arr[1],d1Arr[2]);
			        v2=new Date(d2Arr[0],d2Arr[1],d2Arr[2]);
			        if(v1>=v2){
						alert('结束时间必须大于起始时间');

			        	return false;
				    }
				}
            });
		});
</script>

</head>
<body>
    <h3>管理</h3>
    <?php echo form_open('order/index'); ?>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($v_sdate)?$v_sdate:date('Y-m-d')
            );
            echo form_input($data);
            ?>  
   请选择配送结束日期<?php
            $data = array(
              'name'        => 'v_edate',
              'id'          => 'v_edate',
              'value'       => isset($v_edate)?$v_edate:''
            );
            echo form_input($data);
            ?>
           
<select name="v_ostate" id="v_ostate"> 
<option value="not3">未处理</option> 
<option value="3_4">已结</option> 
<option value="1_2">未结</option> 
<option value="5">月结</option> 
<option value="all">全部不含月结</option> 
</select>
<input type="hidden" name="h_ostate" value="<?php echo (isset($v_ostate)) ? $v_ostate : '' ;?>" id="h_ostate" />
<?php echo form_submit('mysubmit', '确定')?>
<?php echo form_close()?>
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号</th>
                 <th>订单号</th>
                 <th>送货日期<a href="<?php echo current_url() . $uri_str . '&sort=' . ($sort=="otime_desc"?"otime_asc":"otime_desc")?>">排序</a></th>
                 <th>客户名称<a href="<?php echo current_url().$uri_str . '&sort='.($sort=="cname_desc"?"cname_asc":"cname_desc")?>">排序</a></th>
                 <th><a href="<?php echo current_url().$uri_str . '&sort='.($sort=="total_desc"?"total_asc":"total_desc")?>">合计金额</a></th>
                 <th>结单状态</th>
                 <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $_total= 0;
            $i = 1;
            $yishou = 0;
            ?>
            <?php if(isset ($item_list)):?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><?php echo $i; $i++;?></td>
                    <td><?php echo $item->oid;?></td>
                    <td><?php echo $item->otime;?></td>
                    <td><?php echo $item->cname;?></td>
                    <td><?php echo number_format($item->ptotal,2); $_total+=$item->ptotal;?></td>
                    <td><?php 
                    	switch ($item->order_state){
							case 1:
								echo "<label class='red'>现金未付</label>";
								break;  
							case 2:
								echo "<label class='red'>支付宝未付</label>";
								break;
							case 3:
							  	echo "<label class='green'>现金已结</label>";
							  	$yishou += $item->ptotal;
								break;
							case 4:
								echo "<label class='green'>支付宝已结</label>";
								break;
								case 5:
									echo "<label class='green'>月结未付</label>";
									break;
							default:
							  echo "<label class='red'>未处理</label>";
							}?>
						</td>
                        <td><a href="<?php echo base_url() ?>order/showinfo/<?php echo $item->oid; ?>">查看</a><a href="<?php echo base_url() ?>order/modi/<?php echo $item->oid; ?>">修改</a> | <a href="<?php echo base_url() ?>order/delebyoid/<?php echo $item->oid; ?>" onclick="return confirm('您确定要删除当前选项吗?该操作不可恢复！')">删除</a>
                            <br/><a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/3/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>" ><label class="green">现金已结清</label></a>
                            | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/4/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>" ><label class="green">支付宝已结清</label></a>
                            <br/><a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/1/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>"  ><label class="red">现金未结</label></a>
                            | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/2/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>"  > <label class="red">支付宝未结</label></a>
                            | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/5/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>"  > <label class="red">月结未付</label></a>
                            | <a href="<?php echo base_url() ?>order/update_order_state/<?php echo $item->oid; ?>/0/<?php echo $uri_str.(isset($sort)?"&sort=".$sort:"");?>" > <label class="red">未处理</label></a>
                        </td>
                        </tr>
        				<?php endforeach;?>
        		</tbody>
        		<?php endif;?>
        <tfoot>
            <tr>
                <th colspan="7">现金已结：<?php echo number_format($yishou,2);?>
                      合计:<?php echo number_format($_total,2);?>
                </th>
            </tr>
        </tfoot>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
