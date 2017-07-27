<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	
	function barcode(){
		$this->load->library('Barcode');
		$bc = new Barcode39("201609041658411975"); 

// display new barcode 
$bc->draw();
	}
	
	function admintest(){
		$this->load->model('ci_admin_m');
		$result = $this->ci_admin_m->updatepassword("kdevil","admin888","kdevil27423015");

	}
	
	
	function upload(){
		$this->load->view('test/webuploader');
	}
	
	
	function webuploader(){
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}


if ( !empty($_REQUEST[ 'debug' ]) ) {
    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
    if ( $random === 0 ) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = 'upload_tmp';
$uploadDir = 'download';

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
    @mkdir($targetDir);
}

// Create target dir
if (!file_exists($uploadDir)) {
    @mkdir($uploadDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
    $fileName =  $_REQUEST["name"];
} elseif (!empty($_FILES)) {
    $fileName =  $_FILES["file"]["name"];
} else {
    $fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
if ($cleanupTargetDir) {
    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    }

    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
            continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

$index = 0;
$done = true;
for( $index = 0; $index < $chunks; $index++ ) {
    if ( !file_exists("{$filePath}_{$index}.part") ) {
        $done = false;
        break;
    }
}
if ( $done ) {
    if (!$out = @fopen($uploadPath, "wb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if ( flock($out, LOCK_EX) ) {
        for( $index = 0; $index < $chunks; $index++ ) {
            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                break;
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($in);
            @unlink("{$filePath}_{$index}.part");
        }

        flock($out, LOCK_UN);
    }
    @fclose($out);
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
	
	function addnickajax(){
		parent::islogin();
		$nickname = $_POST['nickname'];
		$pname = $_POST['pname'];
		//echo $nickname.$pname;
		throw new Exception("not finished");
	}
	
	function getpinyin(){
		//@TODO
		/*
		$this->load->library('getpingying');
		//$aaa =  urldecode($this->uri->segment(3,'大家好'));
	//	echo $this->getpingying->conv($aaa);
		$this->load->model('product_m');
		$query = $this->product_m->getall();
		foreach($query as $item){
			$arr = array(
'py' => $this->getpingying->conv($item->pname),
);

$this->product_m->update($item->id,$arr);
*/
		//}
		
		//echo "<br /> ".$this->getpingying->getpinyin1($aaa);zh2py::conv('Chinese 中华人民共和国');
	}
	
	
	function index(){
		//第一步要把中文全角标点替换成半角
		//去掉单位罐合盒个包
		
		//整理数据   开始；
		parent::islogin();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		
			$str = $_POST['txt_name'] ;
			//echo $str."<br/>";
			 $arr_str= array("\r\n", "\n", "\r");
			 $str = str_replace($arr_str, '',$str);
			 $arr_str= array('，',' 。',',','.',' ');
			 $str = str_replace($arr_str, '',$str);
			//$str=str_replace('，', '', $str);
			$arr_str = array('罐','合','盒','个','包');
			$str = str_replace($arr_str, '',$str);
			//print_r($str);
			//整理数据   结束;
			
			//分析数据 开始
			
			
			$seek = array();
			//$text = "I have a dream that one day I can make it. So just do it, nothing is impossible!";
		//	$text = "深海大蟹脚3不辣鸭脖2鸡翅2鹌鹑蛋2锅巴10小龙虾2 ";
			//将字符串按空白，标点符号拆分（每个标点后也可能跟有空格） [\\u4e00-\\u9fa5]+|\\d+  [\x{4e00}-\x{9fa5}]
			$words = preg_split("/([x00-xff]+)|([0-9]+)/", $str,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($words as $val)
			{
				//echo($val .'<br />');
			}
			
			$arrlength=count($words);
			$new_arr = array();
			for($x=0;$x<$arrlength-1;$x=$x+2) {
				//echo $words[$x].'->'.$words[$x+1];
				//echo "<br>";
				$new_arr[$words[$x]] = $words[$x+1];
			}
			//var_dump($new_arr);
			$this->load->model('quickorder_m');
			$item_list = Array();
			foreach($new_arr as $nickname=>$qty){
				$arr = $this->quickorder_m->getbynickname($nickname);
				$aa = new stdClass();
				if(isset($arr)){
					
					
					foreach($arr->result() as $item){
						$aa->nickname = $nickname;
						$aa->qty = $qty;
						$aa->pname = $item->pname;
						$aa->isfound = TRUE;
						array_push($item_list,$aa);
						//echo $nickname . ' ' . $qty.  "     找到匹配项   ;" . $item->pname. '   =>     '. $qty. ' .<br />' ;
					}
				}
				else{
					$aa->nickname = $nickname;
					$aa->qty = $qty;
					$aa->pname = '';
					$aa->isfound = FALSE;
					array_push($item_list,$aa);
					//echo  $nickname . ' ' . $qty.  " 没有匹配项目 <br />";
				}
			}
			
			$data['item_list'] = $item_list;
			$this->load->model('productcategory_m','category_m');
			
			
			$data['category_list'] = $this->category_m->getbypid(0);
		
			$this->load->view('test/quickorder',$data);
		}

		//根据名称匹配产品
		/*
		 * 先匹配昵称表 如没有符合的再匹配产品标
		 * 
		 * */

		
		
		
		
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			$this->load->view('test/quickorder');
		}
		else{

		}
		
		
		
		
	}

	function order_main(){
		parent::islogin();
		$this->load->database();

		$query = $this->db->query("select cid,oid,sum(ptotal),order_state,otime from `order` group by oid order by cid,otime");
		if($query->num_rows()>0){
			foreach ($query->result() as $item){
				$sql = "UPDATE `order_main`
						SET
						`order_total_old` = ?,
						`order_total_new` = ?,
						`order_state` = ?
						WHERE `id` = <{expr}>;";
			}
		}
	}

}