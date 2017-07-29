<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}

a:visited {
	text-decoration: none;
	border-bottom: 0px;
}

a:hover {
	text-decoration: none;
	border-bottom: 0px;
	backgroud-color: #fff;
}

a:active {
	text-decoration: none;
	border-bottom: 0px;
	backgroud-color: #fff;
}

a.caozuo {
	border-bottom: 0px;
	display: inline-block;
	text-align: center;
	width: 50px;
}
-->
</style>
<script type="text/javascript">



</script>


<script>
/** 正则判断价格
 * @param {type} price
 * @returns {Boolean}
 */
function checkprice(price){
    var patt2 = new RegExp(/^\d+(.[0-9]{1,2})?$/);
    return patt2.test(price);
}

/**
 * 正则判断数量
 * @param {type} qty
 * @returns {Boolean}
 */
function checkqty(qty){
    var patt1 = new RegExp(/^-?\d+$/);
    return patt1.test(qty);
}

 //js方法 
 //返回重复项的Index，-1为不重复；
 function pnameExsitIndex(pname){
 	
 	$a = $("#tbl tbody tr").toArray();
     for(var $i=0;$i<$a.length;$i++){
 	  	$b = $($a[$i]).find("td").toArray();
 	  	//alert($b[1].innerHTML);
 	  	if($b[1].innerHTML == pname){
 			return  $i;
 		}
     }
     return -1;
 }

	 /**
	   * 根据产品的名称获取产品的信息
	   * @param pname
	   * 
	   */
	  function getproductbypname(pname){
		  //alert("function getproductbypname");
	  	var arequest = $.ajax({
	          url:"<?php echo base_url();?>ajax/getproductbyname",
	          type:"POST",
	          data:{description:pname},
	          cache:false,
	          dataType:"html"
	      });
	      
	      arequest.done(function(msg){
	          //ajax 获取产品的单价
	        
	  		var obj = eval ("(" + msg+ ")");
	      
	         // $("#txtpset").val(obj.pset);
	         $("#txtpname").val(obj.pname);
					        $("#txtpset").val(obj.pid);
					        $("#txtprice").val(obj.pprice);
					        $("#txtqty").val(1);
					        $("#txttotal").val(parseFloat(obj.pprice));
					       // $("#hidden_cindex").val($(_t).find("td")[0].innerHTML);

	              
	          }); 
	      arequest.fail(function( jqXHR, textStatus ) {
	          alert( "Request failed: " + textStatus );
	          });    
	  }

	  function cleardialog(){
	        $("#txtpname").val("");
	        $("#txtpset").val("");
	        $("#txtprice").val("");
	        $("#txtqty").val("");
	        $("#txttotal").val("");
	 }

	//在添加或者删除或者修改的时候改动对应的html内容
	//state add|modi|del index 行数，objitem数据
	function moditableitemhtml(state,index,objitem){
		switch(state)
		{
		case "add":
		  log("在最后一行插入新的 line 127")
		  var itemcount = $("#tbl tbody tr").length;
	
		  $("#tbl tbody").append($("#tbl tbody tr:eq(0)").clone());
		  var l = "#tbl tbody tr:eq("+itemcount+")";
		  var note = $(l).children();
		  note.eq(0).html(parseInt(itemcount+1));
		  note.eq(0).attr("id",objitem.ghd_mx_id);
		  note.eq(1).html(objitem.pname);
		  note.eq(1).attr("id",objitem.p_id);
		  note.eq(2).html(objitem.p_qty);
		  note.eq(3).html(objitem.ghd_inprice);
		  note.eq(4).html(objitem.ghd_mx_heji);
		  note.eq(5).html(objitem.ghd_mx_beizhu);
		  note.eq(6).find(".shidao").on("click",function(){
			  $a = $($(this).parent().parent()).find("td").toArray();//找到代码，dom读取数据 
		        $cindex = ($a[0].innerHTML);
		        $("#hidden_cindex").val($cindex);
		        $("#txtpname").val($a[1].innerHTML);
		        $("#txtpset").val($($a[1]).attr("id"));
		        $("#txtprice").val($a[3].innerHTML);
		        $("#txtqty").val($a[2].innerHTML);
		        $("#txttotal").val($a[4].innerHTML);

				opendialog(); 
			});

		  
		  //alert($(l).children().eq(0).html());
		  break;
		case "modi":
		  //在当前行修改
		  break;
		case "del":
			//去掉当前行
			break;
		default:
		  //
		}
	}
	
	//添加新的项目
	//不可能出现相同的项目已经在修改中做掉了
	  function addnewitem(){
		  //添加产品
		  			  var _id =0;
		      var _pName = $("#txtpname").val(); //产品名称
		      var _price = $("#txtprice").val();
		      var _qty = $("#txtqty").val();
		      var _total = $("#txttotal").val();
		      var _id_gys = $("#id_gys").html();
				var _date = $("#ghd_date").html();
				var _pid =0;

	      
	      var info = '{"ghd_id":"<?php echo $ghd_id?>","ghd_mx_id":"'+ _id +'","p_qty":"' + _qty +'","ghd_inprice":"' + _price +'","ghd_date":"'  + _date+'","p_id":"'  + _pid+'","pname":"' + _pName + '","id_gys":"' + _id_gys +'"}' ;	     

			log("line 139 :addnewitem"+info);
	       var _updateRequest = $.ajax({
	               url: "<?php echo base_url(); ?>gonghuodan/updatemx",
	               type: "POST",
	               data: { item : info},
	               cache: false,
	               dataType: "html"
	               });
	       
	        _updateRequest.done(function( msg ) {
	        	var abc = eval('(' + msg + ')');
	        	log(abc.ghd_mx_id);
	        	moditableitemhtml("add",0,abc)
	     	   $("#dialog-editqty").dialog('close');
	     	   cleardialog();
	     	   $("#hidden_cindex").val("");
	       });
	      
	      
	      countTotal();
	      countQty();
	    
		}

		//重新计算总价
	  function countTotal(){
	  	    var total = 0.00;
	  	  	$("#tbl tbody tr").each(function(){
		  	  	total = total + parseFloat($(this).children("td:eq(4)").html());
		  	  })
	  	    $("#lbltotal").html(total.toFixed(2));	  	
	  }

	  function countQty(){
		  var tqty = 0;
	  	  	$("#tbl tbody tr").each(function(){
	  	  	tqty = tqty + parseInt($(this).children("td:eq(2)").html());
		  	  })
	  	    $("#lbltqty").html(tqty);	  	
		}

		function opendialog(){
			$("#dialog-modiqty").dialog({
				modal: true,
				height : "550",        //高度
				width : "580",        //宽度
				buttons: {
					Ok: function() {                    
				    	$( this ).dialog( "close" );
				    }
				},
				open: function( event, ui ) {
					$("#txtpsearch").val("");
				    $("#txtqty").focus();
				    $("#txtqty").select();
				}
				
			});
		}


	function log(msg){
		window.console.log(msg);
		}


	  function btnAddOrderClick(){

		  log("func btnAddOrderClick");
		  	var pname = $("#txtpname").val();
		  	var price = $("#txtprice").val();
		  	if(pname.length<=0){
		  		//showmessage("请先选择产品！");
		  		return;
		  	}
		  	if(!checkprice($("#txtprice").val())){
		      	//showmessage('单价格式不正确');
		          return;
		      }
		      var _cindex = parseInt($("#hidden_cindex").val());
		     // log("cindex".$("#hidden_cindex").val());
		      if(_cindex === 0){  
		          //产品没有重复添加产品      
			 	addnewitem();
		          
		      }
		      else{
		          //说明是修改d品 要读取cindex 看看目前修改的哪一行
		          lineindex = _cindex-1;
		      var _t = "#tbl tbody tr:eq("+lineindex+")";
		      
			  var _id =$($(_t).find("td")[0]).attr("id");
		      var _pName = $("#txtpname").val(); //产品名称
		      var _price = $("#txtprice").val();
		      var _qty = $("#txtqty").val();
		      var _total = $("#txttotal").val();
		      var _id_gys = $("#id_gys").html();
				var _date = $("#ghd_date").html();
				var _pid =$("#txtpset").val();

			//找到要修改的那一行

			  var	p = parseFloat($("#txtprice").val());
			  $(_t).find("td")[2].innerHTML = $("#txtqty").val();
			  $(_t).find("td")[3].innerHTML = p.toFixed(2);
			  $(_t).find("td")[4].innerHTML = $("#txttotal").val();
		      
		      var info = '{"ghd_id":"<?php echo $ghd_id?>","ghd_mx_id":"'+ _id +'","p_qty":"' + _qty +'","ghd_inprice":"' + _price +'","ghd_date":"'  + _date+'","p_id":"' + _pid +'","pname":"' + _pName + '","id_gys":"' + _id_gys +'"}' ;
		     
		       var _updateRequest = $.ajax({
		               url: "<?php echo base_url(); ?>gonghuodan/updatemx",
		               type: "POST",
		               data: { item : info},
		               cache: false,
		               dataType: "html"
		               });
		       
		        _updateRequest.done(function( msg ) {
		        	var abc = eval('(' + msg + ')');
		        	 $(_t).find("td")[5].innerHTML = abc.ghd_mx_beizhu;
		     	   $("#dialog-editqty").dialog('close');
		     	   cleardialog();
		     	   $("#hidden_cindex").val("");
		       });
		      
		      
		      countTotal();
		      countQty();
		      }
		  	
		  }

	  </script>
