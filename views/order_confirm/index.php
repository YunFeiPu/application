<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>订单列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="../css/global.css" type="text/css"
        media="all" />
   
 <link href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>


    
	<script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>
	
	
	<script>

	</script>
       
</head>
    <body>
<table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>订单号</th><th>送货日期</th><th>客户名称</th><th>合计金额</th><th>结款状态</th><th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $_total= 0?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                    <td><input type="checkbox" name="<?php echo $item->oid;?>" /><label class="checkbox"><?php echo $item->oid;?></label></td>
                    <td><?php echo $item->otime;?></td>
                    <td><?php echo $item->cname;?></td>
                    <td><?php echo number_format($item->ptotal,2); $_total+=$item->ptotal;?></td>
                    <td><?php switch ($item->order_state)
{
case 1:
	echo "<label class='red'>现金未付</label>";
	break;  
case 2:
	echo "<label class='red'>支付宝未付</label>";
	break;
case 3:
  	echo "<label class='green'>现金已结</label>";
	break;
case 4:
	echo "<label class='green'>支付宝已结</label>";
	break;
default:
  echo "<label class='red'>未处理</label>";
}?></td>
                    <td><a href="<?php echo base_url() ?>order_confirm/modi/<?php echo $item->oid; ?>">结算</a> | <a href="<?php echo base_url() ?>order/delebyoid/<?php echo $item->oid; ?>" onclick="return confirm('您确定要删除当前选项吗?该操作不可恢复！')">删除</a></td>
                </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">
                      合计:<?php echo number_format($_total,2);?>
                </th>
            </tr>
        </tfoot>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p> 
    </body>
</html>
