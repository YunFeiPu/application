<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
    
    <style type="text/css">
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
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
			</script>
    
    <script type="text/javascript">
   

	$(function(){
	    var inprice = $("#txtinprice"),
	    price = $("#txtprice"),
	    sdate = $("#v_sdate"),
	    allFields = $( [] ).add( inprice ).add(price).add(sdate),
	      dateRegex = /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/,
	      tips = $( ".validateTips" );
	    function updateTips( t ) {
	        tips
	          .text( t )
	          .addClass( "ui-state-highlight" );
	        setTimeout(function() {
	          tips.removeClass( "ui-state-highlight", 1500 );
	        }, 500 );
	      }
	   
	      function checkLength( o, n, min, max ) {
	  
	        if ( o.val().length > max || o.val().length < min ) {
	          o.addClass( "ui-state-error" );
	          updateTips( n + "的长度必须 必须 " +
	            min + " 和 " + max + "位之间" );
	          return false;
	        } else {
	          return true;
	        }
	      }
	   
	      function checkRegexp( o, regexp, n ) {
	        if ( !( regexp.test( o.val() ) ) ) {
	          o.addClass( "ui-state-error" );
	          updateTips( n );
	          return false;
	        } else {
	          return true;
	        }
	      }

	      function checkPrice(o,s,n){
			if(o.val()<=s.val()){
				o.addClass( "ui-state-error" );
				updateIips( n );
				return false;
			} else {
				return true;
			}
		  }
	    
		function init(){
			$("#txtpid").val($("#lblpid").html());
			$("#txtpname").val($("#v_pname").val());
			$("#txtinprice").val($("#v_pprice").val());
			$("#txtprice").val($("#v_sprice").val());
			$(".sa:text").focus(function(){
				  this.select();
			});
			if($(".groupprice").length>0){
			$(".groupprice").each(function(){
				$(this).val($(this).parent().prev().html());
			});
			}
			$("#txtinprice").focus();
			$("#txtinprice").select();
		}

		function update_data(){
		        var valid = true;
		        allFields.removeClass( "ui-state-error" );
		   
		        valid = valid && checkLength( inprice, "进货价格", 1, 7 );
		        valid = valid && checkLength( price, "批发价格", 1, 7 );
		        valid = valid && checkLength( sdate, "生效日期", 1, 10 );
		        
		        valid = valid && checkRegexp( inprice, /^(0|[1-9][0-9]{0,4})(\.[0-9]{1,2})?$/, "价格的格式不正确" );	   
		        valid = valid && checkRegexp( price, /^(0|[1-9][0-9]{0,4})(\.[0-9]{1,2})?$/, "价格的格式不正确" );	   
		        valid = valid && checkRegexp( sdate, dateRegex, "日期的格式不正确" );	   
		        var strGroupPrice = "[";
				if($(".groupprice").length>0){
		
					for(i = 0 ; i< $(".groupprice").length; i++){
						groupprice = $($(".groupprice")[i]);
						valid = valid && checkLength( groupprice, "用户组价格", 1, 7 );
						valid = valid && checkRegexp(  groupprice, /^(0|[1-9][0-9]{0,4})(\.[0-9]{1,2})?$/, "价格的格式不正确" );	 
						valid = valid && checkPrice( groupprice, inprice, "用户组价格不能小于等于进货价" );
						if(i>0){
							strGroupPrice += ",";
						}
						strGroupPrice += '{"old":'+groupprice.parent().prev().html()+
										',"new":'+groupprice.val()+
										'}';



					}
				}
				strGroupPrice +="]";
				
		        if ( valid ) {
			         
		        	var pid = $("#txtpid").val();
			         
		        	 var info = '{"pid":'+ pid	+
		        	 ',"pprice":'+ inprice.val() +
		        	 ',"sprice":' + price.val() +
		        	 ',"groupprice":' + strGroupPrice +
		        	 ',"sdate":"'  + $("#v_sdate").val() +
		        	 '"}' ;	
		        	 alert(info);
		        	var arequest = $.ajax({
		  	          url:"<?php echo base_url();?>ajax/updateproductprice",
		  	          type:"POST",
		  	          data:{data:info},
		  	          cache:false,
		  	          dataType:"html"
		  	      });
		  	      
		  	      arequest.done(function(msg){
		  	          //ajax 获取产品的单价
		  	        alert(msg);
		  	        
		  	              
		  	      }); 
		  	      arequest.fail(function( jqXHR, textStatus ) {
		  	          alert( "Request failed: " + textStatus );
		  	          });    
		  	  
		  		         
		         // dialog.dialog( "close" );
		        }
		        return valid;
		}
	    
		function open_dialog(){
			$("#dialog-modi").dialog({
				modal: true,
				height : "550",        //高度
				width : "580",        //宽度
				  buttons: [
					    {
					      text: "Ok",
					      icon: "ui-icon-heart",
					      click: function() {
					        $( this ).dialog( "close" );
					      }
					 
					      // Uncommenting the following line would hide the text,
					      // resulting in the label being used as a tooltip
					      //showText: false
					    }],
				open: function( event, ui ) {
					init();
				},
				close: function( event, ui ){
					$("#dialog-modi :text").val("");
				}
				
			});
		}
		$( "#v_sdate" ).datepicker();
		$("#modi_price").click(function(){
			open_dialog();
		});

	    $( "#update" ).on( "click", function() {
	    	update_data();
	      });
	});
    
    $(document).ready(function(){
        //$("#v_categoryid").val($("#hidden_categoryid").val());
        
        $("#labelPname").hide();
        $("#labelcategoryid").hide();
        var _index = $("#myform").attr("action").indexOf('update');
        if(_index<=0){
        var isnameexsits = true;
        $("#v_pname").blur(function(){
        if($("#v_pname").val().length>0){
        var requestobj = $.ajax({
                url: "<?php echo base_url()?>ajax/ispnameexsits",
                type: "POST",
                data: { pname : $("#v_pname").val() },
                cache: false,
                dataType: "html"
                });
                requestobj.done(function( msg ) {
                    
                  if(parseInt(msg) == 0)
                  {
                      isnameexsits = false;
                      $("#labelPname").hide();
                  }
                  else{
                      $("#labelPname").show();
                      isnameexsits = true;  
                      
                  }
                });
                }
        });
        }
        
        
        $("form").submit(function(e){
            if( $("#v_categoryid").val() == 0){
                 $("#labelcategoryid").show();
                return false ;
            }
            else{
                 $("#labelcategoryid").hide();
                 if(_index<=0){
                   if(isnameexsits)
                   {
                       return false;
                   }
                   else{
                       return true;
                   }
               }
               else{
                   return true;
               }
               
            }
        });
    });
    </script>

