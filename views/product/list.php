<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>产品管理</title>
    <?php $this->load->view('head.php');?>
    <style type="text/css">
        .hidden{display:none;}
    </style>
    
    <script>
     $(function() {
    	    var availableTags = [
    	      <?php $_ii =0;?>
    	      <?php foreach($product_list as $item) :?>
    	       <?php		if($_ii>0){
    	                      echo ',';
    	                  } ?>
    	   '<?php echo $item->pname;$_ii++; ?>'
    	    <?php endforeach;?>
    	    ];
    	    $( "#txtpname" ).autocomplete({
    	      source: availableTags,
    	      close: function( event, ui ) {
    	    	 
    				}
    	    });
    	  });
    	  
    	  
    	  	 $(function(){
		//按产品查询订单
		$("#btnSearchOrder").click(function(){
			var pname = encodeURIComponent($("#txtpname").val());
			if(pname.length>0 ){
				self.location='<?php echo base_url()?>product/index/'+pname;
			}
		});
		});
    	  
   </script>
    <script type="text/javascript">
    $(function(){
		$(".isnew").click(function(){
			var _id = $($(this).parent().parent().find("td")[0]).html();
			var _isnew = $($(this).find("label")[0]).html();
			var _data = {id: _id, state: _isnew, type: "isnew"};
			ajaxRequest(_data);
		});
		$(".ishot").click(function(){
			var _id = $($(this).parent().parent().find("td")[0]).html();
			var _ishot = $($(this).find("label")[0]).html();
			var _data = {id: _id, state: _ishot, type: "ishot"};
			ajaxRequest(_data);
		});
		$(".isdel").click(function(){
			var _id = $($(this).parent().parent().find("td")[0]).html();
			var _isdel = $($(this).find("label")[0]).html();
			var _data = {id: _id, state: _isdel, type: "isdel"};
			ajaxRequest(_data);
		});
    });

    function ajaxRequest( _data ){
    	var request = $.ajax({
        	url: "<?php echo base_url()?>product/updatestate",
        	type: "POST",
        	data: _data,
        	dataType: "html"
        });
    	request.done(function( msg ) {
            window.parent.frames["main"].location.reload(); 
    	});
    }
    </script>
</head>
<body>
    <h3>产品管理</h3>

<table>
			<tr>
				<td>产品名称</td>
				<td><input id="txtpname" name="txtpname" type="text" value="<?php echo isset($pname)? $pname:'' ?>"></input></td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" id="btnSearchOrder" value="查询产品"></input></td>
			</tr>
		</table>

    <table width="100%" class="TR_MOUSEOVER   TOGGLE">
        <caption>
           产品列表</caption>
        <thead>
            <tr>
                <th>ID号</th><th>产品名称</th><th>批发价</th><th>规格</th><th>备注</th><th>操作</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="7">
                    <a href="<?php echo base_url()?>product/add">添加订单</a>
                </th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                    <td><?php echo $item->id;?></td>
                    <td><?php echo $item->pname;?></td>
                    <td><?php echo $item->sprice; ?></td>
                    <td><?php echo $item->pset?></td>
                    <td><span style="color:<?php echo $item->isdel == 0 ? "green":"red" ?>"><?php echo $item->isdel == 0 ? "销售中":"已暂停" ?>
                    <?php echo $item->isnew == 0 ? "":'<img src="/images/new.gif" />' ?>
                    <?php echo $item->ishot == 0 ? "":"<img src='/images/hot.gif' />" ?>
                    </span>
                    |<a class="isnew" href="#"><?php echo $item->isnew == 0 ? "新品":"取消新品" ?><label for='isnew' class='hidden'><?php echo $item->isnew ?></label></a>
                    |<a class="ishot" href="#"><?php echo $item->ishot == 0 ? "热销品":"取消热销品" ?><label for='ishot' class='hidden'><?php echo $item->ishot ?></label></a>
                    |<a class="isdel" href="#"><?php echo $item->isdel == 0 ? "暂停销售":"恢复销售"  ?><label for='isdel' class='hidden'><?php echo $item->isdel ?></label></a>
                    </td>
                    <td>
                    <a href="<?php echo base_url() ?>product/groupprice/<?php echo $item->pname; ?>">查看卖价</a>
                    |<a href="<?php echo base_url() ?>product/modi/<?php echo $item->id; ?>">修改</a>
                    |<a href="<?php echo base_url() ?>product/dele/<?php echo $item->id; ?>" onclick="return confirm('您确定要删除当前选项吗?该操作不可恢复！')">删除</a>
                    </td>
                </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>