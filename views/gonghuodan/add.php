<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('head.php');?>
<script language="javascript" src="<?php echo base_url()?>scripts/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

<script type="text/javascript">
	$(function(){

		$('#btn_update').click(function(){
			
			var item = {"ghd":{"gys_name":"","ghd_date":"","ghd_jine":1,"ghd_jiesuan_jine":"0","ghd_bak":""},
					"ghd_mx":[]};
			var mx1 = {"pid":0};

			$("#tbl tbody tr").each(function(){
					$pid = $($(this).find("td")[0]).find("label").attr("for");
					$pname = $($(this).find("td")[1]).text();
					$qty= $($(this).find("td")[2]).text();
					$pprice = $($(this).find("td")[3]).text();
					$heji = $($(this).find("td")[4]).text();
					$bak = "";
					var mx = {"mx_id":0,"p_id":$pid,"pname":$pname,"p_qty":$qty,"p_inprice":$pprice,"ghd_mx_heji":$heji,"ghd_mx_beizhu":$bak}
					item.ghd_mx.push(mx);
					
				});
			var  arequest = $.ajax({
		           url: "<?php echo base_url()?>gonghuodan/saveorupdate",
		           type: "POST",
		           data: { ghd : item},
		           async: false,
		           cache: false,
		           dataType: "html"
		           });
		    arequest.done(function( msg ) {
		       
		       alert(msg);
		    });
		});});
</script>
</head>
<body>
    <h3>管理</h3>
    <?php echo form_open('gonghuodan/add'); ?>
    客户名称：<?php
            $data = array(
              'name'        => 'v_gys_name',
              'id'          => 'v_gys_name',
              'value'       => isset($gys_name)?$gys_name:''
            );
            echo form_input($data);
    ?> 
     <br>
    请选择配送起始日期<?php
            $data = array(
              'name'        => 'v_order_date',
              'id'          => 'v_order_date',
            		'value'       => isset($order_date)?$order_date:date('Y-m-d')
            );
            echo form_input($data);
    ?>  
<?php echo form_submit('mysubmit', '查询')?>
<?php echo form_close()?>
	<table>
	<tr>
		<td>供应商名称</td>
		<td><?php echo isset($gys_name)?$gys_name:''; ?></td>
		<td>供货单日期</td>
		<td><?php echo $order_date; ?></td>
	</tr>
	<tr>
		<td>供货单金额</td>
		<td><?php echo isset($dingdan['total'])?$dingdan['total']:''; ?></td>
		<td>实际结算金额</td>
		<td></td>
	</tr>
	<tr>
		<td>备注</td><td colspan=3></td>
	</tr>
	<tr>
	<td colspan = '4'><input type="button" id='btn_update' value ="提交" /><a href="javascript:PrintOneURL();">预览打印</a></td>
	</tr>
	</table>
	
    <table id="tbl" width="100%" class="TR_MOUSEOVER">
        <caption>
           详细清单列表</caption>
        <thead>
            <tr>
                 <th>序号</th>
                 <th>产品名称</th>
                 <th>数量</th>
                 <th>结算价</th>
                 <th>小计</th>
                 <th>备注</th>
                 <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $_total= 0;
            $i = 1;
            $yishou = 0;
            ?>
            <?php if(isset ($gonghuodan)):?>
            <?php foreach ($gonghuodan['gonghuodan_mx'] as $item)://custom_list?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                    <td><?php echo $item->p_id;?></td>
                    <td><?php echo $item->p_qty;?></td>
                    <td><?php echo $item->p_inprice;?></td>
                    <td><?php echo number_format($item->p_qty*$item->p_inprice,2); ?></td>
                    <td></td><td></td>
                        </tr>
            <?php endforeach;?>
            <?php else:?>
            <?php if(isset ($dingdan)):?>
            <?php foreach ($dingdan['item_list'] as $item)://custom_list?>
                <tr>
                <td><?php echo $i; $i++;?><label for="<?php echo($item->pid)?>"></label></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->qty;?></td>
                    <td><?php echo $item->pprice;?></td>
                    <td><?php echo number_format($item->qty*$item->pprice,2); ?></td>
                    <td></td>
                    <td></td>
                </tr>
        				<?php endforeach;?>
        
        		</tbody>
        		<?php endif;?>
        		<?php endif;?>
        <tfoot>
            <tr>
                <th colspan="7">现金已结：<?php echo number_format($yishou,2);?>
                      合计:<?php echo number_format($_total,2);?>
                </th>
            </tr>
        </tfoot>
    </table>
  
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>