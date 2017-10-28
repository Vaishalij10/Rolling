<?php
// THIS PAGE IS TO GET THE DETAIS OF THE PERHEATPRODUCTION THE EXCEL
/** FETCH THE DATA FROM THE PER HEAT PRODUCTION TABLE AND FORMATTED IN THE EXCEL FORMAT
/**DATE        CHANGESINTHESECTION                  USERNAME 
 * 2017-09-12   CODE IS COMPLETED IN THE PROD       VAISHALI JAIN 
 * 
 * 
 * 
 * 
 * 
 */
include ('../Connection.php');

session_start();
$date1 = $_SESSION["date1"];
$date2 = $_SESSION["date2"];

 $res_ex = mysqli_query($link,"select `perheatdate`,`roughing`,
             `m1s1`,`m1s2`,`m2s1`,`m2s2`,`heat-number`,`heat-start-time`,`heat-end-time`,
             `total-heat-time`,`total_bd_time`,`3mtrbwt(m1s1)`, `rolledpcs(m1s1)`,
             `3mtrbwt(m1s2)`,`rolledpcs(m1s2)`,`3mtrbwt(m2s1)`,
             `rolledpcs(m2s1)`,`3mtrbwt(m2s2)`,`rolledpcs(m2s2)`,
             `3st3mtrbbp`,  `3st6mtrbbp`,`3st3mtrbwt`,`3st6mtrbwt`,
             `ccm3mtrbwt`,`ccm3mtrbbp`,`ccm6mtrbwt`,`ccm6mtrbbp`,`bbpurelyccm`,`missroll`,`cum_missroll`,
            `millmrprod`,`rfmrprod`,`cum_rfmrprod`,`bbprodmill`,`bbprodccm`,`bbprod3st`,`bbprodfnce`,`bbprodmpeb`,
            `bbprodcontr`,`bbprodother`,`m1s1prod`,`m1s2prod`,`m2s1prod`,`m2s2prod`,`8mm`,`10mm`,`12mm`,`16mm`,`20mm`,`25mm`,
            `28mm`,`32mm`,`rollingprod`,`cum_rollingprod`,`ccmprod`,`cum_ccmprod`,`hotrolling`,`cum_hotrolling`,`perbbpmill`,
            `perbbpccm`,`perbbp3st`,`perbbpfnce`,`perbbpmpeb`,`perbbpcontr`,`perbbpother`
            from per_heat_production 
            where perheatdate >= '$date1' and perheatdate <= '$date2' order by perheatdate");
 
 
 
$columnHeader = '';
$columnHeader = "Date" . "\t" .
        "Roughing" . "\t" .
        "m1s1" . "\t" .
        "m1s2" . "\t" .
        "m2s1" . "\t" .
         "m2s2" . "\t" .
        "Heat No" . "\t" .
        " Heat Start time" . "\t" .
        "Heat End time" . "\t" .
        "Total heat time" . "\t" .
        "Total BD time" . "\t" .
        "3mtrbwt(m1s1)" . "\t" .
        "rolledpcs(m1s1)</" . "\t" .
        "3mtrbwt(m1s2)" . "\t" .
        "rolledpcs(m1s2)</" . "\t" .
        "3mtrbwt(m2s1)" . "\t" .
        "rolledpcs(m2s1)</" . "\t" .
        "3mtrbwt(m2s2)" . "\t" .
        "rolledpcs(m2s2)</" . "\t" .
        "3st3mtrbbp" . "\t" .
        "3st6mtrbbp" . "\t" .
        "3st3mtrbwt" . "\t" .
        "3st6mtrbwt" . "\t" .
        "ccm3mtrbwt" . "\t" .
        "ccm3mtrbbp" . "\t" .
        "ccm6mtrbwt" . "\t" .
        "ccm6mtrbbp" . "\t" .
        "bbpurelyccm" . "\t" .
        "missroll" . "\t" .
        "cum-missroll" . "\t" .
        "MillmrProd" . "\t".
        "RFmrprod" . "\t".
        "cum-RFmrprod" . "\t".
        "bbprodmill" . "\t".
        "bbprodccm" . "\t".
        "bbprod3st" . "\t".
        "bbprodfnce" . "\t".
        "bbprodmpeb" . "\t".
        "bbprodcontr" . "\t".
        "bbprodother" . "\t".
        "m1s1prod" . "\t".
        "m1s2prod" . "\t".
        "m2s1prod" . "\t".
        "m2s2prod" . "\t".
        "8mm" . "\t".
        "10mm" . "\t".
        "12mm" . "\t".
        "16mm" . "\t".
        "20mm" . "\t".
        "25mm" . "\t".
        "28mm" . "\t".
        "32mm" . "\t".
        "rollingprod" . "\t".
        "cum-rollingprod" . "\t".
        "ccmprod" . "\t".
        "cum-ccmprod" . "\t".
        "hotrolling" . "\t".
        "cum-cumhotrolling" . "\t".
        "perbbpmill" . "\t".
        "perbbpccm" . "\t".
        "perbbp3st" . "\t".
        "perbbpfnce" . "\t".
        "perbbmpeb" . "\t".
        "perbbcontr" . "\t".
        "perbbother" . "\t"
       
        ;

$setData = '';

while ($rec_ex = mysqli_fetch_row($res_ex)) {
    $rowData = '';
    foreach ($rec_ex as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
    }
    $setData .= trim($rowData) . "\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=PerheatProduction.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";
?> 