<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>产品类别</title>
    <?php $this->load->view('head.php');?>
    <style type="text/css">
    #dialog-category,#dialog-category-modi{display:none;}
    .desc_modi{text-decoration:none;}
    .hidden{display:none;}
    .desc_modi,.desc_isdel{
    	display:inline-block;
    	padding-left:5px;
    	padding-right:5px;
    	
    }
	</style>
    <script type="text/javascript"> 
    $(document).ready(function(){
		//修改产品描述
        $('.desc_modi').click(function(){
            var _desc = $($(this).parent().find("label")[1]).text();
            var _id = $($(this).parent().find("label")[0]).text();
                 
			$('#description_modi').val(_desc);
			$('#description_id_modi').val(_id);
                 
			$( "#dialog-category-modi" ).dialog({
            	modal: true,
                height : "450",        //高度
                width : "480",        //宽度
                buttons: {
	                Ok: function(){
						//开始AJAX请求
						var request = $.ajax({
		                	url: "<?php echo base_url()?>productcategory/modi",
		                	type: "POST",
		                	data: { description : _desc, pid : _id},
		                	dataType: "html"
		                });
	                	request.done(function( msg ) {
		                    alert(msg);
		                	$('#description_modi').val();
		                	$('#description_id_modi').val();
		    				$( this ).dialog( "close" );
	                	});
	                }
                 }
             }); 

         });
    });
    </script>
    <script type="text/javascript">
     	//修改产品类别名称
     	
		$(function(){
			$("#btnModiCategory").click(function(){
				//开始AJAX请求
				var _desc = $('#description_modi').val();
				var _id = $('#description_id_modi').val();
				var _pid = $('#pid_modi').val();
				
				var request = $.ajax({
                	url: "<?php echo base_url()?>productcategory/modi",
                	type: "POST",
                	data: { description: _desc, pid: _pid, id: _id},
                	dataType: "html"
                });
            	request.done(function( msg ) {
					$( "#dialog-category-modi" ).dialog( "close" );
                    window.parent.frames["main"].location.reload(); 
            	});
			});
		});
    </script>
    <script type="text/javascript">
		//修改显示状态
		$(function(){
			$(".desc_isdel").click(function(){
                var _id = $($(this).parent().find("label")[0]).text();
                var _isdel = $($(this).parent().find("label")[2]).text();

                var request = $.ajax({
                	url: "<?php echo base_url()?>productcategory/modistate",
                	type: "POST",
                	data: { id: _id, isdel: _isdel},
                	dataType: "html"
                });
            	request.done(function( msg ) {
                    window.parent.frames["main"].location.reload(); 
    				$( this ).dialog( "close" );
            	});
			});
		});
		
    </script>
    <script>
	$(function(){
		//添加产品分类
        $('#categoryadd').click(function(){
            // ajax 获取类别名称
            var request = $.ajax({
            url: "<?php echo base_url()?>productcategory/get",
            cache: false,
            dataType: "html"
            });
            request.done(function( msg ) {
            $( "#pid" ).html(msg)
            });
            request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
            });
            
            
           $( "#dialog-category" ).dialog({
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
        
        $('#btnAddCategory').click(function(){
            var description = $('#description').val();
            var pid = $('#pid').val();
            var request = $.ajax({
            url: "<?php echo base_url()?>productcategory/insert",
            type: "POST",
            data: { description : description, pid:pid},
            dataType: "html"
            });
            request.done(function( msg ) {
                alert(msg);
            
            $('#description').val("");
            window.parent.frames["main"].location.reload(); 
            $( "#dialog-category" ).dialog( "close" );
            
            });
            request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
            });
        });
        
	});
    </script>

</head>
<body>
    <h3>产品类别</h3>
    <div id="dialog-category-modi" title="修改产品类别" >
    <form>
    <p>
   	<label>父类别</label><select id="pid_modi" name="pid">
<option value="0" >不选择</option>
</select></p>
<p>
	<input name='description_id_modi' id='description_id_modi' readonly="readonly"></input>
    类别名称： <?php
                $data = array(
                    'name'        => 'description_modi',
                    'id'          => 'description_modi',
                    'value'       => ''
                  );
                echo form_input($data);
                ?>
   	
   	</p>
   	<input id="btnModiCategory"  type="button" value="修改" />
    </form>
    
    </div>
    
    
    
    
       <div id="dialog-category" title="增加新的产品类别 ">
       <lable>增加一个新的产品类别</lable>
           <form>
  <p>
    父 类 别：<select id="pid" name="pid">
<option value="0" >不选择</option>
</select>
  </p><p>
    类别名称： <?php
                $data = array(
                    'name'        => 'description',
                    'id'          => 'description',
                    'value'       => ''
                  );
                echo form_input($data);
                ?>
    <input id="btnAddCategory"  type="button" value="确定" />
  </p>
           </form>
</div> 
    <div>
        <?php foreach ($pcategory_list as $item)://pcateogry_list?>
        <ul>
            <li>
	            <label for='id' class='hidden'><?php echo $item->id ?></label>
	            <label for='description'><?php echo $item->description ?></label>
	            <span style="color:<?php echo $item->isdel == 0 ? "green":"red" ?>"><?php echo $item->isdel == 0 ? "销售中":"已暂停" ?></span>
	            <a class='desc_modi' href='#' >修改</a><label for='isdel' class='hidden'><?php echo $item->isdel ?></label>
	            <a class='desc_isdel' href='#'><?php echo $item->isdel == 0 ? "停售":"启用" ?></a>
            </li>
        </ul>
        
        <?php endforeach;?>
        <a href="#" id="categoryadd">添加</a>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>