<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
</head>
<body>
<h3>添加订单</h3>
<div id="container">
  <div id="cname" >
        <p><label for="cname">客户名称:</label><?php echo (isset($cname)?$cname:'');?></p>
    </div>
    <div id="date">
         <p><label for="otime">送货时间 :</label><?php echo isset($otime)?$otime:'';?></p>
    </di>
    <div>
       <table id="tbl" width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>订单列表</caption>
        <thead>
            <tr>
                <th>序号</th><th>产品名称</th><th>规格</th><th>单价</th><th>数量</th><th>合计</th><th>操作</th>
            </tr>
        </thead>

        <tbody>
           <?php if(isset($order_list) && !empty($order_list)){
               $index = 1;
               foreach($order_list as $item){                   
                   echo "<tr id='$item->id'><td>$index</td><td>$item->pname</td><td>$item->pset</td><td>$item->pprice</td><td>$item->qty</td><td>$item->ptotal</td><td><a href='#' class='proedit'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>";
                   //echo "<tr><td>$item->id</td></tr>";
                   $index++;
               }
           } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="8">
                    <input id="btnSubmit" type="button" value="提交订单"></input>
                </th>
            </tr>
        </tfoot>
    </table>
    
    
                   <table id="tblmodi" width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>结算单列表</caption>
        <thead>
            <tr>
                <th>序号</th><th>产品名称</th><th>规格</th><th>单价</th><th>数量</th><th>合计</th><th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(isset($order_list) && !empty($order_list)){
               $index = 1;
               foreach($order_list as $item){                   
                   echo "<tr id='$item->id'><td>$index</td><td>$item->pname</td><td>$item->pset</td><td><input type='text' value='".$item->pprice."' /></td><td><input type='text' value='".$item->qty."' /></td><td><input type='text' value='".$item->ptotal."' /></td><td><a href='#' class='proedit'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>";
                   //echo "<tr><td>$item->id</td></tr>";
                   $index++;
               }
           } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8">
                    <input id="btnSubmit" type="button" value="提交订单"></input>
                </th>
            </tr>
        </tfoot>
    </div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>


</body>
</html>