<script type="text/javascript">
	$(function(){
		$("#txtpsearch").keydown(function(e){        //pos_keyword就是搜索框，当搜索框按下时响应事件keyup,e就是当前元素element  
			var keycode = e.which;          //keycode就是按键的编码,e当前元素element,e.which是当前的编码  
			if(keycode==13){
				log("txtkeyup");
				var c=$("#txtpsearch").val();
				if(c.length>0){
				$index = pnameExsitIndex($("#txtpsearch").val());
				if($index>=0){
					var _t = "#tbl tbody tr:eq("+$index+")";
			        $("#hidden_cindex").val(parseInt($index)+1);
			        $("#txtpname").val($(_t).find("td")[1].innerHTML);
			        $("#txtpset").val($($(_t).find("td")[1]).attr("id"));
			        $("#txtprice").val($(_t).find("td")[3].innerHTML);
			        $("#txtqty").val($(_t).find("td")[2].innerHTML);
			        $("#txttotal").val($(_t).find("td")[4].innerHTML);
				}else{
					$("#hidden_cindex").val("0");
					getproductbypname($("#txtpsearch").val());

				}
		               //如果keycode等于13就响应方法进行搜索  
					opendialog();
				}
				
			}
			e.stopPropagation(); 
		});
		$(document).keydown(function(e){
			var keycode = e.which;          //keycode就是按键的编码,e当前元素element,e.which是当前的编码  
			if(keycode==13){   
			    if((typeof $("#dialog-modiqty").dialog("isOpen")=='object') || $('#dialog-modiqty').dialog('isOpen')){  
					log("dialog opened");
					$("#btnSave").click();
			    }  
			}
		});
	});  
			    </script>
