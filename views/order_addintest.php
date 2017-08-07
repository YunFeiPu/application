<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>订单列表</title>
 <?php $this->load->view('head.php');?>
    <script src="<?php echo base_url()?>scripts/order_add_header.js?888"></script>    
 	<style type="text/css">
 		 ul{list-style:none;} 
 		 ul,li{padding:0;margin:0;}
 		 a.productitem  {text-decoration:none; border:0;} 
         a.productitem a:hover {text-decoration:none;}
         a{boder:0px;}
 	</style>
        
<script>
$(function(){
	var _vpname = $("#txtpname"),
		_vpset = $("#txtpset"),
		_vprice = $("#txtprice"),
		_vqty = $("#txtqty"),
		_vtotal = $("#txttotal"),
		_vcname = $("#v_cname"),
		_vsdate = $("#v_sdate"),
		_vpsearch = $("#txtpsearch"),
		allFields1 = $( [] ).add( _vcname ).add(_vpsearch).add(_vsdate),
		allFields = $( [] ),
	    dateRegex = /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/,
	    tips1 = $( ".validateTips1" ),
	    tips = $( ".validateTips" );
	function updateTips( c,t ) {
        c
          .text( t )
          .addClass( "ui-state-highlight" );
        setTimeout(function() {
          c.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
      }
   
      function checkLength( o, n, min, max,c ) {
  
        if ( o.val().length > max || o.val().length < min ) {
          o.addClass( "ui-state-error" );
          updateTips( c,n + "的长度必须 必须 " +
            min + " 和 " + max + "位之间" );
          return false;
        } else {
          return true;
        }
      }
   
      function checkRegexp( o, regexp, n ,c) {
        if ( !( regexp.test( o.val() ) ) ) {
          o.addClass( "ui-state-error" );
          updateTips( c,n );
          return false;
        } else {
          return true;
        }
      }

      function checkPrice(o,s,n,c){
		if(o.val()<=s.val()){
			o.addClass( "ui-state-error" );
			updateIips( c,n );
			return false;
		} else {
			return true;
		}
	  }

	function _getproduct(n,c,d){
		 var info = '{"pname":"'+ n	+
    	 '","cname":"'+ c +
    	 '","sdate":"'  + d +
    	 '"}' ;	
    	 alert(info);
		var arequest = $.ajax({
	        url:"<?php echo base_url()?>ajax/getproductinfobyname",
	        type:"POST",
	        data:{ data:info },
	        cache:false,
	        dataType:"html"
	    });
	    
	    arequest.done(function(msg){
	        //ajax 获取产品的单价
	        alert(msg);
	        /*
	       	var _pprice;
	        var cname = $("#v_cname").val();
			var obj = eval ("(" + msg+ ")");
	    	
	        $("#txtpset").val(obj.pset);
	        $("#inprice").val(obj.pprice);
	        alert(obj.pset);
*/
	    });

					
	}

    var availableTags = [
        <?php $_ii =0;?>
      <?php foreach($product_list as $item) :?>
       <?php           if($_ii>0){
                      echo ',';
                  } ?>
   '<?php echo $item->pname;$_ii++; ?>'
    <?php endforeach;?>
    ];
    _vpsearch.autocomplete({
      source: availableTags,
      close: function( event, ui ) {
    	 
	    	var valid = true;
	        allFields1.removeClass( "ui-state-error" );
	   
	        valid = valid && checkLength( _vcname, "用户名", 1, 30 ,tips1 );
	        valid = valid && checkLength( _vsdate, "批发价格", 1, 10, tips1 );
	        valid = valid && checkLength( _vpsearch, "生效日期", 1, 50, tips1 );
	
	        valid = valid && checkRegexp( _vsdate, dateRegex, "日期的格式不正确", tips1 );	   
	    		 
			if(valid){
	        	$("#hidden_cindex").val("0");
	  	  		txt = _vpsearch.val();
	  	  		index = txt.indexOf(',');
	  	  		pname = txt.substr(0,index);
	  	 		// getproductbypname($pname,true);
	    	 
	    	 	_getproduct(pname,_vcname.val(),_vsdate.val());
	    		$("#txtpsearch").val('');
			}
		}
    });
	
});

/**
 * 正则检查价格格式
 * @returns {boolean}
 */
function checkprice(price){
    var patt2 = new RegExp(/^\d+(.[0-9]{1,2})?$/);
    return patt2.test(price);
}


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
	  	if($b[1].innerHTML == pname){
			return  $i;
		}
    }
    return -1;
}

