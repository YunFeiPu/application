<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<?php $this->load->view('head.php');?>
	<script>
		$(function(){
			$("#btntest1").click(function(){
			alert(ue.getContent());
		});
		});
	</script>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>欢迎使用ERP</h1>

	<div id="body">
		<p>在这里你可以操作您的erp系统数据</p>
		<code>2014-07-08: <br>修正订单无法下载的错误;<br /> 订单查看页面支持时间区间搜索;<br>同一天同一个客户只能开一个订单;<br>
		订单查看页增加排序功能;
		</code>
	</div>
	<form action="http://hyu2349810001.my3w.com/welcome/test1" method="post" accept-charset="utf-8" id="myform">		
		<input id="producttest" name="producttest" autocomplete="off" />
		<input type="submit" />
	</form>
	
	 <!-- 加载编辑器的容器 -->
    <script id="container1" name="content" type="text/plain">
        
    </script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="<?php echo base_url()?>editorphp/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo base_url()?>editorphp/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container1',{toolbars: [
    ['fullscreen', 'source', 'undo', 'redo','simpleupload', 'insertimage'],
    ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
]});
    </script>
    <input type="button" id="btntest1" value="提交" />
	
	<a href="<?php echo base_url()?>welcome/aprint">打印测试</a>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>