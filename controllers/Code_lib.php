<?php
class Code_lib extends CI_Controller {
	
	/**
	 * 导出 [进货单] 到固定格式的excel
	 */
	public function export_jinhuodan(){
		parent::islogin();
		$_tplName = '/erp/template/jinhuodan.xlsx';
		
		
		
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $reader = IOFactory::createReader('Excel2007');
        $PHPExcel = $reader->load($_tplName);
        $PHPExcel->setActiveSheetIndex(0);
        /*
        		填充数据
        */
        $objWriter = IOFactory::createWriter($PHPExcel, 'Excel2007');
        $_fileName = iconv("UTF-8","GB2312//IGNORE",$_fileName);
        $objWriter ->save(getcwd().'\download\\'.$_fileName.'.xlsx');
        
	}
	

	/**
	 * 导出 [分货单]
	 * 
	 */
	  public function export_fendan(){
	parent::islogin();
		$_tplName = '/erp/template/jinhuodan.xlsx';
		
		
		
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $reader = IOFactory::createReader('Excel2007');
        $PHPExcel = $reader->load($_tplName);
        $PHPExcel->setActiveSheetIndex(0);
        /*
        		填充数据
        */
        $objWriter = IOFactory::createWriter($PHPExcel, 'Excel2007');
        $_fileName = iconv("UTF-8","GB2312//IGNORE",$_fileName);
        $objWriter ->save(getcwd().'\download\\'.$_fileName.'.xlsx');
		
	}
	
	
	
	
	
}
