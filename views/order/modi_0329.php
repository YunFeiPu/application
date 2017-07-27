<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>订单列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url()?>css/global.css" type="text/css"
        media="all" />
    <link href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>scripts/global.js"></script>
    <script src="<?php echo base_url()?>scripts/jquery-ui.js"></script>
<script type="text/javascript"  src="<?php echo site_url();?>scripts/orderModi.js?12312"></script>
</head>
<body>
    <h3>添加订单</h3>
     <div id="dialog-addproduct" title="添加产品">
         <table>
             <tr>
                 <td>产品名称</td><td><input id="txtpname" type="text" readonly></input><a id="selectpro" href="#">选择产品</a></td>
             </tr>
             <tr>
                 <td>规格</td><td><input id="txtpset" type="text" readonly></input></td>
             </tr>
             <tr>
                 <td>单价</td><td><input id="txtprice" type="text" onfocus="this.select();"></input><input type="button" id="saveprice" value="保存当前产品的价格到该用户组"></input></td>
             </tr>
             <tr>
                 <td>数量</td><td><input id="txtqty" type="text"   onfocus="this.select();"></input><a href="#"  id="plus"><img src="<?php echo base_url()?>images/plus.png" width="20" height="20" border="0" /></a>&nbsp;&nbsp;<a href="#" id="mines"><img src="<?php echo base_url()?>images/nage.jpg" width="20" height="20" border="0" /></a></td>
             </tr>
             <tr>
                 <td>合计</td><td><input id="txttotal" type="text"></input></td>
             </tr>
             <tr >
                 <td colspan="2"><input type="button" id="btnAddOrder" value="添加到订单"></input></td>
             </tr>
         </table>

</div>   
    <div id="dialog-submit" title="提交订单">         订单提交中
</div>   
    
   <div id="dialog-custom" title="请选择客户">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    <?php foreach($custom_list as $item) :?>
    <a href="#"><?php echo $item->cname ?></a> |
    <?php endforeach;?>
  </p>

</div> 

       <div id="dialog-product" title="请选择">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    <?php foreach($category_list as $item) :?>
    <a href="#" class="category"><?php echo $item->description ?></a> |
    <?php endforeach;?>
  </p>
    <p id="palproduct">

    </p>

</div> 
    
    
<div id="container">
    <div id="cname" >
        <p>
         客户名称 <?php
                $data = array(
              'name'        => 'v_cname',
              'id'          => 'v_cname',
              'value'       => isset($cname)?$cname:'',
                    'readonly' => 'readonly'
            );
                echo form_input($data);
                ?>   <a id="btnCustom" href="#" style="text-decoration:none;" >选择客户</a>
         
        </p>
    </div>
    <di id="date">
         <p>送货时间     <?php
            $data = array(
              'name'        => 'v_sdate',
              'id'          => 'v_sdate',
              'value'       => isset($otime)?$otime:''
            );
            echo form_input($data);
                ?></p>
        
    </di>
    <div>
        <a id="add" href="#">添加产品</a>
       <table id="tbl" width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>序号</th><th>产品名称</th><th>规格</th><th>单价</th><th>数量</th><th>合计</th><th>操作</th>
            </tr>
        </thead>
       
        <tbody>
           <?php if(isset($orderlist) && !empty($orderlist)){
               $index = 1;
               $total = 0;
               foreach($orderlist as $item){                   
                   echo "<tr id='$item->id'><td>$index</td><td>$item->pname</td><td>$item->pset</td><td>" . number_format($item->pprice,2) . "</td><td>$item->qty</td><td>" . number_format($item->ptotal,2) . "</td><td><a href='#' class='proedit'>编辑<a>    |   <a class='prodele' href='#'>删除<a></td></tr>";
                   //echo "<tr><td>$item->id</td></tr>";
                   $total += $item->ptotal;
                   $index++;
               }
           } ?>
        </tbody>
         <tfoot>
            <tr>
                <th colspan="5"></th><th>合计：<label id='lblTotal'><?php echo number_format($total,2);?></label></th><th><input id="btnSubmit" type="button" value="提交订单"></input>
                </th>
            </tr>
        </tfoot>
    </table>
        
        
        
        <ul>
            <li>产品<a href="#" id="btnCustom1" class="txtproduct">选择产品</a>  数量 <labput>el for="sp1"></label>
  <input id="sp1" class="spinner" name="value"></li>
        </ul>
        
        
    </div>
    <input  id="hidden_help" name="hidden_help" value="" />
    <input  id="hidden_total" name="hidden_help" value="" />
    <input  id="hidden_index" name="hidden_index" value="<?php echo --$index;?>" />
    <input  id="hidden_cindex" name="hidden_cindex" value="" />
    <input  id="hidden_cindex" name="hiddenCustomID" value="<?php echo $cid; ?>" />
    <input  id="hidden_oid" name="hidden_oid" value="<?php echo $oid; ?>" />
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>

</html>