

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title>员工订单添加平台</title>
    
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css"></link>
    <link href="<?php echo base_url();?>css/login.css" rel="stylesheet"></link>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script>
    	function loginSign(src){
    		src.disabled=true;
			var account = document.getElementById("account").value; 		
    		var password = document.getElementById("password").value; 
    		if(account==""||account==null){
    			$("#errorShow").empty();
    			$("#errorShow").append('账户不能为空');
    			src.disabled=false;
    			return false;
    		}
    		if(password==""||password==null){
    			$("#errorShow").empty();
    			$("#errorShow").append('密码不能为空');
    			src.disabled=false;
    			return false;
    		}
    		if(account.length<5||account.length>15){
    			$("#errorShow").empty();
    			$("#errorShow").append('账户的长度为5到15个字符之间');
    			src.disabled=false;
    			return false;
    		}
    		var reg = new RegExp("^\\w+$");
    		if(!reg.test(account)){
    			$("#errorShow").empty();
    			$("#errorShow").append('账户由数字、字母以及下划线组成');
    			src.disabled=false;
    			return false;
    		}
    		$("#errorShow").empty();
    		src.disabled=false;
    		loginForm.submit();
    	}
</script>
</head>

<body>

<div class="container">
    <div class="container-fluid">
        <img src="/resource/admin/shop/images/logo.png" class="img-responsive  center-block" style="margin-top: 10px;"/>
    </div>
    <form class="form-signin" name="loginForm" action="/welcome/check" method="post">
        <input name="account" id="account" class="form-control" placeholder="用户名" required autofocus/>
        <input type="password" name='password' id="password"  class="form-control" placeholder="密码" required/>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="loginSign(this);">登陆</button>
				    <p style="margin-top: 5px;">
				        	<font color="red" id="errorShow">
				        	
				        		
				        		
				        		
				        		
				        		
				        		
				        		
				        	
				        	</font>
				    </p>
    </form>

</div> <!-- /container -->

</body>

</html>
