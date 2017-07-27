<!DOCTYPE html>
<html lang="en">
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/template/head.php';?>
	<script type="text/javascript">
		/*
Ajax 三级省市联动
http://code.ciaoca.cn/
日期：2012-7-18

settings 参数说明
-----
url:省市数据josn文件路径
prov:默认省份
city:默认城市
dist:默认地区（县）
nodata:无数据状态
required:必选项
------------------------------ */
(function($){
	$.fn.citySelect=function(settings){
		if(this.length<1){return;};

		// 默认值
		settings=$.extend({
			url:"<?php echo base_url()?>scripts/city.js",
			prov:null,
			city:null,
			dist:null,
			nodata:null,
			required:true
		},settings);

		var box_obj=this;
		var prov_obj=box_obj.find(".prov");
		var city_obj=box_obj.find(".city");
		var dist_obj=box_obj.find(".dist");
		var prov_val=settings.prov;
		var city_val=settings.city;
		var dist_val=settings.dist;
		var select_prehtml=(settings.required) ? "" : "<option value=''>请选择</option>";
		var city_json;

		// 赋值市级函数
		var cityStart=function(){
			var prov_id=prov_obj.get(0).selectedIndex;
			if(!settings.required){
				prov_id--;
			};
			city_obj.empty().attr("disabled",true);
			dist_obj.empty().attr("disabled",true);

			if(prov_id<0||typeof(city_json.citylist[prov_id].c)=="undefined"){
				if(settings.nodata=="none"){
					city_obj.css("display","none");
					dist_obj.css("display","none");
				}else if(settings.nodata=="hidden"){
					city_obj.css("visibility","hidden");
					dist_obj.css("visibility","hidden");
				};
				return;
			};
			
			// 遍历赋值市级下拉列表
			temp_html=select_prehtml;
			$.each(city_json.citylist[prov_id].c,function(i,city){
				temp_html+="<option value='"+city.n+"'>"+city.n+"</option>";
			});
			city_obj.html(temp_html).attr("disabled",false).css({"display":"","visibility":""});
			distStart();
		};

		// 赋值地区（县）函数
		var distStart=function(){
			var prov_id=prov_obj.get(0).selectedIndex;
			var city_id=city_obj.get(0).selectedIndex;
			if(!settings.required){
				prov_id--;
				city_id--;
			};
			dist_obj.empty().attr("disabled",true);

			if(prov_id<0||city_id<0||typeof(city_json.citylist[prov_id].c[city_id].a)=="undefined"){
				if(settings.nodata=="none"){
					dist_obj.css("display","none");
				}else if(settings.nodata=="hidden"){
					dist_obj.css("visibility","hidden");
				};
				return;
			};
			
			// 遍历赋值市级下拉列表
			temp_html=select_prehtml;
			$.each(city_json.citylist[prov_id].c[city_id].a,function(i,dist){
				temp_html+="<option value='"+dist.s+"'>"+dist.s+"</option>";
			});
			dist_obj.html(temp_html).attr("disabled",false).css({"display":"","visibility":""});
		};

		var init=function(){
			// 遍历赋值省份下拉列表
			temp_html=select_prehtml;
			$.each(city_json.citylist,function(i,prov){
				temp_html+="<option value='"+prov.p+"'>"+prov.p+"</option>";
			});
			prov_obj.html(temp_html);

			// 若有传入省份与市级的值，则选中。（setTimeout为兼容IE6而设置）
			setTimeout(function(){
				if(settings.prov!=null){
					prov_obj.val(settings.prov);
					cityStart();
					setTimeout(function(){
						if(settings.city!=null){
							city_obj.val(settings.city);
							distStart();
							setTimeout(function(){
								if(settings.dist!=null){
									dist_obj.val(settings.dist);
								};
							},1);
						};
					},1);
				};
			},1);

			// 选择省份时发生事件
			prov_obj.bind("change",function(){
				cityStart();
			});

			// 选择市级时发生事件
			city_obj.bind("change",function(){
				distStart();
			});
		};

		// 设置省市json数据
		if(typeof(settings.url)=="string"){
			$.getJSON(settings.url,function(json){
				city_json=json;
				init();
			});
		}else{
			city_json=settings.url;
			init();
		};
	};
})(jQuery);
	</script>
	<script type="text/javascript">
$(function(){
	$("#city").citySelect({
		prov:"江苏", city:"无锡", dist:"崇安区"

	}); 

		});
	</script>
</head>
<body>

<div id="container">
	<h1>添加客户</h1>

	<div id="body">
            <?php                     
            if(isset($custom)){
                echo form_open('custom/update');
            }
            else {
                echo form_open('custom/insert');                 
            }
            ?>
		<p>客户名称    <?php
                $data = array(
              'name'        => 'v_cname',
              'id'          => 'v_cname',
              'value'       => isset($custom)?$custom->cname:''
            );
                echo form_input($data);
                ?></p>
                <p>客户地址：<div id="city"> 
      <select class="prov"></select>  
    <select class="city" disabled="disabled"></select> 
    <select class="dist" disabled="disabled"></select> 
</div> </p>
                 <p>客户组别<?php
                $js = 'id="v_group_id"';
            echo form_dropdown('v_group_id',$group_list,isset($custom)?$custom->group_id:'0',$js);
                echo form_hidden('hidden_group_id',isset($custom)?$custom->group_id:'0','hidden_category_id');
                ?>
                 </p>
                
                		<p>联系人    <?php
                $data = array(
              'name'        => 'v_cusername',
              'id'          => 'v_cusername',
              'value'       => isset($custom)?$custom->cusername:''
            );
                echo form_input($data);
                ?></p>
            <p>客户电话    <?php
                $data = array(
              'name'        => 'v_ctel',
              'id'          => 'v_ctel',
              'value'       => isset($custom)?$custom->ctel:''
            );
                echo form_input($data);
                ?></p>
            		<p>店铺地址    <?php
                $data = array(
              'name'        => 'v_caddress',
              'id'          => 'v_caddress',
              'value'       => isset($custom)?$custom->caddress:''
            );
                echo form_input($data);
                ?></p>
            
             <p>备注    <?php
                $data = array(
              'name'        => 'v_cbak',
              'id'          => 'v_cbak',
              'value'       => isset($custom)?$custom->cbak:''
            );
                echo form_input($data);
                ?></p>
                

             
             <?php if(isset($custom))
            {
                echo form_hidden('id',$custom->id);
            } ?>
            <?php echo form_submit('mysubmit', '确定')?>
                <?php echo form_close()?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>