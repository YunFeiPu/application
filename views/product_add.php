<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>客户列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() ?>css/global.css" type="text/css"
        media="all" />

 <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="../scripts/global.js"></script>
    
    <script type="text/javascript">
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
		<p>产品名称    <?php
                $data = array(
              'name'        => 'v_pname',
              'id'          => 'v_pname',
              'value'       => isset($product)?$product->pname:''
            );
                echo form_input($data);
                ?><label id="labelPname" style="color: red; ">该用名称已经存在</label></p>
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
            <p>进货价格    <?php
                $data = array(
              'name'        => 'v_pprice',
              'id'          => 'v_pprice',
              'value'       => isset($product)?$product->pprice:''
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
        
        
<ul>

</ul>
<?php if(isset($product)):?>
        <?php echo print_r($category_list) ?>
<?php endif; ?>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>