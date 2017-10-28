<?php

// ADD PER HEAT FORM , ALL THE PRODUCTION RELATED VALUES MUST BE CALCULATED IN METRIC TON.
// ESTABLISHING CONNECTION TO THE DATBASE
//MODIFIED DATE -19/09/2017 , CORRECTED THE CUM-HOTROLLING PERCENTGE AND ROUGHING MR PRODUCTION
require_once("..\Connection.php");
//
require_once("..\DBfile.php");
// TO SEND MESAGE TO THE SLACK CHANNEL
require_once("..\postMessagesToSlack.php");
//INITIALLIZING VARIABLE FOR CALCULATIONS
$cum_totalmissroll=0;
$bbprodmill = $bbprodmpeb = $rfmrprod = $bbprodccm = 0;
$m1s1prod = $m1s2prod = $m2s1prod = $m2s2prod = 0;
$cum_totalrollprod=0;
$final8 =$final12 =$final10=$final16= $final20 =$final25=$final28 =$final32='';
$rpm1s1 = $rpm1s2 = $rpm2s1 = $rpm2s2 = 0;
$bwt3m3s = $bwt6m3s = 0;
$ccmprod = $totalrollingprod = $totalhotrolng = 0;
$prod8mm = $prod10mm = $prod12mm = $prod16mm = $prod20mm = $prod25mm = $prod28mm = $prod32mm = 0;


