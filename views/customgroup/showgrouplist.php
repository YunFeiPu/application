<?php

/* 
 * 显示 每个组别里所有的客户 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>客户列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() ?>css/global.css" type="text/css"
        media="all" />

 <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="../scripts/global.js"></script>

</head>
<body>
    <h3>组别管理</h3>
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           客户组列表</caption>
        <thead>
            <tr>
                <th>编号</th><th>客户组名称</th><th>客户组备注</th><th>操作</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="7">
                    <a href="<?php echo base_url()?>custom/add">添加订单</a>
                </th>
            </tr>
        </tfoot>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                    <td><?php $i++;
                    echo $i;?></td>
                    <td><?php echo $item->groupname; ?></td>
                    <td><?php echo $item->description; ?></td>
                    <td><a href="<?php echo base_url() ?>customgroup/modi/<?php echo $item->id; ?>">修改</a> | <a href="<?php echo base_url() ?>customgroup/dele/<?php echo $item->id; ?>" onclick="return confirm('您确定要删除当前选项吗?该操作不可恢复！')">删除</a></td>
                </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>