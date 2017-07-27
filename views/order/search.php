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
	//初始化 
     $(function(){
       $( "#v_sdate" ).datepicker();
     });

     $(function() {
    	    var availableTags = [
    	      <?php $_ii =0;?>
    	      <?php foreach($product_list as $item) :?>
    	       <?php		if($_ii>0){
    	                      echo ',';
    	                  } ?>
    	   '<?php echo $item->pname;$_ii++; ?>'
    	    <?php endforeach;?>
    	    ];
    	    $( "#txtpname" ).autocomplete({
    	      source: availableTags,
    	      close: function( event, ui ) {
    	    	 
    				}
    	    });
    	  });


     $(function(){
		//按产品查询订单
       $("#btnSearchOrder").click(function(){
           var pname = encodeURIComponent($("#txtpname").val());
           var orderdate = encodeURIComponent($("#v_sdate").val());
           if(pname.length>0 && orderdate.length>0){
    	   		self.location='<?php echo base_url()?>order/search/'+pname+'/'+orderdate;
           }
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

       

     });


     
     </script>

</head>
<body>


	<div id="dialog-productsearch" class="dialog" title="按产品查订单" >
<?php echo form_open('order/search'); ?>
		<table>
			<tr>
				<td>产品名称</td>
				<td><input id="txtpname" type="text"></input><a
					id="selectpro" href="#">选择产品</a></td>
			</tr>
			<tr>
				<td>开始日期</td>
				<td><input id="v_sdate" type="text" readonly value="<?php echo $order_date ; ?>"></input></td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" id="btnSearchOrder" value="查询订单"></input></td>
			</tr>
		</table>
<?php echo form_close();?>
	</div>
	
	<form action="<?php echo base_url(); ?>order/dele_item" method="post" onsubmit="return confirm('数据一旦删除不可恢复，您确定要删除吗？')">
	<table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号 <input id="btnselectall" type="button" value="全选"/>
                  <input id="btnunselectall" type="button" value="全不选" />
    <input id="btnInvert" type="button" value="反选" /></th>
                 <th>订单号</th>
                 <th>送货日期</th>
                 <th>客户名称</th><th>数量</th>
                 <th>单价</th><th>合计</th>
            </tr>
        </thead>
        
        <tbody>

            <?php $_qtytotal= 0;
            $i = 1;
           ?>
            <?php if(isset ($item_list)):?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><input name="order_item[]" type="checkbox" value="<?php echo $item->idorder;?>"  /><?php echo $i; $i++;?></td>
                    <td><?php echo $item->oid;?></td>
                    <td><?php echo $item->otime;?></td>
                    <td><?php echo $item->cname;?></td>
                    <td><?php echo $item->qty;$_qtytotal += $item->qty;?></td>
                    <td><?php echo $item->pprice;?></td>
                    <td><?php echo $item->ptotal;?></td>
                    
                        </tr>
        				<?php endforeach;?>
        		</tbody>
        		<?php endif;?>
        <tfoot>
            <tr>
                <th colspan="7" >
                合计数量 ： <?php echo $_qtytotal;?>
                </th>
            </tr>
        </tfoot>
    </table>
	  <input name="submit" type="submit" value="删除选中的产品" />
</form>
	<p class="footer">
		Page rendered in <strong>{elapsed_time}</strong> seconds
	</p>
</body>
</html>