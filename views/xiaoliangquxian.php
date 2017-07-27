<meta charset="utf-8">
<?php foreach ($item_list as $item)://custom_list?>

<?php echo $item->pname .":" .$item->total_count ;?>
<a href="<?php echo base_url()?>welcome/checkquxian/<?php echo $item->pid ?>">查看最近6个月销量</a><br />
<?php endforeach;?>

<?php //当月 产品销量 ?>