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
        $("#gys_list").val('<?php echo isset($gys_name)?$gys_name:""?>');
        $("#gys_list").change(function(){
        	 var pname = encodeURIComponent($("#gys_list").val());
	         var orderdate = encodeURIComponent($("#otime").val());
        	 if(pname.length>0){
        		 if(orderdate.length>0){
 	    	   		self.location='<?php echo base_url()?>mobile/checkjinhuodan/'+orderdate+'/'+pname;
 	           }
             }
        }); 
      });
    
   

	$(function(){
	       $("#btnSearchOrder").click(function(){
	           var pname = encodeURIComponent($("#gys_list").val());
	           var orderdate = encodeURIComponent($("#otime").val());
	           if(orderdate.length>0){
	    	   		self.location='<?php echo base_url()?>mobile/checkjinhuodan/'+orderdate+'/'+pname;
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
      

      <p class="intro"><input name="account" id="otime" class="form-control" placeholder="请输入订单日期" value="<?php echo isset($order_date)?$order_date:""?>" />
      	<select class="form-control" id="gys_list">
      	<option value="">请选择</option>
      	 <?php if(isset ($gys_list)):?>
            <?php foreach ($gys_list as $item)://custom_list?>
					<option value ="<?php echo $item->description;?>"><?php echo $item->description;?></option>
			<?php endforeach;?>
        <?php endif;?>
		</select>
      	<button class="btn btn-lg btn-primary btn-block" id= "btnSearchOrder" type="button" onclick="loginSign(this);">查询</button>
      </p>   
      <table width="100%">
        <caption>
           <?php echo isset($order_date)?$order_date:"的"?>   <?php echo isset($gys_name)?$gys_name:"列表"?></caption>
        <thead>
            <tr>
                 <th>序号</th>
                 <th>产品名称</th><th>数量</th>
                 
            </tr>
        </thead>
        
        <tbody>

            <?php
            $i = 1;
           ?>
            <?php if(isset ($item_list)):?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><?php echo $i; $i++;?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->qty;?></td>
                   
                    
                        </tr>
        				<?php endforeach;?>
        		</tbody>
        		<?php endif;?>
        <tfoot>
            <tr>
                <th colspan="3" >
                
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
