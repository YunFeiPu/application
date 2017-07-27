<!DOCTYPE html>
<html lang="en">
  <head>

    <?php $this->load->view('mobile/head_template'); ?>
    <link href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>
    
	<script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>



    <style type="text/css">
    table 
{ 
border-collapse: collapse; 
border: none; 
} 
td 
{ 
border: solid #000 1px; 
} 
    	.form-control {
    		font-size: 16px;
    	}
    	.btn {
    		display:inline-block;
	margin:0 10px;
	width:200px;
	height:50px;
	line-height:50px;
	color:#fff;
	background-color:#337ab7;
	border-radius:6px;
    	}
    </style>
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

    $(function(){
        $( "#otime" ).datepicker();
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
	       $("#btnSearchOrder").click(function(){
	           var pname = encodeURIComponent($("#txtpname").val());
	           var orderdate = encodeURIComponent($("#otime").val());
	           if(pname.length>0 && orderdate.length>0){
	    	   		self.location='<?php echo base_url()?>mobile/checkorder/'+pname+'/'+orderdate;
	           }
	       });
		});
	  
    </script>
  </head>
  <body>
  <div role="navigation" id="foo" class="nav-collapse">
	<?php $this->load->view('mobile/menu'); ?>
  </div>

    <div role="main" class="main">
      <a href="#nav" class="nav-toggle"></a>
      

      <p class="intro"><input name="account" id="txtpname" class="form-control" placeholder="请输入产品名称" required autofocus/>
      	<input name="account" id="otime" class="form-control" placeholder="请输入订单日期" value="<?php echo isset($order_date)?$order_date:""?>" />
      	
      	<button class="btn btn-lg btn-primary btn-block" id= "btnSearchOrder" type="button" onclick="loginSign(this);">查询</button>
      </p>   
      <table width="100%">
        <caption>
           <?php echo isset($list_date)?$list_date:"的"?>   <?php echo isset($list_pname)?$list_pname:"列表"?></caption>
        <thead>
            <tr>
                 <th>序号</th>
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
                <td><?php echo $i; $i++;?></td>
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
                <th colspan="6" >
                合计数量 ： <?php echo $_qtytotal;?>
                </th>
            </tr>
        </tfoot>
    </table>
          
</div>

    <script>
      var navigation = responsiveNav("foo", {customToggle: ".nav-toggle"});
    </script>
  </body>
</html>
