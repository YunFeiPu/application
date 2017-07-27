<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>客户组管理</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() ?>css/global.css" type="text/css" media="all" />
 	<script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
     
    });
    </script>
</head>
<body>
<div id="container">
    <h1><?php if(isset($customgroup)){echo "编辑";}else{echo "添加";}?>客户组</h1>

	<div id="body">
            <?php
            if(isset($customgroup)){
                echo form_open('customgroup/update');
            }
            else {
                echo form_open('customgroup/insert'); 
            }
            ?>
		<p>客户组名称    <?php
                $data = array(
              'name'        => 'v_groupname',
              'id'          => 'v_groupname',
              'value'       => isset($customgroup)?$customgroup->groupname:''
            );
                echo form_input($data);
                ?></p>
            
            
            <p>备注：   <?php
                $data = array(
              'name'        => 'v_description',
              'id'          => 'v_description',
              'value'       => isset($customgroup)?$customgroup->description:''
            );
                echo form_input($data);
                ?></p>

            <?php if(isset($customgroup))
            {
                echo form_hidden('id',$customgroup->id);
            } ?>
            <?php echo form_submit('mysubmit', '确定')?>
                <?php echo form_close()?>
	</div>
      	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>