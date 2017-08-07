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



</head>
<body>	<h3>查看供货单</h3>

	<p>

    <table width="100%" class="TR_MOUSEOVER   TOGGLE" id="tbl">
		<caption>订单列表</caption>
		<thead>
			<tr>
				<th>编号</th>
				<th>商户名称</th>
				<th>金额</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
        
            <?php $total = 0;  $index = 1; $beizhu = "";?>
           <?php if(isset($item_list)) :?>
            
           <?php foreach ($item_list as $item)://custom_list?>
                <tr>
				<td id=""><?php echo $index;$index++;?></td>
				<td><a href="/gonghuodan/getghdlistbygys/<?php echo $item->gys_id?>"><?php echo $item->description;?></a></td>
				<td id=""><?php echo number_format($item->heji,2);$total += $item->heji;?></td>
				
			</tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
		<tfoot>
			<tr>
				<th colspan="3"><label id="lbltqty"></label></th>
				<th colspan="2"><label id="lbltotal"><?php echo  $total ;?></label>
				</th>
				<th><label id="lblbak"></label></th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
