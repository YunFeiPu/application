<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
</head>
<body>
    <h3>管理</h3>
    
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>基本信息</caption>
        <tr>
            <td>送货日期</td><td><?php echo $otime ?></td><td></td>
        </tr>
        <tr>
            <td>客户名称</td><td><?php echo $cname ?></td><td></td>
        </tr>
        <tr>
            <td>客户电话</td><td><?php echo $ctel ?></td><td></td>
        </tr>
    </table>
    <form action="<?php echo base_url();?>fileupload/savefile" method="post" enctype="multipart/form-data">
	<label for="file">订单照片上传:</label>
	<input type="file" name="file" id="file" /> <input type="submit" name="submit" value="提交图片" />
	<input type="hidden" name="oid" value="<?php echo $oid ?>" id="oid" />
	</form>
    
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th width="50" align="center">序号</th><th width="200">产品名称</th><th width="50">规格</th><th width="100">单价</th><th width="100">数量</th><th width="150">合计金额</th><th>操作</th>
            </tr>
        </thead>
       
        <tbody>
            <?php $i = 1;?>
            <?php foreach ($orderlist as $item)://custom_list?>
                <tr>    
                    <td><?php echo $i; 
                    $i++?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->pset;?></td>
                    <td><?php echo number_format($item->pprice,2);?></td>                    
                    <td><?php echo $item->qty;?></td>
                    <td><?php echo number_format($item->ptotal,2);?></td>
                    <td>修改 删除</td>
                </tr>
        <?php endforeach;?>
        </tbody>
         <tfoot>
            <tr>
                <th colspan="7">
                    <a href="<?php echo base_url()?>order/modi/<?php echo $oid;?>">修改订单</a><a href="<?php echo base_url()?>tableexport/index/<?php echo $oid;?>">下载打印</a>
                </th>
            </tr>
        </tfoot>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>

