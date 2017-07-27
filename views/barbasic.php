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
            text: '月销售额'
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
                text: '销售金额 (元)'
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
		</script>
	</head>
	<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
