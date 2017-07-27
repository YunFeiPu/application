<html>
	<head>
		<link href="/scripts/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/jquery.uploadify.min.js"></script>
<script type="text/javascript">
    $(function(){
      $(".uploadbutton").each(function(){
        
        bidtype="上传";
        $(this).uploadify({
          swf: 'http://www.51taotaole.com/scripts/uploadify.swf',
          uploader: "http://www.51taotoale.com/upload/do_upload",  //处理上传的php文件或者方法
          multi: true,  //是否开启一次性上传多个文件
          queueSizeLimit:20,  //最大允许上传的文件数量
          buttonText: bidtype,        //按钮文字
          height: 34,               //按钮高度
          width: 82,               //按钮宽度
          auto:false,  //选择完图片以后是否自动上传
          method:'post',
          fileTypeExts: "*.jpg;*.png;*.gif;*.jpeg;",      //允许的文件类型
          fileTypeDesc: "请选择图片文件",      //文件说明
          postData:{},
          formData: { "imgType": "normal","timestamp":"asdfsa","token":"48f262516b3912a060d21ef6af564668" }, //提交给服务器端的参数
          onUploadSuccess: function (file, data, response) {  //一个文件上传成功后的响应事件处理
            var data = $.parseJSON(data);
          }
        });
      })
    });
  </script>
	</head>
<body>
	<span id="commercial_upload" class="uploadbutton"></span>
	
	
<?php echo $error;?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>