//添加到订单的时候检查数据的格式
function checkFormateTotal(){
	var price = $("#txtprice").val();
    var qty = $("#txtqty").val();
	if(!checkprice(price)){
        showmessage("请输入正确的价格格式");
        return;
    }
    if(!checkqty(qty)){
        showmessage("请输入正确的数量");
        return;
    }
	
}

//重新编排Index
function countIndex(){
	$a = $("#tbl tbody tr").toArray();
	for(var $i=0;$i<$a.length;$i++){
	  	$b = $($a[$i]).find("td").toArray();
	  	$b[0].innerHTML = $i+1;
    }
}

//点击添加按钮
function btnAddOrderClick(){
	var pname = $("#txtpname").val();
	var price = $("#txtprice").val();
	if(pname.length<=0){
		showmessage("请先选择产品！");
		return;
	}
	if(!checkprice($("#txtprice").val())){
    	showmessage('单价格式不正确');
        return;
    }
    var _cindex = parseInt($("#hidden_cindex").val());
    if(_cindex === 0){  
        //添加产品      
    	if(addproducttoorderlist()){
    		selectProduct();
        }
        
    }
    else{
        //说明是修改d品

    var _pName = $("#txtpname").val(); //产品名称
    var pset = $("#txtpset").val();
    var _price = $("#txtprice").val();
    var _qty = $("#txtqty").val();
    var _total = $("#txttotal").val();
    var cindex = $("#hidden_cindex").val();
    var _cName = $("#v_cname").val();
    var _index = cindex -1;
    
    $oid = $("#tbl tbody tr").eq(_index).attr("id");
    $a = $("#tbl tbody tr:eq("+_index+") td").toArray();
    //$a = $($("#tbl tbody tr:eq("+cindex+"")").parent().parent()).find("td").toArray();//找到代码，dom读取数据 
    //alert($a[1].innerHTML);
    //
    $a[1].innerHTML = $("#txtpname").val();
    $a[2].innerHTML = $("#txtpset").val();
    $a[3].innerHTML = $("#txtprice").val();
    $a[4].innerHTML = $("#txtqty").val();
    $a[5].innerHTML = $("#txttotal").val();
    countTotal();
    countIndex();
    $("#dialog-addproduct").dialog("close");
    }
	
}



function addproducttoorderlist(){
    var index = parseInt($("#hidden_index").val())+1 ; //行编号
    $("#hidden_index").val(index);
    var pname = $("#txtpname").val();
    var pset = $("#txtpset").val();
    var price = $("#txtprice").val();
    var qty = $("#txtqty").val();
    var total = $("#txttotal").val();
    if(pnameExsitIndex(pname)>=0){        
	    showmessage("产品  [" + pname + "] 已经存在,请直接修改数量！");
	    return false;
    }
    else{
    	$("#tbl tbody").append("<tr id='tr" + index + "'><td>"+index+"</td><td>"+pname+"</td><td>"+pset+"</td><td>"+price+"</td><td>"+qty+"</td><td>"+total+"</td><td><a class='proedit' href='#'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>");
	    $("#txtpname").val("");
	    $("#txtpset").val("");
	    $("#txtprice").val("");
	    $("#txtqty").val("");
	    $("#txttotal").val("");
	    countTotal();
	    countIndex();
	    return true;
    } 
}

//重新计算总价
function countTotal(){
	    $a = $("#tbl tbody tr").toArray();
	    var total =0 ;
	    total = 0.00;
	    for(var $i=0;$i<$a.length;$i++){
	  	$b = $($a[$i]).find("td").toArray();
	  	total = total + parseFloat($b[5].innerHTML);
	    }
	    $("#lbltotal").html(total);	  	
}


