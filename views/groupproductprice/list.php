<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() ?>css/global.css" type="text/css"
        media="all" />

 <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="../scripts/global.js"></script>

</head>
<body>
    <h3>管理</h3>
   
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           列表</caption>
        <thead>
            <tr>
                <th>用户组</th><th>产品名称</th><th>批发价</th><th>操作</th><th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="4">
                    <a href="<?php echo base_url()?>###/add">添加订单</a>
                </th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                    <td><?php echo $item->groupname;?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->price;?></td>
                    <td><a href="<?php echo base_url() ?>groupproductprice/modi/<?php echo $item->id; ?>">修改</a> | <a href="<?php echo base_url() ?>groupproductprice/delete/<?php echo $item->id; ?>" onclick="return confirm('您确定要删除当前选项吗?该操作不可恢复！')">删除</a></td>
                </tr>
        <?php endforeach;?>
            select  description, pname, price from (select description,price,productid from customgroup as c left join groupproductprice p on c.id =p.groupid) as a left join product p on a.productid = p.id
        </tbody>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>