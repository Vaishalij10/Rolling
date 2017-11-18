
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="./ValidationRollingKPI.js"></script>
    </head>
</html>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






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

    $sql_kpirpt = "SELECT  `kpidate`, `heatcount`, `grosstmt`, `totalccmprod`, `heatruntime`, `heatgap`, `pertonpowerunits`, 
        `net8mm`, `net10mm`, `net12mm`, `net16mm`, `net20mm`, `net25mm`, `net28mm`, `net32mm`, 
         `nettmt`, `Tprolledrolling`, 
        `Tpfromccm`, `24hrshotrolling`, `monthlyhotrolling`, `monthlynettmt`, `Tendcutmrpercent`, 
        `Tmrpercent`, `Tmilmrpercent`, `Tmissroll`, `Tmillmissroll`, `Telecmissroll`, `Tmechmissroll`, 
        `Tccmqltymissroll`, `Tfncemissroll`, `Tmpebmissroll`, `Indepmissroll`, `depmissroll`, 
        `Tcuttingpercent`,  
        `Tpermissrollcuttingprod`, `Tbypassmill`, `Tperbbyprodmill`, 
         `Tbypassmech`, `Tperbyprodmech`,`Tbypasselec`, `Tperbbyprodelec`,
        `Tbypasspc`, `Tperbyprodpc`, `Tbypasssc`, `Tperbyprodsc`, 
         `Tbypassment`, `Tperprodment`,  `Tbypassmpeb`, 
        `Tperprodmpeb`, `Tbypasslahar`, `Tperprodlahar`,
        `Tbypasscrack`, `Tperprodcrack`,  `Tbypasspiping`, `Tperprodpiping`, 
        `Tbypassmopen`, `Tperprodmopen`,  `Tbypasschill`, `Tperprodchill`, 
         `Tbypassccd`, `Tperprodccd`, `Tperbyprodmill`, `Tperbyprodccm`, `totalbypassduetomill`,
        `totalbypassduetoccm` ,`kpi_id`FROM `rollingkpi` 
            where kpidate >= '$date1' and kpidate <= '$date2' order by kpidate";


    echo "<table border=1>";
 
//echo '<table cellpadding="1" cellspacing="1" class="db-table">';
   
    echo "<tr><td>DATE</td>". "<td>HEATCOUNT</td>". "<td>GROSSTMT</td>"
    . "<td>TOTAL CCM PRODUCTION</td>" . "<td>HEAT RUN TIME </td>". "<td>HEAT GAP</td>"  ."<td>PERTON POWER CONSUMPTION</td>"."<td>NET 8MM</td> " . "<td>NET 10MM</td> " . "<td>NET 12MM</td> ". "<td>NET 16MM</td> "
    . "<td>NET 20MM</td> " . "<td>NET 25MM</td> " . "<td>NET 28MM</td> " .  "<td>NET 32MM</td> "."<td>NETTMT</td> "."<td>TOTAL ROLLED PC</td> " ."<td>TOTAL PIECES FROM CCM </td> "
    ."<td>24HRS HOTROLLING</td> " ."<td>MONTHLY HOT ROLLING</td> " ."<td>MONTHLY NETTMT</td> " ."<td>TOTAL ENDCUT(%)</td> "
    ."<td>TOTAL MISSROLL(%)</td> " ."<td>TOTAL MILL MISSROLL(%)</td> "  ."<td>TOTAL MISSROLLS</td> " ."<td>TOTAL MILL MISSROLL</td> "
    ."<td>TOTAL ELEC MISSROLL</td> "  ."<td>TOTAL MECH MISSROLL</td> "."<td>TOTAL CCM/QLTY MISSROLL</td> " ."<td>TOTAL FURNACE MISSROLL</td> " ."<td>TOTAL MPEB MISSROLL</td> "            
    ."<td>INDEPENDENT MR </td> " ."<td>DEPENDENT MR </td> " ."<td>TOTAL CUTTING(%)</td> " ."<td>TMISSROLLCUTTINGPROD(%)</td> " 
    ."<td>TOTAL BYPASS DUE TO MILL(NO.)</td> " ."<td>TOTAL BYPASS DUE TO MILL(%)</td> "      
    ."<td>TOTAL BYPASS DUE TO MECH(NO.)</td> " ."<td>TOTAL BYPASS DUE TO MECH(%)</td> "           
   ."<td>TOTAL BYPASS DUE TO ELEC(NO.)</td> " ."<td>TOTAL BYPASS DUE TO ELEC(%)</td> "       
   ."<td>TOTAL BYPASS DUE TO PC(NO.)</td> " ."<td>TOTAL BYPASS DUE TO PC(%)</td> " 
    ."<td>TOTAL BYPASS DUE TO SC(NO.)</td> " ."<td>TOTAL BYPASS DUE TO SC(%)</td> " 
    ."<td>TOTAL BYPASS DUE TO MAINTENACE(NO.)</td> " ."<td>TOTAL BYPASS DUE TO MAINTENACE(%)</td> "
    ."<td>TOTAL BYPASS DUE TO MPEB(NO.)</td> " ."<td>TOTAL BYPASS DUE TO MPEB(%)</td> "  
    ."<td>TOTAL BYPASS DUE TO LAHAR(NO.)</td> " ."<td>TOTAL BYPASS DUE TO LAHAR(%)</td> "    
     ."<td>TOTAL BYPASS DUE TO CRACK(NO.)</td> " ."<td>TOTAL BYPASS DUE TO CRACK(%)</td> " 
   ."<td>TOTAL BYPASS DUE TO PIPING(NO.)</td> " ."<td>TOTAL BYPASS DUE TO PIPING(%)</td> "
     ."<td>TOTAL BYPASS DUE TO MOUTHOPEN(NO.)</td> " ."<td>TOTAL BYPASS DUE TO MOUTHOPEN(%)</td> "      
     ."<td>TOTAL BYPASS DUE TO CHILLI(NO.)</td> " ."<td>TOTAL BYPASS DUE TO CHILLI(%)</td> " 
    ."<td>TOTAL BYPASS DUE TO CCD(NO.)</td> " ."<td>TOTAL BYPASS DUE TO CCD(%)</td> "
     ."<td>TOTAL BYPASS PROD DUE TO MILL(%)</td> " ."<td>TOTAL BYPASS PROD DUE TO CCM(%)</td> "    ."<td>TOTAL BYPASS DUE TO MILL</td> "  ."<td>TOTAL BYPASS DUE TO CCM</td> "   . "<td>Button</td>"   ;
   
    $res_KPI = mysqli_query($link,  $sql_kpirpt)  or die(mysqli_error($link));
   /** echo $date1;
    echo $date2;
    echo "<br>";**/
   // $num_row = mysqli_num_rows($link,$res_perheat);
    //echo $num_row;
    while ($row_kpi = mysqli_fetch_array($res_KPI)) {
       // echo 'in while';
        
        echo "<tr>";
        for ($i = 0; $i < 65; $i++) {
            echo "<td>" . $row_kpi[$i] . "</td>";
        }
        echo "<td><button id='".$row_kpi[65]."' type=\"button\" onclick=\"kpiDeleteSummary(this.id);\"> Delete </button></td>";
    }
    
    echo "</table>";
}else {
    echo "Not Connect";
}
?>
<br><br>
<!-- DOWNLOAD THE EXCEL FILE TO GET THE DATA ON THE BASIS OF THE SELECTED DATE    -->
<a href="RollingKPIExcel.php"> RollingMillKPI Report</a> </br></br>
<a href="../Home.php"> Home </a> 