//检查该客户是否有订单了
function checkcustomorder(){
	var cname = $("#v_cname").val() ;
	var otime = $("#v_sdate").val() ;
	if(cname.length>0 && otime.length>0){

	var obj = '{"cname":"'+$("#v_cname").val()+'","otime":"'+$("#v_sdate").val()+'"}';
    var  arequest = $.ajax({
           url: "<?php echo base_url()?>order/checkcustom",
           type: "POST",
           data: { info : obj},
           async: false,
           cache: false,
           dataType: "html"
           });
    arequest.done(function( msg ) {
       var oid = msg;
       if(msg>0){
    	   self.location='<?php echo base_url()?>order/modi/'+msg;
       }
    });
	}
}





function getproductbypname(pname,isquick){
	var arequest = $.ajax({
        url:"<?php echo base_url()?>ajax/getproductbyname",
        type:"POST",
        data:{description:pname},
        cache:false,
        dataType:"html"
    });
    
    arequest.done(function(msg){
        //ajax 获取产品的单价
       	var _pprice;
        var cname = $("#v_cname").val();
		var obj = eval ("(" + msg+ ")");
    	
        $("#txtpset").val(obj.pset);
        $("#inprice").val(obj.pprice);
        alert(obj.pset);
        var pricerequest = $.ajax({
        url:"<?php echo base_url()?>ajax/getproductprice",
        type:"POST",
        data:{cname:cname,pname:pname},
        cache:false,
        dataType:"html"
    });

        pricerequest.done(function(msg){
            //ajax 获取产品的单价
           var obj1 = eval ("(" + msg+ ")");
           	$("#txtpname").val(pname);
           	if(obj1.price.length== 0 || parseInt( obj1.price)<= 0)
           	{
           		$("#txtprice").val('');
           	}else{
            $("#txtprice").val(obj1.price);
            }
            $("#txtqty").val("");
            $("#txttotal").val("");
            _pprice = obj1.price;
            $( "#dialog-product" ).dialog("close");
            if(checkprice(obj1.price)){
                $("#saveprice").show();
            }
            else{
                $("#saveprice").show();
            }
            
        });
        
        pricerequest.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
});
            
        $("#dialog-addproduct").dialog({
            modal: true,
            height : "550",        //高度
            width : "580",        //宽度
            close: function( event, ui ) {
            	
      		},
            buttons: {
              Ok: function() {                    
                $( this ).dialog( "close" );
              }
            },
            open: function( event, ui ) {
				$("#txtqty").focus();
				$("#txtqty").select();
            }
          });  
            
        }); 
    arequest.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
        });    
}

</script>
 	
<script type="text/javascript">
function checkproductitem(){
	
}

$(function(){
	$(document).keydown(function(event){
			if($("#dialog-addproduct").dialog('isOpen')){
				if(event.keyCode == 13){
					
					
					$("#btnAddOrder_1").click();
				}
			}
			else if(event.keyCode == 13){
				$("#txtpsearch").focus();
			}
		});
});


	<?php //快速搜索客户信息?>
     $(function() {
    var availableTags = [
        <?php $_ii =0;?>
      <?php foreach($custom_list as $item) :?>
       <?php           if($_ii>0){
                      echo ',';
                  } ?>
   '<?php echo $item->cname;$_ii++; ?>'
    <?php endforeach;?>
    ];
    $( "#v_cname" ).autocomplete({
      source: availableTags,
      close: function( event, ui ) {
    	  checkcustomorder();
			}
    });
  });


     <?php //快速搜索产品栏代码?>
    		 $(function() {

    			  });	     
    
</script>    



   
<script type="text/javascript">         
$(window).bind('beforeunload',function(){
	$a = $("#tbl tbody tr").toArray();
 if($('#v_cname').val()!='' && $a.length>0){
	return '您输入的内容尚未保存，确定离开此页面吗？';
}
});        
 </script>         
        
        

<script type="text/javascript"> 
    
<?php //点击删除按钮 删除当前项目，并且重新编号 ?>    
$(function(){
        $(document).on("click",".prodele",function(){
        if(confirm('您确定要删除当前内容吗？')){
            $a = $($(this).parent().parent()).find("td").toArray();//找到代码，dom读取数据 
            $cindex = ($a[0].innerHTML);
            var _index = parseInt($("#hidden_index").val()) - 1;
            $("#hidden_index").val(_index);
            $("#tbl tbody tr").eq($cindex-1).remove();
            var _tr_array = $("#tbl tbody tr").toArray();            
            if(_tr_array.length>0){
                var i = 1;
                for(var a=0; a<_tr_array.length; a++){
                    $bbb = $("#tbl tbody tr").eq(a).find("td").toArray();
                    $bbb[0].innerHTML = i;
                    i++;
                }
            }

            countTotal();
        }
    });
});

