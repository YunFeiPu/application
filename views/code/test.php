<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>列表</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url()?>css/global.css" type="text/css"
        media="all" />
    <link href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>scripts/global.js"></script>
    
	<script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>
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
    <?php echo form_open('order/test'); ?>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($v_sdate)?$v_sdate:''
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



          <?php echo form_submit('mysubmit', '确定')?>
    <?php// echo form_close()?>
</body>
</html>
