<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>

<script>
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
			if(pname.length>0 ){
				self.location='<?php echo base_url()?>product/groupprice/'+pname;
			}
		});
		
		$("#btnDoit").click(function(){
			//添加一个弹窗，输入价格，修改所有的组别产品的价格！提交到数据库
			var i = 0;
			$("input:checkbox").each(function () {  
            		if(this.checked){
            			i++;
            		}   
         	});
         	var price = $("#price").val();
         	var reg = new RegExp("^(0|[1-9][0-9]{0,9})(\.[0-9]{1,2})?$");
    		if(!reg.test(price)){
				alert("要修改的价格格式不正确");
    			return false;
    		}
         	if(i>0){
         	$("#form1").submit();
         	}
         	else{
         		alert('您没有选择要修改的组别');
         	}
		});
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

     
     </script>

</head>
<body>

<form action="<?php echo base_url(); ?>product/modigroupprice" id="form1" method="post">
	<div id="dialog-productsearch" class="dialog" title="按产品查订单" >

		<table>
			<tr>
				<td>产品名称</td>
				<td><input id="txtpname" name="txtpname" type="text" value="<?php echo isset($pname)? $pname:'' ?>"></input></td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" id="btnSearchOrder" value="查询订单"></input></td>
			</tr>
		</table>

	</div>
	
	
		<input id="price" name="price" type="text" /><input id="btnDoit" type="button" value="批量修改" />
	<table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号 <input id="btnselectall" type="button" value="全选"/>
                  <input id="btnunselectall" type="button" value="全不选" />
    <input id="btnInvert" type="button" value="反选" /></th>
                 <th>编号</th>
                 <th>组名</th>
                 <th>价格</th>
            </tr>
        </thead>
        
        <tbody>

            <?php $_qtytotal= 0;
            $i = 1;
           ?>
            <?php if(isset ($item_list)):?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><input name="select_item[]" type="checkbox" value="<?php echo $item->id;?>"  /><?php echo $i; $i++;?></td>
                    <td><?php echo $item->id;?></td>
                    <td><?php echo $item->groupname;?></td>
                    <td><?php echo $item->price;?></td>
                    
                    
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
	  
</form>
	<p class="footer">
		Page rendered in <strong>{elapsed_time}</strong> seconds
	</p>
</body>
</html>