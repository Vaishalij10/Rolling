<?php


/**
 * VALIDATIONS FOR THE DUPLICATE POWER READING DATE 
 */
require_once '..\Connection.php';
 //echo 'hi in function1';
if ($_POST['action'] === "kpiDateCheck") {
  //echo 'hi in function2';
    $date_1 = $_POST['kpiDate'];
    //echo $date_ph;
    $kpi_date = date('Y-d-m', strtotime($date_1));
    //echo "reading"; echo"<br>";
      //echo $kpi_date;
   // echo "in powerDateCheck function";
    kpiDateCheck($kpi_date);
   
 
}

function kpiDateCheck($kpi_date) {
//echo "powerDateCheck function1";
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "rolling";
    $link = mysqli_connect($hostname, $username, $password, $databaseName);

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql_2 = "select `kpi_id` from `rollingkpi` where kpidate='".$kpi_date."'";
    $res = mysqli_query($link, $sql_2);
   // $row_1 = mysqli_fetch_array($res);
    $num_1=mysqli_num_rows($res);
     echo $num_1;
}

if ($_POST['action'] === "deleteKPISummary") {
    $primarykey = $_POST['primaryKeyForDelete'];
    echo $primarykey;
    echo deleteKPISummary($primarykey);
}

function deleteKPISummary($primarykey) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "rolling";
    $link = mysqli_connect($hostname, $username, $password, $databaseName);

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql_2 = "delete from rollingkpi where  kpi_id='" . $primarykey . "'";
    $res = mysqli_query($link, $sql_2);
    return $res;
  
}