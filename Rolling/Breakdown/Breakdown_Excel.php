
<?php

session_start();
$date1 = $_SESSION["date1"];
$date2 = $_SESSION["date2"];


$con = mysqli_connect("localhost", "root", NULL, "rolling", 3306);


$res = mysqli_query($con, "select b.date,b.heat_number,
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
             r.reason_code,
             p.name,
             l.locationname,
             d.dname,
             b.bd_detail
            from breakdown b , size s1 ,size s2,location l , department d , reason r ,person p
            where b.m1s = s1.sizename
            and b.m2s = s2.sizename
            and b.location_code = l.locationid
            and b.department= d.departmentid
             and b.reasonid = r.reasonid
             and b.responsible_person= p.personid
             and b.date >= '$date1' and b.date <= '$date2' order by b.date ");

//$setRec = mysqli_query($conn, $res);  

$columnHeader = '';
$columnHeader = "Date" . "\t" .
        "Heat Number" . "\t" .
        "Mill-1 Size" . "\t" .
        "Mill-2 Size" . "\t" .
        "Shift" . "\t" .
        "BD Start Time" . "\t" .
        " BD End time" . "\t" .
        "BD Total Time" . "\t" .
        "Stand" . "\t" .
        "Dependent MR" . "\t" .
        "In Dependent MR" . "\t" .
        "Total MR" . "\t" .
        "Cutting" . "\t" .
        "3 MTR BP" . "\t" .
        "6 MTR BP" . "\t" .
        "Total Number of BP" . "\t" .
        "Reason Code" . "\t" .
        "Responsible Person" . "\t" .
        "Location_code" . "\t" .
        "Department" . "\t" .
        "BD Detail" . "\t";

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
header("Content-Disposition: attachment; filename=Breakdown_excel.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";
?> 