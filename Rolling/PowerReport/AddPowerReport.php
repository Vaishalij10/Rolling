<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//ESTABLISHING CONNECTION TO THE DATABASE
require_once("..\Connection.php");
// INCLUDING DB FILE
require_once("..\DBfile.php");
// TO SEND MESAGE TO THE SLACK CHANNEL
require_once("..\postMessagesToSlack.php");



function lz($num) {
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

//INPUT VALUES FROM THE FORM WHICH IS ENTERED BY THE USET 


$datetime   = $_POST['datetime'];
$mwhdu      = $_POST['dumwh'];
$mvahdu     = $_POST['dumvah'];
$mva        = $_POST['mva'];
$pf         = $_POST['pf'];
$unit3      = $_POST['unit3'];
$ccd        = $_POST['ccd'];  
$hpblower   = $_POST['100hpblower'];
$moirafnce  = $_POST['moirafnce'];
$moiralt    = $_POST['moiralt'];
$bundlingpress  =    $_POST['bundlingpress'];
$mwhmpebr    =       $_POST['mwhmpebreading'];
$mvahmpebr      =    $_POST['mvahmpebreading'];
$mvampebr       =    $_POST['mvampebreading'];
$mwhmpebreading =    $_POST['mwhmpebreading'];
$mvahmpebreading =    $_POST['mvahmpebreading'];
$mvampebreading  =     $_POST['mvampebreading'];

$day=1;
echo  "entered date :" ; echo  $datetime; 
$date_value = date('d', strtotime($datetime));
echo "<br>";
echo $date_value;
$reading_date = date('Y-m-d', strtotime($datetime));
$sql_pr = mysqli_query($link,
        "select `reading-datetime`,`mwh daily unit`,`mvah daily unit`,`mva`,`pf`,`mwh monthly unit`
            ,`mvah monthly unit`,`unit-3`,`ccd`,`100-hp blower`,`moira-furnace`,`moira-lt`,`bundling press`
            ,`mpeb mwh reading`,`mpeb mvah reading`,`mpeb mva reading`
         from power_report where `power_id` in(select max(power_id) from power_report)");

$row_pr= mysqli_fetch_array($sql_pr);
echo 'in select query';

$last_readingtime   =   $row_pr['reading-datetime'];
$last_mwhdu         =   $row_pr['mwh daily unit'];
$last_mvahdu        =   $row_pr['mvah daily unit'];
$last_mva           =   $row_pr['mva'];
$last_pf            =   $row_pr['pf'];
$last_mwhmu         =   $row_pr['mwh monthly unit'];
$last_mvahmu        =   $row_pr['mvah monthly unit'];
$last_unit3         =   $row_pr['unit-3'];
$last_ccd           =      $row_pr['ccd'];
$last_100hpblower   =   $row_pr['100-hp blower'];
$last_moirafnce  =   $row_pr['moira-furnace'];
$last_moiralt       =   $row_pr['moira-lt'];
$last_bundlingpress =   $row_pr['bundling press'];
//$last_mwhmpebr      =   $row_pr['mpeb mwh reading'];
//$last_mvahmpebr     =   $row_pr['mpeb mvah reading'];
//$last_mvampebr      =   $row_pr['mpeb mva reading'];



echo"<br>";
echo $last_readingtime;
echo "<br>";
echo $last_mwhdu;

$hour_diff= abs(strtotime($datetime) - strtotime($last_readingtime))/3600;
//$hour_diff1=$hour_diff;

$seconds_ph = ($hour_diff * 3600);
$hours_ph = floor($hour_diff);
$seconds_ph -= $hours_ph * 3600;
$minutes_ph = floor($seconds_ph / 60);
$seconds_ph -= $minutes_ph * 60;
$hour_diff1 = lz($hours_ph) . ":" . lz($minutes_ph);



echo "<br>"; echo $hour_diff;
/**if($date_value == 23)
{
    $mwhmu=$mwhdu;
    $mvahmu=$mvahdu;
}
else{
     $mwhmu=$last_mwhmu;
    $mvahmu=$last_mvahmu;
}**/
if($date_value==24){
    $mwhmu=$mwhdu;
    $mvahmu=$mvahdu;
    $day_count = 1 ;
    $sql_day=mysqli_query($link,"insert into `power_report`( `day-count`) values (1)");
         echo $day_count;
}
else{
    $sql_d= mysqli_query($link,"select `day-count` from  power_report where power_id in (select max(power_id) from power_report)");
    $row_d= mysqli_fetch_array($sql_d);
   // echo "<br>";
    //echo "day-count"; echo "<br>";
    //echo $row_d['day-count'];
    $row_val=$row_d['day-count'];
    //echo "<br>"; echo "final count";
    $day_count= $row_val +1 ;
    //echo "<br>"; echo "day-count again";
   // echo "<br>";
     $mwhmu=$last_mwhmu;
    $mvahmu=$last_mvahmu;
}
//echo $day_count;
//echo"<br>"; echo "monthly unit"; echo"<br>";
//echo $mwhmu; echo "<br>"; echo $mvahmu;
//echo"<br>"; echo "daily unit"; echo"<br>";
//echo $mwhdu; echo "<br>"; echo $mvahdu;

//DAILY UNIT CALCULATION 
$dailyunit= round(($mwhdu - $last_mwhdu)*40000);
//echo " Dailyunit: <br> "; echo $dailyunit;
//MONTHLY UNIT CALCULATION
$monthlyunit= round(($mwhdu-$mwhmu)*40000);
//DAILY POWER FACTOR
$dpf=number_format((float)($mwhdu - $last_mwhdu)/($mvahdu-$last_mvahdu),5,'.','');
//MONTHLY DEMAND
$monthlydemand= number_format((float)($mva*40000),2,'.','');
//DAILY LOAD FACTOR 
$dlf=number_format((float)($dailyunit/($monthlydemand*$hour_diff)*100),2,'.','');
//MONTHLY POWER FACTOR
$mpf=number_format((float)($mwhdu-$mwhmu)/($mvahdu-$mvahmu),5,'.','');
//MONTHLY LOAD FACTOR
$mlf=number_format((float)($monthlyunit/($monthlydemand*24*$day_count)*100),2,'.','');
//Unit 3 units Calculation
$unit3_units=number_format((float)(($unit3-$last_unit3)*100*10000),2,'.','');
//100 hp blower units calculation
$hpblower_units=number_format((float)($hpblower-$last_100hpblower),2,'.','');

//ccd units calculations
$ccd_units=number_format((float)(($ccd-$last_ccd)*1000000),2,'.','');
//MOIRA FURNACE UNIT
$moirafnce_units=number_format((float)(($moirafnce-$last_moirafnce)*10000),2,'.','');
// MOIRA L UNITS
$moiralt_units=number_format((float)(($moiralt-$last_moiralt)*1000),2,'.','');
// BUNDLING PRESS UNITS
$bundlingpress_units=number_format((float)($bundlingpress-$last_bundlingpress),2,'.','');
// TOTAL UNITS
$total_units=$bundlingpress_units +$unit3_units +$moirafnce_units +$moiralt_units +$hpblower_units +$ccd_units;
echo "units"; echo "<br>";
echo $unit3_units; echo "<br>";
echo $ccd_units; echo "<br>";
echo $hpblower_units; echo "<br>";
echo $bundlingpress_units; echo "<br>";
echo $moirafnce_units; echo "<br>";
echo $moiralt_units; echo "<br>";

echo"total units:"; echo $total_units;
// ROLLING UNITS
$rolling_units= round($total_units-$dailyunit);

echo $reading_date;
//ELECTRICAL DOWN TIME
$sql_prbd=mysqli_query($link,"select  TIME_FORMAT((SUM(`bd_total_time`)),'%H:%i') from breakdown where date ='".$reading_date."' and department =3");
$row_prbd=mysqli_fetch_array($sql_prbd);

$elec_down_time = $row_prbd[0];
echo $elec_down_time;
//echo $test;

//INSERTING THE data in to the power_report table 
echo "in insert query";

echo $reading_date;
echo $day_count;

$sql_prpt= "INSERT INTO 
         `power_report` 
         (`reading_date` , 
         `day-count`, 
        `reading-datetime`, 
        `hours_dif`,  
        `mwh daily unit`, 
        `mvah daily unit`,  
        `mva`, 
        `pf`, 
        `mwh monthly unit`, 
        `mvah monthly unit`, 
        `unit-3`,  
        `ccd`,
        `100-hp blower`,
        `moira-furnace`, 
        `moira-lt`,
        `bundling press`, 
        `mpeb mwh reading`,
        `mpeb mvah reading`, 
        `mpeb mva reading`, 
        `daily unit`, 
        `monthly unit`,  
        `daily power factor`, 
        `daily load factor`,
        `monthly power factor`,
        `monthly load factor`, 
        `monthly demand`, 
        `unit-3(units)`, 
        `100-hp blower(units)`, 
        `ccd(units)`, 
        `moira-furnace(units)`, 
        `moira-lt(units)`, 
        `bundling press(units)`,
        `total-units`,
        `rolling`,`elec-down-time`) 
        VALUES 
        ('".$reading_date."',"
        . "'".$day_count."',"
        . "'".$datetime."',"
        . "'".$hour_diff1."',"
        . "'".$mwhdu."',"
        . "'".$mvahdu."',"
        . "'".$mva."',"
        . "'".$pf."',"
        . "'".$mwhmu."',"
        . "'".$mvahmu."',"
        . "'".$unit3."',"
        . "'".$ccd."',"
        . "'".$hpblower."',"
        . "'".$moirafnce."',"
        . "'".$moiralt."',"
        . "'".$bundlingpress."',"
        . "'".$mwhmpebr."',"
        . "'".$mvahmpebr."',"
        . "'".$mvampebr."',"
        . "'".$dailyunit."',"
        . "'".$monthlyunit."',"
        . "'".$dpf."',"
        . "'".$dlf."',"
        . "'".$mpf."',"
        . "'".$mlf."',"
        . "'".$monthlydemand."',"
        . "'".$unit3_units."',"
        . "'".$hpblower_units."',"
        . "'".$ccd_units."',"
        . "'".$moirafnce_units."',"
        . "'".$moiralt_units."',"
        . "'".$bundlingpress_units."',"
        . "'".$total_units."',"
        . "'".$rolling_units."','".$elec_down_time."')";
 
$result_prpt = (mysqli_query($link, $sql_prpt) or die(mysqli_error($link)));



if ($result_prpt) {
    echo"record added";
    //echo $row_cum;
} else {
    echo 'not added';
}

mysqli_close($link);

//POSt Message to Slack CHANNEL ROLLING
 Slack::getInstance()->postMessagesToSlack_powerreport("
Date-On = *$reading_date*
Daily Unit= `$dailyunit`
Monthly Unit= `$monthlyunit`
Rolling =`$rolling_units`
D.P.F= *$dpf*
D.L.F.= *$dlf*
   |M.P.F|=`$mpf`
   |M.L.F| =`$mlf`
   |M.D.| = `$monthlydemand`
Unit-3 =*$unit3_units*
100 HP-Blower= *$hpblower_units*
CCD=*$ccd_units*    
Moira= *$moirafnce_units*
LT=*$moiralt_units*
Bundling Press=*$bundlingpress_units*
Elec.Down.Time=*$elec_down_time*    
         ", "Test");

// ON FORM SUBMITTED REDIRECTED TO THE HOME.PHP
header("Location:http://192.168.2.141/Rolling/Home.php");

exit();
  