<?php //   //点击编辑按钮编辑当前行产品   //点击编辑按钮编辑当前行产品 ?>
$(function(){
    $(document).on("click",".proedit",function(){
        $a = $($(this).parent().parent()).find("td").toArray();//找到代码，dom读取数据 
        $cindex = ($a[0].innerHTML);
        $("#txtpname").val($a[1].innerHTML);
        $("#txtpset").val($a[2].innerHTML);
        $("#txtprice").val($a[3].innerHTML);
        $("#txtqty").val($a[4].innerHTML);
        $("#txttotal").val($a[5].innerHTML);
        $("#hidden_cindex").val($cindex);
        
        $("#dialog-addproduct").dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {                    
                    $( this ).dialog( "close" );
                  }
                }
              });
    });
});   
    
    
$(document).ready(function(){

    $("#dialog-custom").hide();    //客户列表
    $("#dialog-product").hide();   //产品列表
    $("#dialog-addproduct").hide();//添加产品列表
    $("#dialog-custom a").click(function(){
        //点击客户
        $("#v_cname").val($(this).text());
        $("#dialog-custom").dialog( "close" );
        if($("#v_sdate").val().length<=0)
        {$( "#v_sdate" ).datepicker( "show" );}
    });
    
    $( "#v_sdate" ).datepicker();  //送货日期
    $("#saveprice").click(function(){
        var price = $("#txtprice").val();
        var cname = $("#v_cname").val();
        var pname = $("#txtpname").val();
        if(!checkprice(price)){
            showmessage('请输入正确的价格格式');
            return false;
        }
        var obj = '{"cname":"'+cname+'","pname":"'+pname+'","price":"'+price+'"}';
        //alert(obj);
        var requestobj = $.ajax({
                url: "<?php echo base_url()?>ajax/insertgroupprice",
                type: "POST",
                data: { order : obj },
                cache: false,
                dataType: "html"
                });
        requestobj.done(function( msg ) {
          //alert(msg);
        });
        
    });
    
	$("#btnset_date").click(function(){
		var order_date = $( "#v_sdate" ).val();
		var request = $.ajax({
            url: "<?php echo base_url()?>config/set_order_date",
            type: "POST",
            data: { item_value : order_date },
            async: false,
            cache: false,
            dataType: "html"
            });
    request.done(function( msg ) {
    });
	});


    
    $("#btnSubmit").click(function(){
    
        var obj = '{"cname":"'+$("#v_cname").val()+'","otime":"'+$("#v_sdate").val()+'"}';
         var  arequest = $.ajax({
                url: "<?php echo base_url()?>order/checkcustom",
                type: "POST",
                data: { info : obj},
                async: false,
                cache: false,
                dataType: "html"
                });
        arequest.done(function( msg ) {
            //alert(msg);
            if(msg>0){
                showmessage('每天每个用户只能添加一个订单');
				return;
                
            }
            
             $("#dialog-submit").dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {
                    $( this ).dialog( "close" );
                  }
                }
              }); 
        var obj = '{"cname":"'+$("#v_cname").val()+'","otime":"'+$("#v_sdate").val()+'","products":[';
        var $trAry = $("#tbl tbody tr").toArray();
        
        for(var $i=0 ; $i<$trAry.length; $i++){
            var $tdAry = $($trAry[$i]).find("td").toArray();
            //alert($tdAry[1].innerHTML);
            if ($i > 0){
                obj = obj +',';
            }
            obj = obj +'{"pname":"'+$tdAry[1].innerHTML+'","pprice":"'+$tdAry[3].innerHTML+'","qty":"'+$tdAry[4].innerHTML+'","ptotal":"'+$tdAry[5].innerHTML+'"}';
        }
        obj = obj+']}';
        var j = jQuery.parseJSON(obj);
        //alert(obj);
        //alert(j.products[0].ptotal);
        var order = obj;
       
        var request = $.ajax({
                url: "<?php echo base_url()?>order/ajax_save",
                type: "POST",
                data: { order : order},
                async: false,
                cache: false,
                dataType: "html"
                });
        request.done(function( msg ) {
            $("#dialog-submit").dialog( "close" );
$(window).unbind('beforeunload');
            showmessage("订单已添加");
            checkcustomorder();
        });
            
        });
        
    
    
    
    
       
    });
    
    
    
    $('#btnCustom').click(function(){
        if($('#v_cname').val()!=''){
	        if(!confirm('您如果更换客户，订单内容将被清空！，您确定要更换客户吗？')){
	         return;
	        
	        }
             //写道这里要写换客户的代码
        }
        $("#tbl tbody").html('');
        $("#txtpname").val("");
        $("#txtpset").val("");
        $("#txtqty").val("");
        $("#txtprice").val("");
        $("#txttotal").val("");
        $( "#dialog-custom" ).dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {
                    
                    $( this ).dialog( "close" );
                  }
                }
              }); 
        
    
    
      
    });

              
    $('.txtproduct').click(function(){
        
        var index = $(this).attr("id").split('_');
        
        $( "#hidden_help" ).val(index[1]);
        
       $( "#dialog-product" ).dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {
                      $("#txtpname").val("");
                      $("#txtpset").val("");
                      $("#txtqty").val("");
                      $("#txtprice").val("");
                      $("#txttotal").val("");
                    $( this ).dialog( "close" );
                    //$( "#hiddenhelp" ).val("");
                  }
                }
              }); 
    });
    
    //点击选择产品
    $(document).on("click",".txtproduct",function(){
        //判断必须先选择客户 否则不能获取价格
       var v_cname = $("#v_cname").val();
       if(v_cname.length<=0){
           showmessage('请先选择客户');
       }else{
        var index = $(this).attr("id").split('_');
        
        $( "#hidden_help" ).val(index[1]);      
        
        $( "#dialog-product" ).dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {
                                            $("#txtpname").val("");
                      $("#txtpset").val("");
                      $("#txtqty").val("");
                      $("#txtprice").val("");
                      $("#txttotal").val("");
                    $( this ).dialog( "close" );
                    //$( "#hiddenhelp" ).val("");
                  }
                }
            });
        }
    });
    $(document).on("blur",".price",function(){
        var index = $(this).attr("id").split('_');
        var price = $("#txt_"+index[1]+"_3").val();
        var qty = $("#txt_"+index[1]+"_4").val();
        var total = price * qty;
        $("#txt_"+index[1]+"_5").val(total);
    });
    
    
    // Start 数量+号 -号点击
    $("#plus").click(function(){
    var pname = $("#txtpname").val();
    if(pname.length === 0){
        showmessage("请先选择产品");
        return;
    }
  
        
    var str =$("#txtqty").val();
    //var patt1 = new RegExp("^[1-9]+[0-9]*$");
    //if(patt1.test(str)){
    if(checkqty(str)){
        var qty = parseInt($("#txtqty").val()) + 1;
        $("#txtqty").val(qty);
        var total = $("#txtprice").val() * qty;
        $("#txttotal").val(total);
    }
    else{
        //showmessage('请输入正确的数量');
    }
    });
    
    $("#mines").click(function(){
    var pname = $("#txtpname").val();
    if(pname.length === 0){
        showmessage("请先选择产品");
        return;
    }
  
        
    var str =$("#txtqty").val();
    //var patt1 = new RegExp("^[1-9]+[0-9]*$");
    //if(patt1.test(str)){
    if(checkqty(str)){
        var qty = parseInt($("#txtqty").val());

            qty = qty - 1;
            $("#txtqty").val(qty);
            var total = $("#txtprice").val() * qty;
            $("#txttotal").val(total);

        
    }
    else{
        //showmessage('请输入正确的数量');
    }
    });
    // End 数量+号 -号点击
    
    //Start txtPrice txtqty 改动
    $("#txtprice").blur(function(){
        var price = $("#txtprice").val();
        var qty = $("#txtqty").val();
        if(!checkprice(price)){
            //showmessage("请输入正确的价格格式");
            $("#txtprice").focus();
            return;
        }
        if(qty != ""){
        if(!checkqty(qty)){
        	$("#txtqty").focus();
            //showmessage("请输入正确的数量");
            return;
        }
        
        var total = parseFloat(price) * parseInt(qty);
        $("#txttotal").val(total);
    }
    });
    $("#txtqty").blur(function(){
        var price = $("#txtprice").val();
        var qty = $("#txtqty").val();
        if(!checkprice(price)){
        	$("#txtprice").focus();
            //showmessage("请输入正确的价格格式");
            return;
        }
        if(!checkqty(qty)){
        	$("#txtqty").focus();
            //showmessage("请输入正确的数量");
            return;
        }
        
        var total = parseFloat(price) * parseInt(qty);
        $("#txttotal").val(total);
    });
     //End txtPrice  改动
    $("#btnAddOrder_1").click(function(){
    	var price = $("#txtprice").val();
			        var qty = $("#txtqty").val();

			        if(!checkprice(price)){
			            showmessage("请输入正确的价格格式");
			            $("#txtprice").focus();
			            return;
			        }
			        else if(price< parseFloat($("#inprice").val())){
			        	showmessage("您输入的价格定于建议的价格");
			        	$("#txtprice").focus();
			        	return;
			        }
    				if (!checkqty(qty)){
    					showmessage("请输入正确的数量");
			            $("#txtqty").focus();
			            return;
    				}
    				else{
    					 var total = parseFloat(price) * parseInt(qty);
			        	$("#txttotal").val(total);
    				}


    	btnAddOrderClick();
    	countTotal();
    	$("#dialog-addproduct").dialog("close");
    	$("#dialog-product").dialog("close");
    	$("#txtpsearch").focus();

    }); 
     
    $("#btnAddOrder").click(function(){
		countTotal();
    	btnAddOrderClick();
    });
    
    
    
    //添加行数
    $("#add").click(function(){
    	var cname = $("#v_cname").val();
    	var otime = $("#v_sdate").val();
    	if(cname.length<=0){
            showmessage('请先选择客户');
            $("#v_cname").focus();
            return;
        }
		if(otime.length <= 0){
			showmessage('请先选择日期');
			return;
		}

        
        $('#hidden_cindex').val("0");
        $( "#dialog-addproduct" ).dialog({
        	modal: true,
        	height : "550",        //高度
        	width : "580",        //宽度
        	buttons: {
	        	Ok: function() {
	            	$( this ).dialog( "close" );
	            }
            },
        	open: function(event,ui){ selectProduct();},
        }); 
       
        
   	});
    
    
    $("#selectpro").click(function(){
        selectProduct();
    });
    
    
    //点击选定产品 
    $(".category").click(function(){        
        var description = $(this).html();
        var request = $.ajax({
                url: "<?php echo base_url()?>ajax/getproductbydescription",
                type: "POST",
                data: { description : description},
                cache: false,
                dataType: "html"
                });
        request.done(function( msg ) {
                    $("#palproduct").html("");
                    var obj = eval ("(" + msg+ ")");
                    if(obj.length>0){
                    	$("#palproduct").append("<ul style='list-style:none;margin-bottom: 0px;list-style-type:none;'>");
                        for(i=0 ; i<obj.length;i++){
                            var _html = "<li style='list-style:none;float:left;margin:5px 10px;display:inline-block;width:200px;'><a href='#' class='productitem' >"+obj[i].pname+"</a>";
                            if(obj[i].isnew == 1){
                                _html += "<img src='<?php echo base_url()?>images/new.gif' />";
                            }
                            if(obj[i].ishot == 1){
                                _html += "<img src='<?php echo base_url()?>images/hot.gif' />";
                            }
                            _html += "</li>";

                            $("#palproduct").append(_html);
                        
                        }
                        $("#palproduct").append("</ul>");
                        $(".productitem").on("click" , function(){
                            //alert("aaa")
                            //var input = "#txt_"+$("#hidden_help").val()+"_1";
                            
                            $("#txtpname").val($( this ).html());
                            var desc = $( this ).html();
							getproductbypname(desc,false);
                        });
                        
                       // window.alert( $("#palproduct").html());
                    }
                    
                });
        request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                });
    });
    
       

    
    
    //end function
});
</script>
        
  <script>