function lz($num) {
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

//CONVERTING THE DATE IN TO YYYY-MM-DDD
$date_ph = strtr($_REQUEST['perheatdate'], '/', '-');
//echo $date_ph;
$per_date = date('Y-m-d', strtotime($date_ph));
//$per_heat_date = date('d-m-Y', strtotime($date1));

//echo $per_date;

// Sizes from the DB file 
$m1s1 = RollingBD::getInstance()->get_size_id($_POST['m1s1']);
$m1s2 = RollingBD::getInstance()->get_size_id($_POST['m1s2']);
$m2s1 = RollingBD::getInstance()->get_size_id($_POST['m2s1']);
$m2s2 = RollingBD::getInstance()->get_size_id($_POST['m2s2']);

//VALUES ENTERED IN THE FORM 
$heatnumber = $_POST['heatnumber'];
$roughing = $_POST['roughing'];
$bwt3mccm = $_POST['3mtrbwtccm'];
$bbp3mccm = $_POST['3mtrbbpccm'];
$bwt6mccm = $_POST['6mtrbwtccm'];
$bbp6mccm = $_POST['6mtrbypassccm'];
$bbp3st3m = $_POST['bbp3mtr3s'];
$bbp3st6m = $_POST['bbp6mtr3s'];
$bwt3m3s = $_POST['bwt3m3s'];
$bwt6m3s = $_POST['bwt6m3s'];
$heatstarttime = $_POST['heatstarttime'];
$heatendtime = $_POST['heatendtime'];
$bwt3mtm1s1 = $_POST['3mbwtm1s1'];
$rpm1s1 = $_POST['rpm1s1'];
$bwt3mtm1s2 = $_POST['3mbwtm1s2'];
$rpm1s2 = $_POST['rpm1s2'];
$bwt3mtm2s1 = $_POST['3mbwtm2s1'];
$rpm2s1 = $_POST['rpm2s1'];
$bwt3mtm2s2 = $_POST['3mbwtm2s2'];
$rpm2s2 = $_POST['rpm2s2'];



//CALCULATED TIME IN HH:MM
$totalheattime = abs(strtotime($heatendtime) - strtotime($heatstarttime)) / 3600;
$seconds_ph = ($totalheattime * 3600);
$hours_ph = floor($totalheattime);
$seconds_ph -= $hours_ph * 3600;
$minutes_ph = floor($seconds_ph / 60);
$seconds_ph -= $minutes_ph * 60;
$totalheattime = lz($hours_ph) . ":" . lz($minutes_ph);

//BILLETS BYPASS PRODUCTION PURELY DUE TO CCM
$bbppurelyccm = round((($bwt3mccm * $bbp3mccm) + ($bwt6mccm * $bbp6mccm)) / 1000, 3);
//BILLETS BYPASS PRODUCTION DUE TO 3RD STAND 
$bbpprod3st = round((($bbp3st3m * $bwt3m3s) * ($bbp3st6m * $bwt6m3s * 2)) / 1000, 3);

//TOTAL BILLETS BYPASS PRODUCTION DUE TO MILL(MILL, MECHANICAL AND ELECTRICAL) CALCULATED FROM THE BREAKDOWN FORM 
$sql_mill = "SELECT sum(b.total_bbp_production) FROM `breakdown` b,`department` d  where b.department=d.departmentid and
          `date` = '" . $per_date . "'and `heat_number` = '" . $heatnumber . "' AND d.dname in('Electrical','Mechanical','Mill')";

$result_mill = mysqli_query($link, $sql_mill);
if (!$result_mill) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
echo mysqli_num_rows($result_mill);
$row_mill = mysqli_fetch_row($result_mill);
$bbprodmill = $row_mill[0];
echo 'prod mill'; echo $bbprodmill;

//BILLETS BYPASS PRODUCTION DUE TO FURNACE (CALUCLATED FROM THE BREAKDOWN FORM )
$sql_furnace = "SELECT sum(`total_bbp_production`) FROM `breakdown` b,`department` d  where b.department=d.departmentid and `date` = '" . $per_date . "' "
        . " and `heat_number` = '" . $heatnumber . "' AND d.dname ='Furnace' ";


$result_furnace = mysqli_query($link, $sql_furnace);
if (!$result_furnace) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
$row_furnace = mysqli_fetch_row($result_furnace);
$bbprodfnce = $row_furnace[0];
echo 'in Furnace';
echo $bbprodfnce;


//BILLETS BYPASS PRODUCTION DUE TO MPEB(CALCULATED FROM THE MPEB)
$sql_mpeb = "SELECT sum(`total_bbp_production`) FROM `breakdown` b,`department` d  where b.department=d.departmentid and 
        `date` = '" . $per_date . "' and `heat_number` = '" . $heatnumber . "' AND d.dname ='MPEB' ";

$result_mpeb = mysqli_query($link, $sql_mpeb);
if (!$result_mpeb) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
$row_mpeb = mysqli_fetch_row($result_mpeb);
$bbprodmpeb = $row_mpeb[0];

echo 'in MPEB';
echo $bbprodmpeb;

//BILLETS BYPASS PRODUCTION DUE TO OTHERS (CALCULATED FROM THE BREAKDOWN)

$sql_other = "SELECT sum(`total_bbp_production`) FROM `breakdown` b,`department` d where b.department=d.departmentid and
          `date` = '" . $per_date . "'and `heat_number` = '" . $heatnumber . "' AND d.dname ='Others' ";
$result_other = mysqli_query($link, $sql_other);
if (!$result_other) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
$row_other = mysqli_fetch_row($result_other);
$bbprodother = $row_other[0];
// BILLETS BYPASS PRODUCTION DUE TO CONTRACTOR 

$sql_cont = "SELECT sum(`total_bbp_production`) FROM `breakdown` b,`department` d  where b.department=d.departmentid and
          `date` = '" . $per_date . "' and `heat_number` = '" . $heatnumber . "' and dname ='Contractor' ";

$result_cont = mysqli_query($link, $sql_cont);
if (!$result_cont) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
$row_cont = mysqli_fetch_row($result_cont);
$bbprodcont = $row_cont[0];
//echo 'in contractor';

//BILLETS BYPASS PRODUCTION DUE TO CCM 


$sql_ccm = "SELECT sum(`total_bbp_production`) FROM `breakdown` b,`department` d   where b.department=d.departmentid and
          `date` = '" . $per_date . "' and `heat_number` = '" . $heatnumber . "' AND dname ='CCM' ";
$result_ccm = mysqli_query($link, $sql_ccm);
//echo 'in result';
if (!$result_ccm) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
//echo 'after';
$row_ccm = mysqli_fetch_row($result_ccm);
//echo 'after1';
//echo $row_ccm[0];
$bbprodccm = $row_ccm[0] + $bbppurelyccm;
//echo 'after2';

//ho 'in ccm';
//ho $bbprodccm;

//TOTAL MISS ROLL PRODUCTION DUE to 18"rf,16"dc,16"rf,14"rf,conveyor,centre line, all-mill, THIS ISCALLED AS ROUGHING PRODUCTION
$sql_rf = "select sum(mr_production) from breakdown where date='" . $per_date . "' and heat_number= '" . $heatnumber . "'  and location_code in (1,2,3,4,5,6,11,14)";
echo 'after3';
$result_rf = mysqli_query($link, $sql_rf);
$row_rf = mysqli_fetch_row($result_rf);
$rfmrprod = $row_rf[0];

//echo 'hi1';
// CALCULATIONS FOR THE CUMMMULATIVE ROUGHING PRODUCTION 
if ($heatnumber == 1) {
    $cum_rfmrprod = $rfmrprod;
    echo $cum_rfmrprod;
} else {
    $cummHeatNumber = ($heatnumber - 1);
    $sql_mrprod = "select sum(mr_production) from breakdown where  date='" . $per_date . "' and heat_number= '" . $cummHeatNumber . "'  and location_code in (1,2,3,4,5,6,11,14)";
    $result_mrprod = mysqli_query($link, $sql_mrprod);
    if (!$result_mrprod) {
        echo 'MySQL Error: ' . mysqli_error($link);
        exit;
    }
    $row_mrprod = mysqli_fetch_row($result_mrprod);
    $cum_rfmrprod = $row_mrprod[0] + $rfmrprod;
    echo 'hi2';
}

//CALCULATIION FOR THE MISSROLL PRODUCTION  due to mill-1 mill-1 dc, mill-2 mill-2 dc , cooling bed mill-1 , cooling bed mill-2

$sql_1 = "select sum(mr_production) from breakdown where  date='" . $per_date . "' and heat_number= '" . $heatnumber . "' and location_code in(7,8,9,10,12,13)";
$res_1 = mysqli_query($link, $sql_1);
$row_1 = mysqli_fetch_row($res_1);
$millmrprod = $row_1[0];
echo 'miss roll prod';
echo $millmrprod;

//BREAKDOWN TIME IN IN THAT PARTICULAR HEAT CACULATED FROM THE BREAKDOWN TABLE  
$sql_bd = "select sum(bd_total_time) from breakdown where date='" . $per_date . "' and heat_number= '" . $heatnumber . "' ";
$result_bd = mysqli_query($link, $sql_bd);
$row_bd = mysqli_fetch_row($result_bd);

$totalbdtime = $row_bd[0];




// TOTAL MISSROLL  IN THE PARTICULAR HEAT
$sql_mr = "select sum(total_mr) from breakdown where date='" . $per_date . "' and heat_number= '" . $heatnumber . "'  ";
$result_mr = mysqli_query($link, $sql_mr);
$row_mr = mysqli_fetch_row($result_mr);
$totalmissroll = $row_mr[0];
//echo "missroll<br>";
//echo $totalmissroll;

//SIZE WISE AND MILL WISE PRODUCTION CALCULATION

$m1s1prod = round(($bwt3mtm1s1 * $rpm1s1) / 1000, 3);
$m1s2prod = round(($bwt3mtm1s2 * $rpm1s2) / 1000, 3);
$m2s1prod = round(($bwt3mtm2s1 * $rpm2s1) / 1000, 3);
$m2s2prod = round(($bwt3mtm2s2 * $rpm2s2) / 1000, 3);

/**echo 'millprod';
echo $m1s1prod;
echo" ";
echo $m1s2prod;
echo " ";
echo $m2s1prod;
echo " ";
echo $m2s2prod;**/
// TOTAL MISSROLL PERCENTAGE CALCULATION
$totalmrprod=$millmrprod+$rfmrprod;


//CALCUALATION TO CALCUALTION THE PRODUCTION OF EVERY SIZE LIKE 8MM,10MM,12MM,16MM,20MM,25MM,28MM,32MM

//8mm

if ($m1s1 == 8) {
    echo 'size';
    $prod8mm = number_format((float)$m1s1prod,3,'.','');

    $final8 = $m1s1 . ' = ' . $prod8mm;

    
}
if ($m1s2 == 8) {
    $prod8mm = number_format((float)($prod8mm + $m1s2prod),3,'.','');
    $final8 = $m1s2 . ' = ' . $prod8mm;
}
if ($m2s1 == 8) {
    $prod8mm = number_format((float)($prod8mm + $m2s1prod),3,'.','');
    $final8 = $m2s1 . ' = ' . $prod8mm;
}
if ($m2s2 == 8) {
    $prod8mm = number_format((float)($prod8mm + $m2s2prod),3,'.','');
    $final8 = $m2s2 . ' = ' . $prod8mm;
}
//10 mm
//$m1s1prod=0;
//$m1s2prod=0;
//$m2s1prod=0;
//$m2s2prod=0;


if ($m1s1 == 10) {
    $prod10mm = number_format((float) $m1s1prod,3,'.','');
    $final10 = $m1s1 . ' = ' . $prod10mm;
   /** echo "10mm";
    echo $prod10mm;
    echo "<br>";**/
}

if ($m1s2 == 10) {
    $prod10mm = number_format((float)($prod10mm + $m1s2prod),3,'.','');
    $final10 = $m1s2 . ' = ' . $prod10mm;
}
if ($m2s1 == 10) {
    $prod10mm = number_format((float)($prod10mm + $m2s1prod),3,'.','');
    $final10 = $m2s1 . ' = ' . $prod10mm;
}
if ($m2s2 == 10) {
    $prod10mm = number_format((float)($prod10mm + $m2s2prod),3,'.','');
    $final10 = $m2s2 . ' = ' . $prod10mm;
}
//12mm

if ($m1s1 == 12) {
    echo 'in 12 mm';
    $prod12mm = number_format((float)$m1s1prod,3,'.','');
    $final12 = $m1s1 . ' = ' . $prod12mm;
}
if ($m1s2 == 12) {
    $prod12mm = number_format((float)($prod12mm + $m1s2prod),3,'.','');
    $final12 = $m1s2 . ' = ' . $prod12mm;
}

if ($m2s1 == 12) {
    $prod12mm = number_format((float)($prod12mm + $m2s1prod),3,'.','');
    $final12 = $m2s1 . ' = ' . $prod12mm;
}
if ($m2s2 == 12) {
    $prod12mm = number_format((float)($m2s2prod + $prod12mm),3,'.','');
    $final12 = $m2s2 . ' = ' . $prod12mm;
}
//16mm


if ($m1s1 == 16) {
    $prod16mm = number_format((float)$m1s1prod,3,'.','');
    $final16 = $m1s1 . ' = ' . $prod16mm;
}

if ($m1s2 == 16) {
    $prod16mm = number_format((float)($prod16mm + $m1s2prod),3,'.','');
    $final16 = $m1s2 . ' = ' . $prod16mm;
}

if ($m2s1 == 16) {
    $prod16mm = number_format((float)($prod16mm+$m2s1prod),3,'.','');
    $final16 = $m2s1 . ' = ' . $prod16mm;
}

if ($m2s2 == 16) {
    $prod16mm = number_format((float)($prod16mm +$m2s2prod),3,'.','');
    $final16 = $m2s2 . ' = ' . $prod16mm;
}
//20mm
if ($m1s1 == 20) {
    $prod20mm = number_format((float)$m1s1prod ,3,'.',' ');
    $final20 = $m1s1 . ' = ' . $prod20mm;
}

if ($m1s2 == 20) {
    $prod20mm = number_format((float)($prod8mm +$m1s2prod),3,'.','');
    $final20 = $m1s2 . ' = ' . $prod20mm;
}

if ($m2s1 == 20) {
    $prod20mm = number_format((float)($prod20mm + $m2s1prod),3,'.','');
    $final20 = $m2s1 . ' = ' . $prod20mm;
}

if ($m2s2 == 20) {
    $prod20mm = number_format((float) ($prod20mm +$m2s2prod),3,'.','');
    $final20 = $m2s2 . ' = ' . $prod20mm;
}

//25mm

if ($m1s1 == 25) {
    echo $m1s1;

    $prod25mm = number_format((float)$m1s1prod,3,'.','');
    $final25 = $m1s1 . ' = ' . $prod25mm;
}

if ($m1s2 == 25) {
    $prod25mm = number_format((float)($prod25mm + $m1s2prod),3,'.','');
    $final25 = $m1s2 . ' = ' . $prod25mm;
}

if ($m2s1 == 25) {
    $prod25mm = number_format((float)($prod25mm +$m2s1prod),3,'.','');
    $final25 = $m2s1 . ' = ' . $prod25mm;
}

if ($m2s2 == 25) {
    $prod25mm = number_format((float)($prod25mm +$m2s2prod),3,'.','');
    $final25 = $m2s2 . ' = ' . $prod25mm;
}
//28mm

if ($m1s1 == 28) {
    $prod28mm = number_format((float)$m1s1prod,3,'.','');
    $final28 = $m1s1 . ' = ' . $prod28mm;
}

if ($m1s2 == 28) {
    $prod28mm = number_format((float)($prod28mm + $m1s2prod),3,'.','');
    $final28 = $m1s2 . ' = ' . $prod28mm;
}

if ($m2s1 == 28) {
    $prod28mm =number_format((float)($prod28mm + $m2s1prod),3,'.','');
    $final28 = $m2s1 . ' = ' . $prod28mm;
}

if ($m2s2 == 28) {
    $prod28mm = number_format((float)($prod28mm + $m2s2prod),3,'.','');
    $final28 = $m2s2 . ' = ' . $prod28mm;
}
//32mm


if ($m1s1 == 32) {
    $prod32mm = number_format((float)$m1s1prod,3,'.','');
    $final32 = $m1s1 . ' = ' . $prod32mm;
}

if ($m1s2 == 32) {
    $prod32mm = number_format((float) ($prod32mm +$m1s2prod),3,'.','');
    $final32 = $m1s2 . ' = ' . $prod32mm;
}

if ($m2s1 == 32) {
    $prod32mm = number_format((float)($prod32mm + $m2s1prod),3,'.','');
    $final32 = $m2s1 . ' = ' . $prod32mm;
}

if ($m2s2 == 32) {
    $prod32mm = number_format((float)($prod32mm +$m2s2prod),3,'.','');
    $final32 = $m2s2 . ' = ' . $prod32mm;
}


$varA='';


if ($final8 != '') {
    $varA =$varA . '' . $final8 . ' ' . "\n";
}
if ($final10 != '') {
    $varA = $varA . '' . $final10 . '' . "\n";
}

if ($final12 != '') {
    $varA = $varA . '' . $final12 . '' . "\n";
}
if ($final16 != '') {
    $varA = $varA . '' . $final16 . '' . "\n";
}
if ($final20 != '') {
    $varA = $varA . '' . $final20 . '' . "\n";
}
if ($final25 != '') {
    $varA = $varA . '' . $final25 . '' . "\n";
}
if ($final28 != '') {
    $varA = $varA . '' . $final28 . '' . "\n";
}
if ($final32 != '') {
    $varA = $varA . '' . $final32. '' . "\n";
}



//TOTAL ROLLING PRODUCTION CALCULATED IN THE METRIC TON 

$totalrollingprod = number_format((float)($prod8mm + $prod10mm + $prod12mm + $prod16mm + $prod20mm + $prod25mm + $prod28mm + $prod32mm),3,'.','');
//Total CCCM PRODUCTION CALCULATED IN THE METRIC TON 
$ccmprod = ($totalrollingprod + $bbpprod3st + $bbprodmill + $bbprodccm + $bbprodcont + $bbprodmpeb + $bbprodother + $bbprodfnce +$millmrprod+ $rfmrprod);
//TOTAL HOT ROLLING PRODUCTION IN %
$totalhotrolng =number_format((float)($totalrollingprod / $ccmprod) * 100, 2,'.','');

// CALCUALTION FOR THE CUMMULATIVE HOT ROLLING , ROLLING PRODUCTION ,CCM PRODUCTION AND MISSROLL

if ($heatnumber == 1) {
    $cum_ccmprod = $ccmprod;
    $cum_hotroling = $totalhotrolng;
    $cum_totalrollprod = $totalrollingprod;
    $cum_totalmissroll = $totalmissroll;
} else {
    $cummHeatNumber = ($heatnumber - 1);
    
    $sql_cum = "select `cum_ccmprod` ,`cum_rollingprod`,`cum_missroll` from  per_heat_production where `perheatdate` = '" . $per_date . "' and `heat-number`='" . $cummHeatNumber . "'";
    echo 'after 1';
 
    $result_cum = mysqli_query($link, $sql_cum);
    $row_cum =    mysqli_fetch_row($result_cum);
    
  
    //CUMMULATIVE CCM PRODUCTION
    $cum_ccmprod = number_format((float)($row_cum[0] + $ccmprod),3,'.','');
  
    //CUMMULATIVE ROLLING PRODUCTION
    $cum_totalrollprod=number_format((float)($row_cum[1] + $totalrollingprod),3,'.','');
    //CUMMULATIVE MISSROLL 
    $cum_totalmissroll = ($row_cum[2] + $totalmissroll);
    //CUMMULATIVE HOT ROLLING PERCENTAGE 
    $cum_hotroling=number_format((float)(($cum_totalrollprod/$cum_ccmprod)*100),2,'.','');
}


// CONVERTING CUM_HOTROLLING IN 2 PLACES OF DECIMAL
//$cum_hotroling = number_format((float) $cum_hotroling, 2, '.', '');

// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO MILL
$perbbpmill = number_format((float)(($bbprodmill / $ccmprod) * 100), 2,'.','');
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO CCM
$perbbpccm = number_format((float)(($bbprodccm / $ccmprod) * 100), 2,'.','');
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO 3RD STAND
$perbbp3st =  number_format((float)(($bbpprod3st/ $ccmprod) * 100), 2,'.','');
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO FURNACE
$perbbpfnce = ($bbprodfnce / $ccmprod) * 100;
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO CONTRACTOR
$perbbpcont = ($bbprodcont / $ccmprod) * 100;
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TOMPEB
$perbbpmpeb = ($bbprodmpeb / $ccmprod) * 100;
// CALCULATION FOR THE PERCENTAGE BILLETS BYPAAS PRODUCTION DUE TO OTHER
$perbbpother =($bbprodother / $ccmprod) * 100;
//CALCULATION MISSROLL PRODUCTION PERCENTAGE CALCULATION
$permrprod= number_format((float)(($totalmrprod/ $ccmprod) * 100), 2,'.','');

// Calculating Total MR Production and  Roughing Production
if(($m1s1==8 )|| ($m1s2==8)) {
$m18mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],8);
}
if(($m2s1==8) ||($m2s2==8)){
$m28mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],8);
}
$T8rfmr= ($m18mm + $m28mm);
if(($m1s1==10 )|| ($m1s2==10)) {
$m110mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],10);
}
if(($m2s1==10) ||($m2s2==10)){
$m210mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],10);
}
$T10rfmr= $m110mm + $m210mm;
if(($m1s1==12 )|| ($m1s2==12)) {
$m112mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],12);
}
if(($m2s1==12) ||($m2s2==12)){
$m212mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],12);
}
$T12rfmr= $m112mm + $m212mm;

