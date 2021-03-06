<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
    <title>订单列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url()?>css/global.css" type="text/css"
        media="all" />
    <link href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>scripts/global.js"></script>
    <script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>
    <script type="text/javascript">

$(function(){
	$(document).keydown(function(event){
		if($("#dialog-addproduct").dialog('isOpen')){
			window.console.log('判断对话框是否打开！');
			if(event.keyCode == 13){
				console.log("keycode = 13");
				var price = $("#txtprice").val();
		        var qty = $("#txtqty").val();
		        if(!checkprice(price)){
		            showmessage("请输入正确的价格格式");
		            $("#txtprice").focus();
		            return;
		        }
		        if(qty != ""){
			        if(!checkqty(qty)){
			        	showmessage("请输入正确的数量");
			            $("#txtqty").focus();
			            return;
			        }
			        
			        var total = parseFloat(price) * parseInt(qty);
			        $("#txttotal").val(total);
		    	}
			}
			else{
				
			}
		}
		else if(event.keyCode == 13){
			console.log("回车，对话框没有打开");
			$("#txtpsearch").focus();
		}
	});
});

</script>
    
<script type="text/javascript"  src="<?php echo site_url();?>scripts/orderModi.js?12312"></script>
<script>
	
/**
 * 初始化日历
 * @param {type} $
 * @returns {undefined}
 */
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



	function showmessage(msg){
		$("#dialog-message").dialog({
	        modal: true,
	        height : "300",        //高度
	        width : "480",        //宽度
	        open:function(event,ui){
	        	$("#dialog-message").html(msg);
	        	setTimeout(function() {
					$("#dialog-message").dialog("close");
	        	}, 1000 );
	        }
	      });
	}

    /**
     * 正则判断价格
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
  
  //添加新的项目
  function addnewitem(){
	  
	  var pname = $("#txtpname").val();
      var pset = $("#txtpset").val();
      var price = $("#txtprice").val();
      var qty = $("#txtqty").val();
      var total = $("#txttotal").val(); 
      //查看tr列表有没有重复项 ，如果有合并重复项 并且提醒；
  	$b = $($("#tbl tbody")).find("tr").toArray();
  	$flag_initemlist = 0;
  	for($i = 0 ; $i<$b.length; $i++){
  		$c = $($b[$i]).find("td").toArray();
  		if($c[1].innerHTML == pname){
  			$c[4].innerHTML = parseInt(qty)+parseInt($c[4].innerHTML);
  			$c[5].innerHTML =$c[4].innerHTML*$c[3].innerHTML;
  			$flag_initemlist = 1;
  			$oid = $($b[$i]).attr("id");
  			_cName = $("#v_cname").val();
  			_pName = $c[1].innerHTML;
  	         _price = $c[3].innerHTML;
  	         _qty = $c[4].innerHTML;
  	         _total = $c[5].innerHTML;
  			
  			var _orderInfo = '{"id":"'+ $oid +'","cname":"' + _cName +'","pname":"' + _pName +'","price":"'+_price+'","qty":"'+ _qty +'","total":"'+ _total +'"}' ;
  	        alert(pname+"已经合并");
  	        var _updateRequest = $.ajax({
  	                url: "http://www.51taotaole.com/order/ajaxOrderUpdate",
  	                type: "POST",
  	                data: { order : _orderInfo},
  	                cache: false,
  	                dataType: "html"
  	                });
  	        
  	         _updateRequest.done(function( msg ) {
  	            alert(msg);
  	        });
  	         countTotal();
  			return;
  		}
  	}
      if($flag_initemlist < 1){
      	$("#tbl tbody").append("<tr id='tr'><td>新增</td><td>"+pname+"</td><td>"+pset+"</td><td>"+price+"</td><td>"+qty+"</td><td>"+total+"</td><td><a class='proedit' href='#'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>");
      	//countTotal();
      }
      
      
      //countTotal();
	  
  }
  

  //修改产品的数量  该方法不确定是否正确
  function modiproductitem(){
	  var index = parseInt($("#hidden_index").val())+1 ;
      
      $("#hidden_index").val(index);
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
      var _orderInfo = '{"id":"'+ $oid +'","cname":"' + _cName +'","pname":"' + _pName +'","price":"'+_price+'","qty":"'+ _qty +'","total":"'+ _total +'"}' ;
     // alert(_orderInfo);
      var _updateRequest = $.ajax({
              url: "http://www.51taotaole.com/order/ajaxOrderUpdate",
              type: "POST",
              data: { order : _orderInfo},
              cache: false,
              dataType: "html"
              });
      
       _updateRequest.done(function( msg ) {
    	   $("#dialog-addproduct").dialog('close');
      });
       
       //countTotal();
  }
  
  
  //点击添加按钮
  function btnAddOrderClick(){
  	window.console.log("line 265");
  	modiproduct_des();
  }


//无用方法
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
             url: "http://www.51taotaole.com／order/checkcustom",
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


  /**
   * 根据产品的名称获取产品的信息
   * @param pname
   * @param isquick
   */
  function getproductbypname(pname,isquick){
	  //alert("function getproductbypname");
  	var arequest = $.ajax({
          url:"http://www.51taotaole.com/ajax/getproductbyname",
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
          var pricerequest = $.ajax({
	          url:"http://www.51taotaole.com/ajax/getproductprice",
	          type:"POST",
	          data:{cname:cname,pname:pname},
	          cache:false,
	          dataType:"html"
          });

          pricerequest.done(function(msg){
              //ajax 获取产品的单价
        	 
             var obj1 = eval ("(" + msg+ ")");
             	$("#txtpname").val(pname);
              $("#txtprice").val(obj1.price);
              $("#txtqty").val("");
              $("#txttotal").val(obj1.price);
              _pprice = obj1.price;
              
              $("#txtpserach").val("");
              if(checkprice(obj1.price)){
                  $("#saveprice").hide();
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


    
    
    /*
     * 点击删除  删除 产品 
     * @returns {undefined}
     */
    $(function(){
    //点击删除按钮 删除当前项目，并且重新编号
        $(document).on("click",".prodele",function(){
        if(confirm('您确定要删除当前内容吗？')){
            $a = $($(this).parent().parent()).find("td").toArray();//找到代码行，dom读取数据 
            $b = $($(this).parent().parent().parent()).find("tr").toArray()//所有代码行;
            
            $cindex = ($a[0].innerHTML);
           // alert($cindex+"+"+$b.length);
            
           
            
            var aaaa = $(this).parent().parent();
            if($cindex == "新增"){
                $(this).parent().parent().remove();
            }
            else{
                $oid = $(this).parent().parent().attr("id");               
                
                var _updateRequest = $.ajax({
                url: "http://www.51taotaole.com/order/ajaxOrderItemDele",
                type: "POST",
                data: { oid : $oid},
                cache: false,
                dataType: "html" ,
                 beforeSend: function( xhr ) {
   // xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                $("#btnSubmit").attr("disable",true);
  }
            });
        
                _updateRequest.done(function( msg ) {
                    
                    aaaa.remove();
                    for($i = 0; $i<$b.length; $i++){
                    	$ii = $cindex-1;
                    	if($i>$ii){
                    		//alert($i+"xiugai");
                    		//alert($b[$i])
                    		$c = $($b[$i]).find("td").toArray();
                    		$c[0].innerHTML= $i;
                    	}
                    }
                     $("#btnSubmit").attr("disable",fasle);
               });
            }
            //var _index = parseInt($("#hidden_index").val()) - 1;
            //$("#hidden_index").val(_index);
            //$("#tbl tbody tr").eq($cindex-1).remove();
            //var _tr_array = $("#tbl tbody tr").toArray();            
            //if(_tr_array.length>0){
            //    var i = 1;
            //    for(var a=0; a<_tr_array.length; a++){
           //         $bbb = $("#tbl tbody tr").eq(a).find("td").toArray();
             //       $bbb[0].innerHTML = i;
             //       i++;
              //  }
            //}
        }
    });
});
    
//两个修改产品方法，点击按钮或者敲回车的时候作用，只保留一个！    
function modiproduct(){
		window.console.log('开始检查格式------');
        if(!checkprice($("#txtprice").val())){
            alert('单价格式不正确');
            return;
        }
        if(!checkqty($("#txtqty").val())){
        	alert('数量个数不正确');
        	return;
        }
        var _cindex = parseInt($("#hidden_cindex").val());
        if(_cindex === 0){
        	//添加新产品
        	//alert("add ");
           addnewitem();
           $("#dialog-addproduct").dialog('close');
           $("#txtpsearch").val("");
          // countTotal();
        }
        else{
        
        //说明是修改产品
       modiproductitem();
    }
        countTotal();
        $("#txtpname").val("");
        $("#txtpset").val("");
        $("#txtprice").val("");
        $("#txtqty").val("");
        $("#txttotal").val(""); 

}    
//两个修改方法有一个是错误的
function modiproduct_des(){
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
      	countTotal();
          
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

/**
 * 修改产品数量 核心代码**********
 * 修改产品数量价格并把数据写入数据库
 * @returns {undefined}
 */
$(function() {
     $("#btnAddOrder").click(function(){
     	window.console.log("line 567");
     	modiproduct();
    });
    
});



$(function(){

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
    
    //点击产品编辑按钮填充表单
    $(".proedit").click(function(){
        
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
    $("#btnSubmit").click(function(){
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
        var obj = '{"cname":"'+$("#v_cname").val()+'","orderid":"'+$("#hidden_oid").val()+'","otime":"'+$("#v_sdate").val()+'","products":[';
        var $trAry = $("#tbl tbody tr").toArray();
        $j = 0;
        for(var $i=0 ; $i<$trAry.length; $i++){
            var $tdAry = $($trAry[$i]).find("td").toArray();
            //alert($tdAry[1].innerHTML);
            if ($j > 0){
                obj = obj +',';
            }
            if($tdAry[0].innerHTML == '新增'){
            obj = obj +'{"pname":"'+$tdAry[1].innerHTML+'","pprice":"'+$tdAry[3].innerHTML+'","qty":"'+$tdAry[4].innerHTML+'","ptotal":"'+$tdAry[5].innerHTML+'"}';
            $j ++;
            }
        }
        obj = obj+']}';
        var j = jQuery.parseJSON(obj);
        var order = obj;
        var request = $.ajax({
                url: "http://www.51taotaole.com/order/OrderModiAddProduct",
                type: "POST",
                data: { order : order},
                cache: false,
                dataType: "html"
                });

        request.done(function( msg ) {
             $("#dialog-submit").dialog( "close" );            
            window.location.reload();
        });
    });
    
    
    
    $('#btnCustom').click(function(){
        //写道这里要写换客户的代码
    
    
    
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
       if((v_cname).length<=0){
           alert('请先选择客户');
       }else{
        var index = $(this).attr("id").split('_');
        
        $( "#hidden_help" ).val(index[1]);      
        
        $( "#dialog-product" ).dialog({
                modal: true,
                height : "550",        //高度
                width : "580",        //宽度
                buttons: {
                  Ok: function() {
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
        alert("请先选择产品");
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
        alert('请输入正确的数量');
    }
    });
    
    $("#mines").click(function(){
    var pname = $("#txtpname").val();
    if(pname.length === 0){
        alert("请先选择产品");
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
        alert('请输入正确的数量');
    }
    });
    // End 数量+号 -号点击
    
    //Start txtPrice txtqty 改动
    $("#txtprice").blur(function(){
        var price = $("#txtprice").val();
        var qty = $("#txtqty").val();
         if(checkprice(price) && checkqty(qty)){
	        var total = parseFloat(price) * parseInt(qty);
	        $("#txttotal").val(total);
        }

    });
    $("#txtqty").blur(function(){
        var price = $("#txtprice").val();
        var qty = $("#txtqty").val();
        if(checkprice(price) && checkqty(qty)){
	        var total = parseFloat(price) * parseInt(qty);
	        $("#txttotal").val(total);
        }
    });
    
    
    
    //添加产品
    $("#add").click(function(){
       
        $("#hidden_cindex").val("0");
        $( "#dialog-addproduct" ).dialog({
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
    
    
    $("#selectpro").click(function(){
        $( "#dialog-product" ).dialog({
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
    
    
    //点击选定产品 
    $(".category").click(function(){        
        var description = $(this).html();
        var request = $.ajax({
                url: "http://www.51taotaole.com/ajax/getproductbydescription",
                type: "POST",
                data: { description : description},
                cache: false,
                dataType: "html"
                });
        request.done(function( msg ) {
                    $("#palproduct").html("");
                    var obj = eval ("(" + msg+ ")");
                    if(obj.length>0){
                        for(i=0 ; i<obj.length;i++){
                            $("#palproduct").append("<a href='#' class='productitem'>"+obj[i].pname+"</a> &nbsp; &nbsp; &nbsp; &nbsp;");
                        }
                        
                        $(".productitem").on("click" , function(){
                            //alert("aaa")
                            //var input = "#txt_"+$("#hidden_help").val()+"_1";
                            
                            $("#txtpname").val($( this ).html());
                            var desc = $( this ).html();
                            var arequest = $.ajax({
                                url:"http://www.51taotaole.com/ajax/getproductbyname",
                                type:"POST",
                                data:{description:desc},
                                cache:false,
                                dataType:"html"
                            });
                            
                            arequest.done(function(msg){
                                //ajax 获取产品的单价
                                var cname = $("#v_cname").val();
                                var pname = desc;
                                //alert(cname+pname);
                                var obj = eval ("(" + msg+ ")");
                            
                                $("#txtpset").val(obj.pset);
                                var pricerequest = $.ajax({
                                url:"http://www.51taotaole.com/ajax/getproductprice",
                                type:"POST",
                                data:{cname:cname,pname:pname},
                                cache:false,
                                dataType:"html"
                            });
                            
                            pricerequest.done(function(msg){
                                //ajax 获取产品的单价
                               var obj1 = eval ("(" + msg+ ")");
                                $("#txtprice").val(obj1.price);
                                $("#txtqty").val("");
                                $("#txttotal").val(obj1.price);
                                //zheli
                                $( "#dialog-product" ).dialog("close");
                                if(checkprice(obj1.price)){
                                    $("#saveprice").hide();
                                }
                                else{
                                    $("#saveprice").show();
                                }
                                
                            });
                            
                            pricerequest.fail(function( jqXHR, textStatus ) {
                            alert( "Request failed: " + textStatus );
                });
                                
                                
                                
                                
                                
                            });
                            arequest.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                });
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




<script type="text/javascript">
<?php //快速搜索产品栏代码?>
		 $(function() {
			    var availableTags = [
			        <?php $_ii =0;?>
			      <?php foreach($product_list as $item) :?>
			       <?php           if($_ii>0){
			                      echo ',';
			                  } ?>
			   '<?php echo $item->pname;$_ii++; ?>'
			    <?php endforeach;?>
			    ];
			    $( "#txtpsearch" ).autocomplete({
			      source: availableTags,
			      close: function( event, ui ) {
			    	  //$("#hidden_cindex").val("0");
			    	  //getproductbypname($("#txtpsearch").val(),true);
			    	  //$("#txtpsearch").val('');
						$index = pnameExsitIndex($("#txtpsearch").val());
						//alert($index);
						if($index>=0){
							
							var _t = "#tbl tbody tr:eq("+$index+")";
							//alert($(_t).find("td")[3].innerHTML);
							$("#txtpname").val($(_t).find("td")[1].innerHTML);
					        $("#txtpset").val($(_t).find("td")[2].innerHTML);
					        $("#txtprice").val($(_t).find("td")[3].innerHTML);
					        $("#txtqty").val($(_t).find("td")[4].innerHTML);
					        $("#txttotal").val($(_t).find("td")[5].innerHTML);
					        $("#hidden_cindex").val($index+1);
					        
					        $("#dialog-addproduct").dialog({
					                modal: true,
					                height : "550",        //高度
					                width : "580",        //宽度
					                buttons: {
					                  Ok: function() {                    
					                    //$( this ).dialog( "close" );
					                  }
					                },
					                open: function( event, ui ) {
						                
						                $("#txtpsearch").val("");
					    				$("#txtqty").focus();
					    				$("#txtqty").select();
					    				return false;
					                }
					              });
				              return false;
			
							
						}else{
							$("#hidden_cindex").val("0");
							getproductbypname($("#txtpsearch").val(),false);

						}
			    	  
						}
			    });
			  });	    

		


</script>



</head>
<body>
    <h3>添加订单</h3>
     <div id="dialog-addproduct" title="添加产品">
         <table>
             <tr>
                 <td>产品名称</td><td><input id="txtpname" type="text" readonly></input><a id="selectpro" href="#">选择产品</a></td>
             </tr>
             <tr>
                 <td>规格</td><td><input id="txtpset" type="text" readonly></input></td>
             </tr>
             <tr>
                 <td>单价</td><td><input id="txtprice" type="text" onfocus="this.select();"></input><input type="button" id="saveprice" value="保存当前产品的价格到该用户组"></input></td>
             </tr>
             <tr>
                 <td>数量</td><td><input id="txtqty" type="text"   onfocus="this.select();"></input><a href="#"  id="plus"><img src="<?php echo base_url()?>images/plus.png" width="20" height="20" border="0" /></a>&nbsp;&nbsp;<a href="#" id="mines"><img src="<?php echo base_url()?>images/nage.jpg" width="20" height="20" border="0" /></a></td>
             </tr>
             <tr>
                 <td>合计</td><td><input id="txttotal" type="text"></input></td>
             </tr>
             <tr >
                 <td colspan="2"><input type="button" id="btnAddOrder" value="添加到订单"></input></td>
             </tr>
         </table>

</div>   
    <div id="dialog-submit" title="提交订单">         订单提交中
</div>   
    
   <div id="dialog-custom" title="请选择客户">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    <?php foreach($custom_list as $item) :?>
    <a href="#"><?php echo $item->cname ?></a> |
    <?php endforeach;?>
  </p>

</div> 




       <div id="dialog-product" title="请选择">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    <?php foreach($category_list as $item) :?>
    <a href="#" class="category"><?php echo $item->description ?></a> |
    <?php endforeach;?>
  </p>
    <p id="palproduct">

    </p>

</div> 
    
    
<div id="container">

    <div id="cname" >
        <p>
         客户名称 <?php
                $data = array(
              'name'        => 'v_cname',
              'id'          => 'v_cname',
              'value'       => isset($cname)?$cname:'',
                    'readonly' => 'readonly'
            );
                echo form_input($data);
                ?>   <a id="btnCustom" href="#" style="text-decoration:none;" >选择客户</a>
         
        </p>
    </div>
    <div id="date">
         <p>送货时间     <?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($otime)?$otime:''
            );
            echo form_input($data);
                ?></p>
        <p></p>
    </div>
    <div>
            <a id="add" href="#">添加行数</a>
        <?php $data = array(
        	'name' 		=>	'txtpsearch',
        	'id' 		=>	'txtpsearch',
        	'value' 		=>	'',
        );
        echo form_input($data); ?>
        <a id="add" href="#">添加产品</a>
       <table id="tbl" width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>序号</th><th>产品名称</th><th>规格</th><th>单价</th><th>数量</th><th>合计</th><th>操作</th>
            </tr>
        </thead>
       
        <tbody>
           <?php if(isset($orderlist) && !empty($orderlist)){
               $index = 1;
               $total = 0;
               foreach($orderlist as $item){                   
                   echo "<tr id='$item->id'><td>$index</td><td>$item->pname</td><td>$item->pset</td><td>" . number_format($item->pprice,2) . "</td><td>$item->qty</td><td>" . number_format($item->ptotal,2) . "</td><td><a href='#' class='proedit'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>";
                   //echo "<tr><td>$item->id</td></tr>";
                   $total += $item->ptotal;
                   $index++;
               }
           } ?>
        </tbody>
         <tfoot>
            <tr>
                <th colspan="5"></th><th>合计：<label id='lblTotal'><?php echo number_format($total,2);?></label></th><th><input id="btnSubmit" type="button" value="提交订单"></input>
                </th>
            </tr>
        </tfoot>
    </table>        
    </div>
    <input type="hidden"  id="hidden_help" name="hidden_help" value="" />
    <input type="hidden"  id="hidden_total" name="hidden_help" value="" />
    <input type="hidden"  id="hidden_index" name="hidden_index" value="<?php echo --$index;?>" />
    <input type="hidden"  id="hidden_cindex" name="hidden_cindex" value="" />
    <input type="hidden"  id="hidden_cindex" name="hiddenCustomID" value="<?php echo $cid; ?>" />
    <input type="hidden"  id="hidden_oid" name="hidden_oid" value="<?php echo $oid; ?>" />
    <div>
    		 <!-- 加载编辑器的容器 -->
    <script id="container1" name="content" type="text/plain">
        
    </script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="<?php echo base_url()?>editorphp/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo base_url()?>editorphp/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container1',{toolbars: [
    ['fullscreen', 'source', 'undo', 'redo','simpleupload', 'insertimage'],
    ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
]});
    </script>
    <input type="button" id="btntest1" value="提交" />
    	
    </div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>

</html>