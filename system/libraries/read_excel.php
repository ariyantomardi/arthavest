<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once "./excel/phpexcel/phpexcel/IOFactory.php";
$objPHPExcel = PHPExcel_IOFactory::load('./excel/file.xlsx');
$sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

$no = 1;
echo '<table border="1" width="800" align="center">';
foreach($sheet as $row):
   
    echo '<tr>';
    echo '<td><b>'. $no .'</b></td>';
    foreach($row as $key => $val)
        echo '<td>'. $row[$key] .'</td>';
    echo '</tr>';
    $no++;
endforeach;
echo '</table>';