if(($m1s1==16 )|| ($m1s2==16)) {
$m116mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],16);
}
if(($m2s1==16) ||($m2s2==16)){
$m212mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],16);
}
$T16rfmr= $m116mm + $m216mm;
if(($m1s1==20 )|| ($m1s2==20)) {
$m120mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],20);
}
if(($m2s1==20) ||($m2s2==20)){
$m212mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],20);
}
$T120fmr= $m120mm + $m220mm;

if(($m1s1==25 )|| ($m1s2==25)) {
$m125mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],25);
}
if(($m2s1==25) ||($m2s2==25)){
$m225mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],25);
}
$T16rfmr= $m125mm + $m225mm;
if(($m1s1==28 )|| ($m1s2==28)) {
$m128mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],28);
}
if(($m2s1==28) ||($m2s2==28)){
$m228mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],28);
}
$T28rfmr= $m128mm + $m228mm;

if(($m1s1==32 )|| ($m1s2==32)) {
$m132mm=RollingBD::getInstance()->get_roughing_mr_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],32);
}
if(($m2s1==30) ||($m2s2==30)){
$m232mm=RollingBD::getInstance()->get_roughing_mr_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],32);
}
$T32rfmr= $m132mm + $m232mm;



$totalrfmrprod=$T8rfmr+$T10rfmr+$T12rfmr+$T16rfmr+$T20rfmr+$T25rfmr+$T32rfmr+$T28rfmr;
  //echo $totalrfmrprod;
  
  // Calculating Total Cutting Production