<script type="text/javascript">
	  $(function() {

		  //Start txtPrice txtqty 改动
		    $("#txtprice").blur(function(){
		        var price = parseFloat($("#txtprice").val());
		        var qty = $("#txtqty").val();
		         if(checkprice(price) && checkqty(qty)){
			        var total = parseFloat(price) * parseInt(qty);
			        $("#txttotal").val(total.toFixed(2));
		        }

		    });
		    $("#txtqty").blur(function(){
		        var price = $("#txtprice").val();
		        var qty = $("#txtqty").val();
		        if(checkprice(price) && checkqty(qty)){
			        var total = parseFloat(price) * parseInt(qty);
			        $("#txttotal").val(total.toFixed(2));
		        }
		    });

		    $("#btnSave").click(function(){
		    				var price = $("#txtprice").val();
					        var qty = $("#txtqty").val();

					        if(!checkprice(price)){

					            $("#txtprice").focus();
					            return;
					        }

		    				if (!checkqty(qty)){
	
					            $("#txtqty").focus();
					            return;
		    				}
		    				else{
		    					 var total = parseFloat(price) * parseInt(qty);
					        	$("#txttotal").val(total.toFixed(2));
		    				}

		    	btnAddOrderClick();
		   

		    	$("#dialog-modiqty").dialog("close");
		    	$("#txtpsearch").focus();

		    }); 
		     
		    



		    
		    
			$('.shidao').on("click",function(){
				//*
				 	$a = $($(this).parent().parent()).find("td").toArray();//找到代码，dom读取数据 
			        $cindex = ($a[0].innerHTML);
			        $("#hidden_cindex").val($cindex);
			        $("#txtpname").val($a[1].innerHTML);
			        $("#txtpset").val($($a[1]).attr("id"));
			        $("#txtprice").val($a[3].innerHTML);
			        $("#txtqty").val($a[2].innerHTML);
			        $("#txttotal").val($a[4].innerHTML);

					opendialog(); 

				});
			});