//选择产品对话框
function selectProduct(){
	$( "#dialog-product" ).dialog({
        modal: true,
        height : "550",        //高度
        width : "640",        //宽度
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
      }); 
}
  
function showmessage(msg){
	$("#dialog-message").dialog({
        modal: true,
        height : "300",        //高度
        width : "480",        //宽度
        open:function(event,ui){
        	$("#dialog-message").html(msg);
        	setTimeout(function() {
				$("#dialog-message").dialog("close");
        	}, 1500 );
        }
      });
}


  </script>




</head>
<body>
    <h3>添加订单</h3>
<div id="dialog-message" style="display:none;" title="提示">

</div>
<div id="dialog-submit" style="display:none;" title="提交订单">
             订单提交中
</div>   
     <div id="dialog-addproduct" title="添加产品">
     
         <table>
             <tr>
                 <td>产品名称</td><td><input id="txtpname" type="text" readonly></input><a id="selectpro" href="#">选择产品</a></td>
             </tr>
             <tr>
                 <td>规格</td><td><input id="txtpset" type="text" readonly=""></input></td>
             </tr>
             <tr>
                 <td>单价</td><td><input id="txtprice" type="text" onfocus="this.select();" tabindex="1"></input><input type="button" id="saveprice" value="保存当前产品的价格到该用户组"></input><input type="hidden" id="inprice" value="" /></td>
             </tr>
             <tr>
                 <td>数量</td><td><input id="txtqty" type="text"   onfocus="this.select();" tabindex="2"></input><a href="#"  id="plus"><img src="<?php echo base_url()?>images/plus.png" width="20" height="20" border="0" /></a>&nbsp;&nbsp;<a href="#" id="mines"><img src="<?php echo base_url()?>images/nage.jpg" width="20" height="20" border="0" /></a></td>
             </tr>
             <tr>
                 <td>合计</td><td><input id="txttotal" type="text"></input></td>
             </tr>
             <tr >
                 <td colspan="2"><input type="button" id="btnAddOrder" value="添加到订单" tabindex="3"></input><input type="button" id="btnAddOrder_1" value="快速添加" tabindex="3"></input></td>
             </tr>
         </table>