if(($m1s1==8 )|| ($m1s2==8)) {
$m1c8mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],8);
}
if(($m2s1==8) ||($m2s2==8)){
$m2c8mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],8);
}
$T8cut= $m1c8mm + $m2c8mm;
if(($m1s1==10 )|| ($m1s2==10)) {
$m1c10mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],10);
}
if(($m2s1==10) ||($m2s2==10)){
$m2c10mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],10);
}
$T10cut= $m1c10mm + $m2c10mm;
if(($m1s1==12)|| ($m1s2==12)) {
$m1c12mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],12);
}
if(($m2s1==12) ||($m2s2==12)){
$m2c12mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],12);
}
$T12cut= $m1c12mm + $m2c12mm;
if(($m1s1==16 )|| ($m1s2==16)) {
$m1c16mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],16);
}
if(($m2s1==16) ||($m2s2==16)){
$m2c16mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],16);
}
$T16cut= $m1c16mm + $m2c16mm;

if(($m1s1==20 )|| ($m1s2==20)) {
$m1c20mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],20);
}
if(($m2s1==20) ||($m2s2==20)){
$m2c20mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],20);
}
$T20cut= $m1c20mm + $m2c20mm;

if(($m1s1==25 )|| ($m1s2==25)) {
$m1c25mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],25);
}
if(($m2s1==25) ||($m2s2==25)){
$m2c25mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],25);
}
$T25cut= $m1c25mm + $m2c25mm;