</head>
<body>
<div id="dialog-modi" style="display: none;" title="添加产品">
<p class="validateTips">所有的的值不能为空</p>
		<table>
			<tr>
				<td>编号</td>
				<td><input id="txtpid" class="text ui-widget-content ui-corner-all" type="text" tabindex="-1" readonly></input></td>
			</tr>
			<tr>
				<td>产品名称</td>
				<td><input id="txtpname" type="text" class="text ui-widget-content ui-corner-all" tabindex="-1" readonly></input></td>
			</tr>
			
			<tr>
				<td>进价</td>
				<td><input id="txtinprice" class="sa text ui-widget-content ui-corner-all" type="text" ></input></td>
			</tr>
			<tr>
				<td>正常批发价格</td>
				<td><input id="txtprice" class="sa text ui-widget-content ui-corner-all" type="text" ></input></td>
			</tr>
			<tr>
				<td>开始生效日期</td>
				<td><?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($date)?$date:''
            );
            echo form_input($data);
            ?></td>
			</tr>
		</table>
<table width="100%" class="TR_MOUSEOVER" id="tblprice">
		<caption>订单列表</caption>
		<thead>
			<tr>
				<th>编号</th>
				<th>产品名称</th>
				<th>价格</th>
				<td>修改价格</td>
			</tr>
		</thead>

		<tbody>
        
            <?php $total = 0;$qty = 0 ; $index = 1; $beizhu = "";?>
           <?php if(isset($item_list)) :?>
            
           <?php foreach ($item_list as $item)://custom_list?>
                <tr>
				<td><?php echo $index;$index++;?></td>
				<td id="<?php echo $item->productid;?>"><?php echo $product->pname;?></td>
				<td><?php echo $item->price?></td>
				<td><input type="text" class="groupprice sa text ui-widget-content ui-corner-all" value="<?php echo $item->price?>" /></td>
			</tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
		<tfoot>
			<tr>
				<th><input type="button" id="update" value="保存" /></th>
			</tr>
		</tfoot>
	</table>

	</div>

