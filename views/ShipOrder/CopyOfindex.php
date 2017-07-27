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
</script>
        
</head>
<body>
<h3>管理</h3>
    <?php echo form_open('shiporder/index'); ?>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_date',
              'id'          => 'v_date',
              'value'       => isset($v_date)?$v_date:date('Y-m-').(date('d')+1)
            );
            echo form_input($data);
            ?>  
	<?php echo form_submit('mysubmit', '确定')?>
    <?php echo form_close()?>
    
<a href="<?php  ?>0">未处理</a> | <a href="<?php  ?>3_4">已结</a> | <a href="<?php  ?>1_2">未结</a>
 | <a href="<?php  ?>5">月结未付</a>
  | <a href="<?php  ?>all">全部不含月结</a>


    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号</th><th>订单号</th><th>送货日期 </th><th>客户名称</th><th>合计金额</th><th>分配状态</th><th>结单状态</th><th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $_total= 0;
            $i = 1;
            $yishou = 0;
            ?>
            <?php if(isset ($item_list)):?>
            
            
        </tbody>

        <tfoot>
            <tr>
                

                </th>
            </tr>
        </tfoot>
                <?php endif;?>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
