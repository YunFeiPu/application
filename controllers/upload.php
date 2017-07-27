<?php

class Upload extends CI_Controller {
 
 function __construct()
 {
  parent::__construct();
  $this->load->helper(array('form', 'url'));
 }
 
 function index()
 { 
  $this->load->view('/test/upload_form', array('error' => ' ' ));
 }

 function do_upload()
 {
 	$targetFolder = '/uploads'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
 	/*
  $config['upload_path'] = './download/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg';
  $config['max_size'] = '4096';
  $config['max_width']  = '0';
  $config['max_height']  = '0';
  $config['file_name'] = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1000, 2000);
  
  $this->load->library('upload', $config);
 
  if ( ! @$this->upload->do_upload())
  {
   $error = array('error' => $this->upload->display_errors());
   
   $this->load->view('/test/upload_form', $error);
  } 
  else
  {
	$arr = $this->upload->data();
	$data = array('upload_data' => $this->upload->data());
	$config1['image_library'] = 'gd2';
	$config1['source_image'] = './download/'.$arr['file_name'];
	$config1['create_thumb'] = false;
	$config1['maintain_ratio'] = TRUE;
	$maxlength = 800;
	$width;
	$height;
	if($arr['image_width']>$arr['image_height'] && $arr['image_width']>$maxlength){
		$width = $maxlength;
	    $ratio = $maxlength / $arr['image_width'] ;
    	$height = $arr['image_height']  * $ratio;
	}
	elseif($arr['image_width']<$arr['image_height'] && $arr['image_height']>$maxlength){
		$height = $maxlength;
	    $ratio = $maxlength / $arr['image_height'] ;
    	$width = $arr['image_width']  * $ratio;
	}
	else {
		$height = $arr['image_height'] ;
		$width = $arr['image_width'];
	}
	$config1['width'] = $width;
	$config1['height'] = $height;
	
	$this->load->library('image_lib', $config1); 
	
	$this->image_lib->resize();
   
   $this->load->view('/test/upload_success', $data);
	 }
	 */
  
 } 
}
?>