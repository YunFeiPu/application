<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="../css/global.css" type="text/css"  media="all" />
    <link href="../css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>    
    <script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>

</head>
<body>
    <h3>管理</h3>
   
    <div id="container">
    <h1><?php if(isset($item)){echo "编辑";}else{echo "添加";}?>####</h1>

	<div id="body">
            
         
            
            <?php if(isset($item))
            {
                echo form_open('groupproductprice/update');
            }
            else {echo form_open('groupproductprice/insert'); }?>
            
            <p>用户组别<?php
            $js = 'id="v_groupid"';
            echo form_dropdown('v_groupid',$group_list,isset($item)?$item->groupid:'0',$js);
                ?></p>
            
            
            
            
		<p>产品名称<?php
                $js = 'id="v_productid"';
            echo form_dropdown('v_productid',$product_list,isset($item)?$item->productid:'0',$js);
                echo form_hidden('hidden_productid','','hidden_productid');
                ?></p>
<p>批发价格    <?php
                $data = array(
              'name'        => 'v_price',
              'id'          => 'v_price',
              'value'       => isset($item)?$item->price:''
            );
                echo form_input($data);
                ?></p>

            <?php if(isset($item))
            {
                echo form_hidden('id',$item->id);
            } ?>
            <?php echo form_submit('mysubmit', '确定')?>
            <?php echo form_close()?>
	</div>

</div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>