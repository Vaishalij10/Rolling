<?php

require_once '..\Connection.php';

if ($_POST['action'] === "duplicateDateCheck") {
    $date_1 = $_POST['scrapDate'];
    $scrap_date = date('Y-d-m', strtotime($date_1));
    duplicateDateCheck($scrap_date);
   
 
}

function duplicateDateCheck($scrap_date) {
//echo "powerDateCheck function1";
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "furnace";
    $link = mysqli_connect($hostname, $username, $password, $databaseName);

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql_2 = "select `furnaceid` from `scrap register` where Date='".$scrap_date."'";
    $res = mysqli_query($link, $sql_2);
   // $row_1 = mysqli_fetch_array($res);
    $num_1=mysqli_num_rows($res);
     echo $num_1;
}