<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');
require_once BC_ZHYY_ROOT . '/class/phpexcel/PHPExcel.php';
require_once BC_ZHYY_ROOT . '/class/util.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("润衡科技")->setLastModifiedBy("润衡科技")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document");


	foreach($titles as $k => $title){
		$col = BC::getExcelColumn($k + 1 ).'1';
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col, $title);
	}
    $i = 2;
	
	
    foreach ($list as $item) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A' . $i, $item['id'],PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('B' . $i, $item['nickname'])->setCellValue('C' . $i, $item['openid'])->setCellValue('D' . $i, date('Y-m-d  H:i:s', $item['createtime']));
		foreach($item as $field => $m){
			foreach($sn as $r => $n){
				if ($n == $field){
					$p = BC::getExcelColumn($r + 5 );
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($p . $i, $m);
					break;
				}
			}
		}
        $i++;
    }
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$col)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objPHPExcel->getActiveSheet()->setTitle($reply['form_theme'].'-用户数据');

$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report_' . time() . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
