<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="./ValidationPerHeat.js"></script>
    </head>
</html>

<?php


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

    $sql_perheat = "select `perheatdate`,`roughing`,
             `m1s1`,`m1s2`,`m2s1`,`m2s2`,`heat-number`,`heat-start-time`,`heat-end-time`,
             `total-heat-time`,`total_bd_time`,
             `3st3mtrbbp`,  `3st6mtrbbp`,
            `ccm3mtrbbp`,`ccm6mtrbbp`,`bbpurelyccm`,`missroll`,`cum_missroll`,
            `8mm`,`10mm`,`12mm`,`16mm`,`20mm`,`25mm`,
            `28mm`,`32mm`,`rollingprod`,`cum_rollingprod`,`ccmprod`,`cum_ccmprod`,`hotrolling`,`cum_hotrolling`,`perbbpmill`,
            `perbbpccm`,`perbbp3st`,`perbbpfnce`,`perbbpmpeb`,`perbbpcontr`,`perbbpother`,per_heat_id
            from per_heat_production 
            where perheatdate >= '$date1' and perheatdate <= '$date2' order by  perheatdate ,`heat-number` asc ";


    echo "<table border=1>";
    echo "<tr><td>Date   </td>"
    . "<td>Roughing</td>"
    . "<td>M1S1</td>"
    . "<td>M1S2</td>"
    . "<td>M2S1</td>"
    . "<td>M2S2</td>"
    . "<td>Heat No.</td>"
    . "<td>Heat Start time </td>"
    . "<td>Heat End Time</td>"
    . "<td>Total heat time </td>"
    . "<td>Total BD time </td>"
    . "<td>3st3mtrbbp</td>"
    . "<td>3st6mtrbbp</td>"
    . "<td>ccm3mtrbbp</td>"
    . "<td>ccm6mtrbbp</td>"
    . "<td>bbpurelyccm</td>"
    . "<td>missroll</td>"
    . "<td>Cum-missroll</td>"
    . "<td>8mm</td>"
    . "<td>10mm</td>"
    . "<td>12mm</td>"
    . "<td>16mm</td>"
    . "<td>20mm</td>"
    . "<td>25mm</td>"
    . "<td>28mm</td>"
    . "<td>32mm</td>"
    . "<td>rollingprod</td>"
    . "<td>cum-rollingprod</td>"
    . "<td>ccmprod</td>"
    . "<td>cum-ccmprod</td>"
    . "<td>hotrolling</td>"
    . "<td>cum-hotrolling</td>"
    . "<td>perbbpmill</td>"
    . "<td>perbbpccm</td>"
    . "<td>perbbp3st</td>"
    . "<td>perbbpfnce</td>"  
    . "<td>perbbpmpeb</td>"        
    . "<td>perbbpcontr</td>"
    . "<td>perbbpother</td>"
    . "<td>Button</td>";

    $res_perheat = mysqli_query($link, $sql_perheat)  or die(mysqli_error($link));
   /** echo $date1;
    echo $date2;
    echo "<br>";**/
   // $num_row = mysqli_num_rows($link,$res_perheat);
    //echo $num_row;
    while ($row_perheat = mysqli_fetch_array($res_perheat)) {
       // echo 'in while';
        
        echo "<tr>";
        for ($i = 0; $i < 39; $i++) {
            echo "<td>" . $row_perheat[$i] . "</td>";
        }
         echo "<td><button id='".$row_perheat[39]."' type=\"button\" onclick=\"perheatDeleteSummary(this.id);\"> Delete </button></td>";
    }
    
    echo "</table>";
}else {
    echo "Not Connect";
}
?>
<br><br>
<!-- DOWNLOAD THE EXCEL FILE TO GET THE DATA ON THE BASIS OF THE SELECTED DATE    -->
<a href="PerheatExcel.php"> PerHeatExcelReport </a> </br></br>
<a href="../Home.php"> Home </a> 