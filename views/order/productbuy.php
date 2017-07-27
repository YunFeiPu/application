<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="../css/global.css" type="text/css"
        media="all" />
    <link href="../css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="../scripts/global.js"></script>
    
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
            $( "#btnSubmit" ).click(function(){
                window.location.href = "./productbuy/"+$( "#v_sdate" ).val();
            });
            
        });
        </script>

</head>
<body>
    <h3>查看订货单</h3>
    <?php echo form_open('order/productbuy'); ?>
   请选择配送日期<?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($otime)?$otime:''
            );
            echo form_input($data);
            ?>            <?php echo form_submit('mysubmit', '确定')?>
                <?php echo form_close()?>
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>产品类别</th><th>产品名称</th><th>订购数量 </th><th>单价</th><th>小计</th><th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $total = 0;?>
           <?php if(isset($product_list)) :?>
            
           <?php foreach ($product_list as $item)://custom_list?>
                <tr>
                    <td><?php echo $item->description;?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->qty;?></td>
                    
                    <td><?php echo number_format($item->pprice,2);?></td>
                    <td><?php $total += $item->qty * $item->pprice;
                    echo  number_format(($item->qty * $item->pprice),2);?></td>
                    
                </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">
                    <?php echo  $total ;?>
                </th>
            </tr>
        </tfoot>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
