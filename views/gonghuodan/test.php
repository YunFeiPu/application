<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<table width="100%" class="TR_MOUSEOVER   TOGGLE" border = 1>
        <caption>
           订单列表</caption>
        <thead>
            <tr>
                <th>名称</th><th>金额</th>
                
            </tr>
        </thead>
        
        <tbody>
            <?php $total = 0;?>
           <?php if(isset($item_list)) :?>
            
           <?php foreach ($item_list as $item)://custom_list?>
                <tr>
                    <td><?php echo $item->gysname;?></td>
                    <td><?php echo $item->total;?></td>
                    
                </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
        
    </table>
    </body>