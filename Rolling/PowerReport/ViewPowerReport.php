<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "in view PowerReport page";




/** IT IS VIEW PERHEATFORM , WHEN THE USER SELECTED THE FROM DATE AND TO DATE IN THE HOME PAGE ,
 * HE WILL BE REDIRECTED TO THE VIEWPERHEAT PAGE . THE USER CAN ALSO DOWNLOAD THE EXCEL FILE
 * ON THE  BASIS OF SLECTED DATE
 * 
 */
session_start();
include('..\Connection.php');

extract($_GET);

//START AND DATE DAT  IN YYYY-MM-DD (BECAUSE CAN ACCEPT ONLY THIS FORMAT)
$date1 = date('Y-m-d', strtotime($date1));
$date2 = date('Y-m-d', strtotime($date2));


$_SESSION["date1"] = $date1;
$_SESSION["date2"] = $date2;


if ($link != NULL) {

    $sql_prptp = "SELECT  `reading_date`, `day-count`, `reading-datetime`, `hours_dif`, 
        `mwh daily unit`, `mvah daily unit`, `mva`, `pf`, `mwh monthly unit`, `mvah monthly unit`, `unit-3`, 
        `ccd`, `100-hp blower`, `moira-furnace`, `moira-lt`, `bundling press`, 
        `mpeb mwh reading`, `mpeb mvah reading`, `mpeb mva reading`, 
        `daily unit`, `monthly unit`, `daily power factor`,`daily load factor`, 
        `monthly power factor`, `monthly load factor`, `monthly demand`, `unit-3(units)`, 
        `100-hp blower(units)`, `ccd(units)`, `moira-furnace(units)`, `moira-lt(units)`, 
        `bundling press(units)`, `total-units`, `rolling`, `elec-down-time` FROM `power_report` 
            where reading_date >= '$date1' and reading_date <= '$date2' order by reading_date";


    echo "<table border=1>";
 
//echo '<table cellpadding="1" cellspacing="1" class="db-table">';
   
    echo "<tr><td>DATE</td>"
    . "<td>DAY</td>"
    . "<td>READING-TIME</td>"
    . "<td>HOURS-DIFF</td>"
    . "<td>MWH(DAILY UNIT)</td>"
    . "<td>MVAH(DAILY UNIT)</td>"
    . "<td>MVA(DAILY UNIT)</td>"
    . "<td>POWER FACTOR</td>"
    . "<td>MWH(Monthly Unit)</td>"
    . "<td>MVAH(Monthly Unit)</td>"
    . "<td>Unit-3</td>"
    . "<td>CCD</td>"
    . "<td>100-HP Blower</td>"
    . "<td>MOIRA Furnace</td>"
    . "<td>MOIRALT</td>"
    . "<td>BUNDLING PRESS</td>"
    . "<td>MPEB MWH READING</td>"
    . "<td>MPEB MVAH READING</td>"
    . "<td>MPEB MVA READING</td>"
    . "<td>DAILY UNIT</td>"
    . "<td>MONTHLY UNIT</td>"
    . "<td>DAILY POWER FACTOR</td>"
    . "<td>DAILY LOAD FACTOR</td>"
    . "<td>MONTHLY POWER FACTOR</td>"
    . "<td>MONTHLY LOAD FACTOR</td>"
    . "<td>MONTHLY DEMAND</td>"
    . "<td>UNIT-3(UNITS)</td>"
    . "<td>100-HP BLOWER(UNITS)</td>"
    . "<td>CCD(UNITS)</td>"
    . "<td>MOIRA(UNITS</td>"
    . "<td>LT(UNITS)</td>"
    . "<td>BUNDLING PRESS(UNITS)</td>"
    . "<td>TOTAL-UNITS</td>"
    . "<td>ROLLING</td>"
    . "<td>ELEC-DOWN-TIME</td>";

    $res_prptp = mysqli_query($link,  $sql_prptp)  or die(mysqli_error($link));
   /** echo $date1;
    echo $date2;
    echo "<br>";**/
   // $num_row = mysqli_num_rows($link,$res_perheat);
    //echo $num_row;
    while ($row_prptp = mysqli_fetch_array($res_prptp)) {
       // echo 'in while';
        
        echo "<tr>";
        for ($i = 0; $i < 34; $i++) {
            echo "<td>" . $row_prptp[$i] . "</td>";
        }
    }
    
    echo "</table>";
}else {
    echo "Not Connect";
}
?>
<br><br>
<!-- DOWNLOAD THE EXCEL FILE TO GET THE DATA ON THE BASIS OF THE SELECTED DATE    -->
<a href="PowerReportExcel.php"> MillPowerReportExcel</a> </br></br>
<a href="../Home.php"> Home </a> 