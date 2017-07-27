<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_m extends CI_Model{
	
	function img_resize( $tmpname, $size, $save_dir, $save_name, $maxisheight = 0 ){
	    $save_dir     .= ( substr($save_dir,-1) != "/") ? "/" : "";
	    $gis        = getimagesize($tmpname);
	    $type        = $gis[2];
	    switch($type)
        {
		    case "1": $imorig = imagecreatefromgif($tmpname); break;
		    case "2": $imorig = imagecreatefromjpeg($tmpname);break;
		    case "3": $imorig = imagecreatefrompng($tmpname); break;
		    default:  $imorig = imagecreatefromjpeg($tmpname);
        }
        $x = imagesx($imorig);
        $y = imagesy($imorig);
        $woh = (!$maxisheight)? $gis[0] : $gis[1] ;  
        if($woh <= $size)
        {
	        $aw = $x;
	        $ah = $y;
        }
        else
        {
            if(!$maxisheight){
                $aw = $size;
                $ah = $size * $y / $x;
            } else {
                $aw = $size * $x / $y;
                $ah = $size;
            }
        } 
        $im = imagecreatetruecolor($aw,$ah);
	    if (imagecopyresampled($im,$imorig , 0,0,0,0,$aw,$ah,$x,$y)){
	        if (imagejpeg($im, $save_dir.$save_name))
	            return true;
	        else
	            return false;
		}
	}//img_resize

 }
 