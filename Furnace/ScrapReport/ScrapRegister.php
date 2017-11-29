<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include('..\Connection.php');

session_start();
$date1 = $_SESSION["date1"];
$date2 = $_SESSION["date2"];





$res = mysqli_query($conn, "SELECT `Date`, `scraptype`, `furnacename`, `stock`, `sr%`, `asc%` FROM `scrap register` sr,scrap s,
         furnace f WHERE s.scrapid=sr.scrapid and f.furnaceid=sr.furnaceid and sr.Date >='$date1' and  sr.Date <= '$date2' order by date ");

//$setRec = mysqli_query($conn, $res);  

$columnHeader = '';
$columnHeader = "Date" . "\t" .
        "Scrap Type" . "\t" .
        "Furnace" . "\t" .
        "Stock" . "\t" .
        "Sr%" . "\t" .
        "Asc%" . "\t" 
       ;

$setData = '';


while ($rec = mysqli_fetch_row($res)) {
    $rowData = '';
    foreach ($rec as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
    }
    $setData .= trim($rowData) . "\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename= Scrap_Register.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";
?> 