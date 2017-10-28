<?php


// Form to get the Breakdown Details in between from date and to date .
session_start();
include('..\Connection.php');

extract($_GET);
$date1 = date('Y-m-d', strtotime($date1));
$date2 = date('Y-m-d', strtotime($date2));


$_SESSION["date1"] = $date1;
$_SESSION["date2"] = $date2;




// Query to get the Details from the breakdown table on the basis of from date and to date .
if ($link != NULL) {
    //$res=  mysqli_query($con,"select location.locationid,location.locationname from location INNER JOIN breakdown ON location.locationid=breakdown.breakdown_id");
   $res = mysqli_query($link, "select b.date,b.heat_number,
             s1.sizename,s2.sizename,b.shift,b.bd_start_time,
             b.bd_end_time,
             b.bd_total_time,
             b.stand,
             b.dependent_mr,
             b.independent_mr,
             b.total_mr,
             b.no_of_cutting,
             b.bp3_mtr,
             b.bp6_mtr,
             b.total,
             b.avg_3mtr_wt,
             b.avg_6mtr_wt,
             r.reason_code,
             p.name,
             l.locationname,
             d.dname,
             r.reason_code,
             b.bd_detail
            
            from breakdown b , size s1 ,size s2,location l , department d , reason r ,person p
            where b.m1s = s1.sizename
            and b.m2s = s2.sizename
            and b.location_code = l.locationid
            and b.department= d.departmentid
             and b.reasonid = r.reasonid
             and b.responsible_person= p.personid
             and b.date >= '$date1' and b.date <= '$date2' order by b.date");
    
    echo "<table border=1>";
    echo "<tr><td>Date</td>"
    . "<td>Heat Number</td>"
    . "<td>Mill-1 Size</td>"
    . "<td>Mill-2 Size</td>"
    . "<td>Shift</td>"
    . "<td>BD Start Time</td>"
    . "<td>BD End Time</td>"
    . "<td>BD Total Time</td>"
    . "<td>Stand</td>"
    . "<td>Dependent MR</td>"
    . "<td>Independent MR</td>"
    . "<td>Total MR</td>"
    . "<td>Cutting</td>"
    . "<td>3 MTR BP</td>"
    . "<td>6 MTR BP</td>"
    . "<td>Total Number of BP</td>"
    . "<td>AVG 3 MTR Billet Wt</td>"
    . "<td>AVG 6 MTR Billet Wt</td>"
    . "<td>Responsible Person</td>"
    . "<td>Location Code</td>"
    . "<td>Department</td>"
    . "<td>Shift Foreman</td>"
    . "<td>Reason Code</td>"
    . "<td>BD Detail</td>";
    
    
    //echo $date1;
   // echo $date2;
   /// $num= mysqli_num_rows($res);
    //echo $num;
    echo 'Breakdown Details ';
    while ($row = mysqli_fetch_array($res)) {
        echo "<tr>";
        for ($i = 0; $i <24; $i++)
            echo "<td>" . $row[$i] . "</td>";
    }
    echo "</table>";
} else
    echo "Not Connect";
?>
<br><br>

<!-- Exporting the Data to the excel sheet -->
<a href="Breakdown_Excel.php"> Export To Excel </a> </br></br>
<a href="../home.php"> Home </a> 