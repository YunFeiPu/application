<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>更新</title>
    <?php $this->load->view('head.php');?>
</head>
<body>
	<?php 
		$attributes = array( 'id' => 'myform');
		echo form_open('welcome/update',$attributes); 
    ?>
    <?php echo form_submit('mysubmit', '确定')?>
    <?php echo form_close();?>
</body>
</html>