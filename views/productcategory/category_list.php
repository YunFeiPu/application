<option value="0" >不选择</option>
<?php foreach ($category_list as $item) :?>
<option value="<?php echo $item->id;?>" ><?php echo $item->description;?></option>
<?php endforeach; ?>

