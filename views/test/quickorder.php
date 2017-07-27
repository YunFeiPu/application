<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
<script type="text/javascript">
$(function(){
    $( "#v_sdate" ).datepicker();
    $( "#v_edate" ).datepicker();
});


$(function(){
	$("#btnAddNick").click(function(){
		var nickname = $("#txtnickname").val();
		var pname = $("#txtpname").val();
		var arequest = $.ajax({
            url:"<?php echo base_url()?>test/addnickajax",
            type:"POST",
            data:{nickname:nickname,pname:pname},
            cache:false,
            dataType:"html"
        });
        
        arequest.done(function(msg){
            //ajax 获取产品的单价
            
            alert(msg);
           // var obj = eval ("(" + msg+ ")");
        
           // $("#txtpset").val(obj.pset);
   
		});
	});
});


$(function(){
	$(".findpname").click(function(){
		$("#txtnickname").val($($(this).parent().parent().find('td')[0]).html());
		
	   $( "#dialog-findproduct" ).dialog({
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
        //---1
        var request = $.ajax({
                url: "<?php echo base_url()?>ajax/getproductbydescription",
                type: "POST",
                data: { description : description},
                cache: false,
                dataType: "html"
                });
        //---1
        
        request.done(function( msg ) {
                    $("#palproduct").html("");
                    var obj = eval ("(" + msg+ ")");
                    if(obj.length>0){
                    	$("#palproduct").append("<ul style='margin-left: 15px;margin-bottom: 0px; border:1px solid;list-style-type:none;'>");
                        for(i=0 ; i<obj.length;i++){
                            $("#palproduct").append("<li><a href='#' class='productitem'>"+obj[i].pname+"</a> &nbsp; &nbsp; &nbsp; &nbsp;</li>");
                        }
                        $("#palproduct").append("</ul>");
                        $(".productitem").on("click" , function(){
                            //alert("aaa")
                            //var input = "#txt_"+$("#hidden_help").val()+"_1";
                            
                            $("#txtpname").val($( this ).html());
                            var desc = $( this ).html();
                            $( "#dialog-product" ).dialog("close");

						});

                    }
                    
                });
        request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                });
    });




	
});
</script>

</head>
<body>
 <div id="dialog-findproduct"  style="display: none" title="匹配产品">
         <table>
         <tr>
         <td>昵称</td>
         <td><input id="txtnickname" type="text" readonly></input></td>
         </tr>
             <tr>
                 <td>产品名称</td><td><input id="txtpname" type="text" readonly></input><a id="selectpro" href="#">选择产品</a></td>
             </tr>
             <tr >
                 <td colspan="2"><input type="button" id="btnAddNick" value="添加匹配"></input></td>
             </tr>
         </table>

</div>   
 <?php if(isset ($category_list)):?>
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
<?php endif;?>

    <h3>管理</h3>
<?php echo form_open('test/index')?>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($v_sdate)?$v_sdate:date('Y-m-d')
            );
            echo form_input($data);
            ?>  
   请选择配送结束日期<?php
            $data = array(
              'name'        => 'v_edate',
              'id'          => 'v_edate',
              'value'       => isset($v_edate)?$v_edate:''
            );
            echo form_input($data);
            ?>
           <p>
            <textarea name='txt_name' rows="10" cols="30">深海大蟹脚3    个             不辣鸭脖2合,     鸡翅2盒，鹌鹑蛋2罐  锅巴10,小龙虾2</textarea>
           <?php echo form_submit('mysubmit', '确定')?>
           </p> 
           <?php echo form_close();?>
           
           
          <?php if(isset ($item_list)):?>
        <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           解析结果</caption>
        <thead>
            <tr>
                 <th>昵称</th><th>数量</th>
                 <th>产品名称</th>
                 <th>匹配结果</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                <td><?php echo$item->nickname?></td>
                    <td><?php echo $item->qty;?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->isfound ? '找到匹配项':'没有匹配项<a class="findpname" href="#">匹配</a>';?></td>
                  </tr>
        <?php endforeach;?>
        </tbody>
     

    </table>
           
            <?php endif;?> 
           
           
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