if(($m1s1==28 )|| ($m1s2==28)) {
$m1c28mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],28);
}
if(($m2s1==28) ||($m2s2==28)){
$m2c28mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],28);
}
$T28cut= $m1c28mm + $m2c28mm;

if(($m1s1==32 )|| ($m1s2==32)) {
$m1c32mm=RollingBD::getInstance()->get_cutting_prod_mill1($_POST['perheatdate'],$_POST['heatnumber'],32);
}
if(($m2s1==32) ||($m2s2==32)){
$m2c32mm=RollingBD::getInstance()->get_cutting_prod_mill2($_POST['perheatdate'],$_POST['heatnumber'],32);
}
$T32cut= $m1c32mm + $m2c32mm;

$totalcuttingprod=$T8cut+$T10cut+$T12cut+$T16cut+$T20cut+$T25cut+$T28cut+$T32cut;

echo $totalcuttingprod;



/**
 * QUERY TO INSERT VALUES IN THE PER HEAT PRODUCTION TABLE 
 */


$sql_ph = "insert into `per_heat_production`(`perheatdate`,`roughing`,`heat-number`,`heat-start-time`,`heat-end-time`,`total-heat-time`,`total_bd_time`,"
        . "`m1s1`,`m1s2`,`m2s1`,`m2s2`,`3mtrbwt(m1s1)`,`rolledpcs(m1s1)`,`3mtrbwt(m1s2)`,`rolledpcs(m1s2)`,`3mtrbwt(m2s1)`,`rolledpcs(m2s1)`,"
        . "`3mtrbwt(m2s2)`,`rolledpcs(m2s2)`,`3st3mtrbbp`,`3st6mtrbbp`,"
        . " `3st3mtrbwt`,`3st6mtrbwt`,`ccm3mtrbwt`,`ccm3mtrbbp`,`ccm6mtrbwt`,`ccm6mtrbbp`,`bbpurelyccm`,`missroll`,`cum_missroll`,"
        . "`millmrprod`,`rfmrprod`,`cum_rfmrprod`,`bbprodmill`,`bbprodccm`,`bbprod3st`,`bbprodfnce`,`bbprodmpeb`,`bbprodcontr`,`bbprodother`,`m1s1prod`,"
        . " `m1s2prod`,`m2s1prod`,`m2s2prod`,`8mm`,`10mm`,`12mm`,`16mm`,`20mm`,`25mm`,`28mm`,`32mm`,`rollingprod`,`cum_rollingprod`,`ccmprod`,`cum_ccmprod`,"
        . " `hotrolling`,`cum_hotrolling`,`perbbpmill`,`perbbpccm`,`perbbp3st`,`perbbpfnce`,`perbbpmpeb`,`perbbpcontr`,`perbbpother`,`permrprod`,`8rfmr`,"
        . " `10rfmr`,`12rfmr`,`16rfmr`,`20rfmr`,`25rfmr`,`28rfmr`,`32rfmr`,`8cut`,`10cut`,`12cut`,`16cut`,`20cut`,`25cut`,`28cut`,`32cut`,`totalrfmrprod`,"
        . " `totalcuttingprod`)"
        . " values"
        . "('" . $per_date . "','" . $roughing . "','" . $heatnumber . "','" . $heatstarttime . "','" . $heatendtime . "','" . $totalheattime . "','" . $totalbdtime . "',"
        . " '" . $m1s1 . "', '" . $m1s2 . "','" . $m2s1 . "','" . $m2s2 . "' ,'" . $bwt3mtm1s1 . "','" . $rpm1s1 . "','" . $bwt3mtm1s2 . "','" . $rpm1s2 . "',"
        . "'" . $bwt3mtm2s1 . "','" . $rpm2s1 . "','" . $bwt3mtm2s2 . "','" . $rpm2s2 . "',"
        . "'" . $bbp3st3m . "','" . $bbp3st6m . "','" . $bwt3m3s . "','" . $bwt6m3s . "','" . $bwt3mccm . "','" . $bbp3mccm . "','" . $bwt6mccm . "',"
        . "'" . $bbp6mccm . "','" . $bbppurelyccm . "','" . $totalmissroll . "','" . $cum_totalmissroll . "','" . $millmrprod . "','" . $rfmrprod . "','" . $cum_rfmrprod . "',"
        . "'" . $bbprodmill . "','" . $bbprodccm . "','" . $bbpprod3st . "','" . $bbprodfnce . "','" . $bbprodmpeb . "','" . $bbprodcont . "','" . $bbprodother . "','" . $m1s1prod . "',"
        . "'" . $m1s2prod . "','" . $m2s1prod . "','" . $m2s2prod . "','" . $prod8mm . "','" . $prod10mm . "','" . $prod12mm . "','" . $prod16mm . "','" . $prod20mm . "','" . $prod25mm . "','" . $prod28mm . "',"
        . "'" . $prod32mm . "','" . $totalrollingprod . "','" . $cum_totalrollprod . "','" . $ccmprod . "','" . $cum_ccmprod . "','" . $totalhotrolng . "','" . $cum_hotroling . "','" . $perbbpmill . "',"
        . "'" . $perbbpccm . "','" . $perbbp3st . "','" . $perbbpfnce . "','" . $perbbpmpeb . "','" . $perbbpcont . "','" . $perbbpother . "','" . $permrprod . "',"
        . "'" . $T8rfmr . "','" . $T10rfmr . "','" . $T12rfmr . "','" . $T16rfmr. "','" . $T20rfmr. "','" . $T25rfmr . "','" . $T28rfmr . "',"
        . "'" . $T32rfmr . "','" . $T8cut . "','" . $T10cut . "','" . $T12cut . "','" . $T16cut . "','" . $T20cut . "','" . $T25cut . "',"
        . "'"  .$T32cut."' ,'". $totalrfmrprod . "','" . $totalcuttingprod . "')";