<?php //快速搜索产品栏代码?>
			$(function() {
			 
			    var availableTags = [
			        <?php $_ii =0;?>
			      <?php foreach($product_list as $item) :?>
			       <?php
										
if ($_ii > 0) {
											echo ',';
										}
										?>
			   '<?php echo $item->pname;$_ii++; ?>'
			    <?php endforeach;?>
			    ];
			    $( "#txtpsearch" ).autocomplete({
			    	source: availableTags,
			    	close: function( event, ui ) {
									    	  
					}
			  });
			});
		


</script>


</head>
<body>
	<div id="dialog-modiqty" style="display: none;" title="添加产品">
		<table>
			<tr>
				<td>编号</td>
				<td><input id="txtpset" type="text"></input></td>
			</tr>
			<tr>
				<td>产品名称</td>
				<td><input id="txtpname" type="text"></input></td>
			</tr>

			<tr>
				<td>单价</td>
				<td><input id="txtprice" type="text" tabindex="2"></input></td>
			</tr>
			<tr>
				<td>数量</td>
				<td><input id="txtqty" type="text" tabindex="1"></input></td>
			</tr>
			<tr>
				<td>合计</td>
				<td><input id="txttotal" type="text"></input></td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" id="btnSave" value="保存修改"
					tabindex="3"></input></td>
			</tr>
		</table>

	</div>
	<h3>查看供货单</h3>

	<p><?php if(isset($item_list)) :?>
            
        <?php foreach ($item_list as $item)://custom_list?>
                商户：<label id="gys_name"
			style="display: inline-block; padding-left: 10px; padding-right: 40px;"><?php echo $item->gys_name?></label>日期：<label
			style="display: inline-block; padding-left: 10px;" id="ghd_date"><?php echo $item->ghd_date?></label><label
			id="id_gys" style="display: none;"><?php echo $item->id_gys?></label>
                <?php break;?>
        <?php endforeach;?>
    <?php endif;?></p>	
    
        <?php
								
$data = array (
										'name' => 'txtpsearch',
										'id' => 'txtpsearch',
										'value' => '' 
								);
								echo form_input ( $data );
								?>
    <table width="100%" class="TR_MOUSEOVER   TOGGLE" id="tbl">
		<caption>订单列表</caption>
		<thead>
			<tr>
				<th>编号</th>
				<th>商品名称</th>
				<th>数量</th>
				<th>单价</th>
				<th>小计</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
        
            <?php $total = 0;$qty = 0 ; $index = 1; $beizhu = "";?>
           <?php if(isset($item_list)) :?>
            
           <?php foreach ($item_list as $item)://custom_list?>
                <tr>
				<td id="<?php echo $item->ghd_mx_id;?>"><?php echo $index;$index++;?></td>
				<td id="<?php echo $item->p_id;?>"><?php echo $item->pname;?></td>
				<td><?php echo $item->p_qty;$qty += $item->p_qty?></td>
				<td><?php echo number_format($item->ghd_inprice,2);?></td>
				<td><?php echo number_format($item->ghd_mx_heji,2); $total +=$item->ghd_mx_heji; ?></td>
				<td><?php echo strlen ( $item->ghd_mx_beizhu ) > 0?'有'.$item->ghd_mx_beizhu:''?></td>
				<td><a class="caozuo"
					href="/gonghuodan/mx/<?php echo $item->ghd_id?>">查看</a><a
					class="shidao" href="#">实到</a></td>
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
			<tr>
				<th>备注:</th>
				<th style="text-align: left;" colspan="5"><textarea type="text"
						id="txtbak" style="height: 200px; width: 300px;"> </textarea></th>
			</tr>
			<tr>
				<th>应结金额</th>
				<th style="text-align: left;" colspan="5"><input type="text"
					id="txtjiesuan_jine" /><input type="button" id="btnsubmit"
					value="可以付款" /></th>
			</tr>
		</tfoot>
	</table>
	<input type="input" id="hidden_index" name="hidden_index" value="0" />
	<input type="input" id="hidden_cindex" name="hidden_cindex" value="" />
	
	<br />
	<input type="input" id="hidden_ghd_id" name="hidden_ghd_id" value="<?php echo $ghd_id?>" />
	<p class="footer">
		Page rendered in <strong>{elapsed_time}</strong> seconds
	</p>
</body>
</html>