</div>   
    
   <div id="dialog-custom" title="请选择客户">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    <?php foreach($custom_list as $item) :?>
    <a href="#"><?php echo $item->cname ?></a> |
    <?php endforeach;?>
  </p>

</div> 

	<div id="dialog-product" title="请选择产品">
  		<p>
	    	<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	    	<?php foreach($category_list as $item) :?>
	    	<a href="#" class="category" style="border: 0;"><?php echo $item->description ?></a> |
	    	<?php endforeach;?>
  		</p>
    	<p id="palproduct">
    	</p>
	</div> 
    
    
<div id="container">
<p class="validateTips1">所有的的值不能为空</p>
    <div id="cname" >
        <p>
         客户名称 <?php
                $data = array(
              'name'        => 'v_cname',
              'id'          => 'v_cname',
              'value'       => ''
            );
                echo form_input($data);
                ?>   
         
        </p>
    </div>
    <di id="date">
         <p>送货时间     <?php
                $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => $order_date
            );
                echo form_input($data);
                ?><a id="btnset_date" href="#" style="text-decoration:none;" >保留当前时间</a></p>
        
    </di>
    <div>
        <a id="add" href="#">添加行数</a>
        <?php $data = array(
        	'name' 		=>	'txtpsearch',
        	'id' 		=>	'txtpsearch',
        	'value' 		=>	'',
        );
        echo form_input($data); ?>
       <table id="tbl" width="100%" class="TR_MOUSEOVER">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>序号</th><th>产品名称</th><th>规格</th><th>单价</th><th>数量</th><th>合计</th><th>操作</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
            <th colspan="5"></th>
            	<th>合计：<label id="lbltotal">0</label></th>
                <th >
                    <input id="btnSubmit" type="button" value="提交订单"></input>
                </th>
            </tr>
        </tfoot>
        <tbody>
           
        </tbody>
    </table>
        
        
    </div>
    <input type="hidden"  id="hidden_help" name="hidden_help" value="" />
    <input type="hidden"  id="hidden_index" name="hidden_index" value="0" />
    <input type="hidden"  id="hidden_cindex" name="hidden_cindex" value="" />
	
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>