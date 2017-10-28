<?php
/**
 * VALIDATIONS FOR THE DUPLICATE HEAT NUMBER
 */
require_once '..\Connection.php';

if ($_POST['action'] === "checkHeat") {
    $heatnumber = $_POST['heatnumber'];
    $date_ph = strtr($_REQUEST['perDate'], '/', '-');
    $perheatdate = date('Y-m-d', strtotime($date_ph));
    checkHeat($heatnumber, $perheatdate);
   
 
}

function checkHeat($heatnumber, $perheatdate) {

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "rolling";
    $link = mysqli_connect($hostname, $username, $password, $databaseName);

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $sql_3 = "select `heat-number` from `per_heat_production` where `heat-number`='" . $heatnumber . "' and perheatdate ='" . $perheatdate . "'";
    $result = mysqli_query($link, $sql_3);
    $rowcount = mysqli_num_rows($result);
    echo $rowcount;
}



