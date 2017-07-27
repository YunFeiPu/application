<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>
		<script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
	var mycars=new Array( 
				'一月',
                '二月',
                '三月',
                '四月',
                '五月',
                '六月',
                '七月',
                '八月',
                '九月',
                '十月',
                '十一月',
                '十二月');
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '月利润'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: mycars,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '金额 (元)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} 元</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
		<?php $index = 1; ?>
		<?php foreach($category as $year):?>
		{
            name: '<?php echo $year; ?>年',
            data: [<?php echo $item[$year]; ?>]

        }<?php if($index < count($category)){
				echo ",";
			} ?>
		<?php endforeach; ?>
		]
    });
});





$(function () {
    $('#container2').highcharts({
        title: {
            text: '2015年供应商月利润',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: ['一月',
                '二月',
                '三月',
                '四月',
                '五月',
                '六月',
                '七月',
                '八月',
                '九月',
                '十月',
                '十一月',
                '十二月']
        },
        yAxis: {
            title: {
                text: '元 (元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '元'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '融字号年',
            data: [2450,602,1634,2963,1881,1659,10,0,0,0,0,0]

        },				{
            name: '味中仙年',
            data: [13204,6200,16732,18484,14432,18041,17480,32864,35808,39124,48446,56862]

        },				{
            name: '凌记年',
            data: [2169,527,4156,1791,1678,1495,2086,1893,2295,4035,3317,2141]

        },				{
            name: '丁丁年',
            data: [4560,2199,11516,13938,9428,10300,11160,22764,25500,30086,33651,34178]

        },				{
            name: '送货包装其它费用年',
            data: [-1135,923,304,-479,-655,-1270,57,179,772,569,-3984,-577]

        },				{
            name: '愚记年',
            data: [302,120,344,552,361,370,567,385,266,916,1350,774]

        },				{
            name: '宽德兴年',
            data: [44,0,0,0,0,0,0,0,0,0,0,0]

        },				{
            name: '金香粟年',
            data: [386,160,40,0,0,0,0,0,0,313,5,0]

        },				{
            name: '水军私房海鲜料理年',
            data: [4933,1637,6035,13277,6840,2609,5169,12269,24322,15894,19252,20084]

        },				{
            name: '正品之优年',
            data: [1294,548,686,772,472,0,0,0,0,0,0,0]

        },				{
            name: '优糯年',
            data: [314,111,0,4103,4200,3997,1671,837,312,205,4905,40195]

        },				{
            name: '荡口特产年',
            data: [1779,720,741,0,0,0,0,0,0,10633,13336,8341]

        },				{
            name: '进口水果年',
            data: [56,0,0,0,0,0,0,0,0,0,0,0]

        },				{
            name: '常州美食年',
            data: [16871,5721,19427,40847,28096,27901,36669,42136,55293,102607,143822,145812]

        },				{
            name: '陈麻婆年',
            data: [416,136,78,12,0,0,0,0,0,0,0,0]

        },				{
            name: '夜食堂年',
            data: [8,14,0,0,0,0,0,0,0,0,0,0]

        },				{
            name: '常州吃户家年',
            data: [0,0,0,122,0,471,1158,1113,1048,1116,1325,7315]

        },				{
            name: '周茉年',
            data: [0,0,0,13386,8361,3747,4004,20628,25797,6539,3221,9845]

        },				{
            name: '虾一跳年',
            data: [0,0,0,0,1914,3082,2103,2542,234,0,0,0]

        },				{
            name: 'cocofrans年',
            data: [0,0,0,0,1300,494,2551,1809,408,0,0,752]

        },				{
            name: '玛呀玛咔年',
            data: [0,0,0,0,504,0,0,0,0,0,0,0]

        },				{
            name: '乐菋源年',
            data: [0,0,0,0,1830,23731,15308,3021,948,0,1085,0]

        },				{
            name: '台湾代购年',
            data: [0,0,0,0,0,1900,800,60,10,0,0,0]

        },				{
            name: '林记私房料理年',
            data: [0,0,0,0,0,126,146,0,0,0,0,0]

        },				{
            name: '磨洋工坊年',
            data: [0,0,0,0,0,0,1069,617,0,0,0,0]

        },				{
            name: '指尖奶茶年',
            data: [0,0,0,0,0,0,1873,1063,80,0,0,0]

        },				{
            name: '阿新零食年',
            data: [0,0,0,0,0,0,0,48,0,0,0,0]

        },				{
            name: '客来品年',
            data: [0,0,0,0,0,0,0,2888,5400,540,0,0]

        },				{
            name: '宜兴美食年',
            data: [0,0,0,0,0,0,0,91,0,0,0,0]

        },				{
            name: '泰州吃货联盟年',
            data: [0,0,0,0,0,0,0,1723,7181,4552,5508,6156]

        },				{
            name: '密码冰盒年',
            data: [0,0,0,0,0,0,0,1009,305,0,0,0]

        },				{
            name: '江阴囡囡年',
            data: [0,0,0,0,0,0,0,659,1190,176,0,0]

        },				{
            name: '周浦食品年',
            data: [0,0,0,0,0,0,0,0,5720,499,886,777]

        },				{
            name: '镇江美食年',
            data: [0,0,0,0,0,0,0,0,1289,1183,1485,2251]

        },				{
            name: '李斌年',
            data: [0,0,0,0,0,0,0,0,1625,1921,344,0]

        },				{
            name: '常州月饼年',
            data: [0,0,0,0,0,0,0,0,2781,0,0,0]

        },				{
            name: '佐佐甜品年',
            data: [0,0,0,0,0,0,0,0,644,0,0,0]

        },				{
            name: '鸿运大包年',
            data: [0,0,0,0,0,0,0,0,1732,5722,8473,9101]

        },				{
            name: '日化产品之花王年',
            data: [0,0,0,0,0,0,0,0,49,18,214,68]

        },				{
            name: '日化产品年',
            data: [0,0,0,0,0,0,0,0,533,765,156,260]

        },				{
            name: '聚成源年',
            data: [0,0,0,0,0,0,0,0,3491,9399,18498,21460]

        },				{
            name: '张家港吃新逛想年',
            data: [0,0,0,0,0,0,0,0,430,0,0,0]

        },				{
            name: '孙府年',
            data: [0,0,0,0,0,0,0,0,1415,5680,1755,2100]

        },				{
            name: '木子年',
            data: [0,0,0,0,0,0,0,0,0,274,52,13848]

        },				{
            name: '甜品星球年',
            data: [0,0,0,0,0,0,0,0,0,1567,1742,1312]

        },				{
            name: '泰州食光机年',
            data: [0,0,0,0,0,0,0,0,0,186,146,0]

        },				{
            name: '上海贸易公司年',
            data: [0,0,0,0,0,0,0,0,0,0,172,0]

        },				{
            name: '乐陶年',
            data: [0,0,0,0,0,0,0,0,0,0,14659,6686]

        },				{
            name: '私厨老王家年',
            data: [0,0,0,0,0,0,0,0,0,0,8048,11969]

        },				{
            name: '不二家年',
            data: [0,0,0,0,0,0,0,0,0,0,3385,3479]

        },				{
            name: '食刻享你年',
            data: [0,0,0,0,0,0,0,0,0,0,520,292]

        },				{
            name: '浙江代购年',
            data: [0,0,0,0,0,0,0,0,0,0,1989,3873]

        },				{
            name: '阳山糕团店年',
            data: [0,0,0,0,0,0,0,0,0,0,1327,6891]

        },				{
            name: '亿秦园年',
            data: [0,0,0,0,0,0,0,0,0,0,0,300]

        },				{
            name: '小林年',
            data: [0,0,0,0,0,0,0,0,0,0,0,1854]

        },				{
            name: '大琪年',
            data: [0,0,0,0,0,0,0,0,0,0,0,6606]

        },				{
            name: '淘米米年',
            data: [0,0,0,0,0,0,0,0,0,0,0,165]

        },				{
            name: '花园饼屋年',
            data: [0,0,0,0,0,0,0,0,0,0,0,140]

        }]
    });
});



$(function () {
    $('#container3').highcharts({
        title: {
            text: '2016年供应商月利润',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: ['一月',
                '二月',
                '三月',
                '四月',
                '五月',
                '六月',
                '七月',
                '八月',
                '九月',
                '十月',
                '十一月',
                '十二月']
        },
        yAxis: {
            title: {
                text: '元 (元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '元'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [<?php $index = 1; ?>
		<?php foreach($category1 as $year):?>
		{
            name: '<?php echo $year; ?>年',
            data: [<?php echo $item1[$year]; ?>]

        }<?php if($index < count($category1)){
				echo ",";
			} ?>
		<?php endforeach; ?>]
    });
});
		</script>
        
        
        
        
        
	</head>
	<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<div id="container2" style="min-width: 310px; height: 800px; margin: 0 auto"></div>

<div id="container3" style="min-width: 310px; height: 800px; margin: 0 auto"></div>
	</body>
</html>