<div id="container">
    <h1><?php if(isset($product)){echo "编辑";}else{echo "添加";}?>产品</h1>

	<div id="body">            
            <?php
                      
            if(isset($product))
            {
                $attributes = array( 'id' => 'myform');
                echo form_open('product/update',$attributes);
            }
            else {
                $attributes = array( 'id' => 'myform');
                echo form_open('product/insert',$attributes); 
                
            }?>
		<p>产品名称<label id="lblpid" style="display: none;" ><?php echo isset($product)?$product->id:0 ;?></label>    <?php
                $data = array(
              'name'        => 'v_pname',
              'id'          => 'v_pname',
              'value'       => isset($product)?$product->pname:''
            );
                echo form_input($data);
                ?><label id="labelPname" style="color: red; ">该用名称已经存在</label></p>
                <p>产品名称拼音缩写    <?php
                $data = array(
              'name'        => 'v_py',
              'id'          => 'v_py',
              'value'       => isset($product)?$product->py:''
            );
                echo form_input($data);
                ?><input type="button" value="获取拼音" name="getpy" id="getpy"></p>
                <p>产品类别
                <?php
                $js = 'id="v_categoryid"';
            echo form_dropdown('v_categoryid',$category_list,isset($product)?$product->categoryid:'0',$js);
                echo form_hidden('hidden_categoryid',isset($product)?$product->categoryid:'0','hidden_categoryid');
                ?><label id="labelcategoryid" style="color: red; ">请选择产品所属类别</label>
            <input type="hidden" id="v_pbak1" name="v_pbak1" value="" />
</p>
                <p>产品规格    <?php
                $data = array(
              'name'        => 'v_pset',
              'id'          => 'v_pset',
              'value'       => isset($product)?$product->pset:''
            );
                echo form_input($data);
                ?></p>
               <p>整箱数量    <?php
                $data = array(
              'name'        => 'v_setqty',
              'id'          => 'v_setqty',
              'value'       => isset($product)?$product->setqty:''
            );
                echo form_input($data);
                ?></p>
            <p>进货价格    <?php
                $data = array(
              'name'        => 'v_pprice',
              'id'          => 'v_pprice',
              'value'       => isset($product)?$product->pprice:''
            );
                echo form_input($data);
                ?><input id="modi_price" type="button" value="调整价格"></input></p>
                <p>批发价格    <?php
                $data = array(
              'name'        => 'v_sprice',
              'id'          => 'v_sprice',
              'value'       => isset($product)?$product->sprice:''
            );
                echo form_input($data);
                ?></p>
                <p>建议零售价    <?php
                $data = array(
              'name'        => 'v_rprice',
              'id'          => 'v_rprice',
              'value'       => isset($product)?$product->rprice:''
            );
                echo form_input($data);
                ?></p>
                <p>整箱批发价格    <?php
                $data = array(
              'name'        => 'v_setprice',
              'id'          => 'v_setprice',
              'value'       => isset($product)?$product->setprice:''
            );
                echo form_input($data);
                ?></p>
            <?php if(isset($product))
            {
                echo form_hidden('id',$product->id);
            } ?>
            <?php echo form_submit('mysubmit', '确定')?>
                <?php echo form_close()?>
	</div>
	
<h3>目前系统中在售价格</h3>
<table width="100%" class="TR_MOUSEOVER   TOGGLE" id="tbl">
		<caption>订单列表</caption>
		<thead>
			<tr>
				<th>编号</th>
				<th>产品名称</th>
				<th>价格</th>
			</tr>
		</thead>

		<tbody>
        
            <?php $total = 0;$qty = 0 ; $index = 1; $beizhu = "";?>
           <?php if(isset($item_list)) :?>
            
           <?php foreach ($item_list as $item)://custom_list?>
                <tr>
				<td><?php echo $index;$index++;?></td>
				<td id="<?php echo $item->productid;?>"><?php echo $product->pname;?></td>
				<td><?php echo $item->price?></td>
			</tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
		<tfoot>
			<tr>
				<th colspan="3"><label id="lbltqty"><?php echo  $qty ;?></label></th>
				<th colspan="2"><label id="lbltotal"><?php echo  $total ;?></label>
				</th>
				<th><label id="lblbak"><?php echo $beizhu;?></label></th>
			</tr>
		</tfoot>
	</table>
	<p class="footer">
		Page rendered in <strong>{elapsed_time}</strong> seconds
	</p>


</body>
</html>