$result_ph = (mysqli_query($link, $sql_ph) or die(mysqli_error($link)));



// CHECKING THAT EITHER VALUES ARE INSERTED PROPERLY OR NOT
if ($result_ph) {
    echo"record added";
    //echo $row_cum;
} else {
    echo 'not added';
}

//FETCHING THE BREAKDOWN TIME FROM THE BREAKDDOWN TABLE TO POST IN THE SLACK CHANNEL
$sql_2="select `total_bd_time` from `per_heat_production` where `perheatdate`='" . $per_date . "' and `heat-number`= '" . $heatnumber . "'";
$result_2= mysqli_query($link,$sql_2);
$row_2=   mysqli_fetch_row($result_2);

$bdtime=$row_2[0];
// Converting bdtime in hh:mm
$bdtimetotal = substr($bdtime,0,5);

if ($totalmissroll == '') {
    $totalmissroll = 0;
}
if ($cum_totalmissroll == '') {
    $cum_totalmissroll = 0;
}






mysqli_close($link);

//POSt Message to Slack CHANNEL ROLLING
 Slack::getInstance()->postMessagesToSlack_perheat("
`$roughing` 
*$heatnumber*
*$heatstarttime* = *$heatendtime*    
*$bdtimetotal*
_*`$totalhotrolng`*_ (*`$cum_hotroling`*)
    *$perbbpmill*
    *$perbbpccm*,
    *$perbbp3st*,
*M.R.%* _*`$permrprod`*_         
*$totalmissroll*,(*$cum_totalmissroll*)    
 $varA (_*`$cum_totalrollprod`*_)
        ", "Test");

// ON FORM SUBMITTED REDIRECTED TO THE HOME.PHP
//header("Location:http://192.168.2.141/Rolling/Home.php");

exit();
?>  