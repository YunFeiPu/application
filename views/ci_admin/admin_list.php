<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
</head>
<body>
    <h3>管理员管理</h3>
    <?php echo form_open('admin/index'); ?>
	<?php echo form_submit('mysubmit', '确定')?>
	<?php echo form_close()?>
	 <div id="dialog-addproduct" title="添加产品">
         <table>
             <tr>
                 <td>用户名</td><td><input id="txtpname" type="text" ></input><a id="selectpro" href="#">选择产品</a></td>
             </tr>
             <tr>
                 <td>密码</td><td><input id="txtpset" type="password" ></input></td>
             </tr>
             <tr>
                 <td>密码确认</td><td><input id="txtprice" type="password" ></input></td>
             </tr>
             <tr>
                 <td>级别</td><td><input id="txtqty" type="text"></input></td>
             </tr>
             <tr >
                 <td colspan="2"><input type="button" id="btnAddOrder" value="添加到订单" tabindex="3"></input><input type="button" id="btnAddOrder_1" value="快速添加" tabindex="3"></input></td>
             </tr>
         </table>

</div>   
    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                 <th>序号</th>
                 <th>管理员</th>
                 <th>级别</th>
                 <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php 
            $i = 1;
            ?>
            <?php if(isset ($item_list)):?>
            <?php foreach ($item_list as $item)://admin_list?>
                <tr>
                <td><?php echo $i; $i++;?></td>
                    <td><?php echo $item->username;?></td>
                    <td></td>
                    <td><a href="<?php echo base_url() ?>order/showinfo/<?php echo $item->username; ?>">查看</a> </td>
                        </tr>
        				<?php endforeach;?>
        		</tbody>
        		<?php endif;?>
        <tfoot>
            <tr>
                <th colspan="4">
                </th>
            </tr>
        </tfoot>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
