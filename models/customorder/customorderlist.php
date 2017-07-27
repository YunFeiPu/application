<?php //此文件列出某一个客户的最近几个月的订单，及订单状态 ?>
<html>
	<body>
		<?php foreach ($itemlist as $item) {
			echo '$item->cname | $item->otime | $item-ptotal';		
		}
?>
	</body>
</html>