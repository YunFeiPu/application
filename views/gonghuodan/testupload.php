<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>演示：HTML5应用之文件拖拽上传</title>

<script type="text/javascript" src="/script/jquery.js"></script>
<style type="text/css">
.demo{width:500px; margin:50px auto}
#drop_area{width:100%; height:100px; border:3px dashed silver; line-height:100px; text-align:center; font-size:36px; color:#d3d3d3}
#preview{width:500px; overflow:hidden}
</style>
</head>

<body>

<div id="main">
   <h2 class="top_title"><a href="http://www.helloweba.com/view-blog-192.html">HTML5应用之文件拖拽上传</a></h2>
   <div class="demo">
		<div id="drop_area">将图片拖拽到此区域</div>
		<div id="preview"></div>
   </div>
</div>

<script type="text/javascript">
$(function(){
	//阻止浏览器默认行。
	$(document).on({
		dragleave:function(e){		//拖离
			e.preventDefault();
		},
		drop:function(e){			//拖后放
			e.preventDefault();
		},
		dragenter:function(e){		//拖进
			e.preventDefault();
		},
		dragover:function(e){		//拖来拖去
			e.preventDefault();
		}
	});
	
	//================上传的实现
	var box = document.getElementById('drop_area'); //拖拽区域
		
	box.addEventListener("drop",function(e){
		e.preventDefault(); //取消默认浏览器拖拽效果
		var fileList = e.dataTransfer.files; //获取文件对象
		//检测是否是拖拽文件到页面的操作
		if(fileList.length == 0){
			return false;
		}
		//检测文件是不是图片
		if(fileList[0].type.indexOf('image') === -1){
			alert("您拖的不是图片！");
			return false;
		}
		
		//拖拉图片到浏览器，可以实现预览功能
		var img = window.webkitURL.createObjectURL(fileList[0]);
		var filename = fileList[0].name; //图片名称
		var filesize = Math.floor((fileList[0].size)/1024); 
		if(filesize>500){
			alert("上传大小不能超过500K.");
			return false;
		}
		//alert(filesize);
		var str = "<img src='"+img+"'><p>图片名称："+filename+"</p><p>大小："+filesize+"KB</p>";
		$("#preview").html(str);
		
		//上传
		xhr = new XMLHttpRequest();
		xhr.open("post", "upload.php", true);
		xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		
		var fd = new FormData();
		fd.append('mypic', fileList[0]);
			
		xhr.send(fd);
		
			
	},false);
});
</script>

<div id="footer">
    <p>Powered by helloweba.com  允许转载、修改和使用本站的DEMO，但请注明出处：<a href="http://www.helloweba.com">www.helloweba.com</a></p>
</div>
<p id="stat"><script type="text/javascript" src="/js/tongji.js"></script></p>
</body>
</html>