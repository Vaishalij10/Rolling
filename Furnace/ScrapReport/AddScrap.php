
   <?php
   require_once '..\Connection.php';
   require_once '..\DBfile.php';
   
if ($_POST['action'] === "checkTest") {
    
    $date_ph = strtr($_REQUEST['scrapDate'], '/', '-');
    $scrap_date = date('Y-m-d', strtotime($date_ph));

  $furnaceId=$_POST['furnaceName'];   
 
  $remarks=$_POST['reMarks'];
   $rowData = $_POST['rowData'];

     $sql = "INSERT INTO `scrap register` "
             . "(`Date`, `scrapid`, `furnaceid`, `stock`, `sr%`, `asc%`, `total_scrap`, `Remark`) "
             . "VALUES "
             . "('" . $scrap_date . "', '". $rowData[3] ."', '" .$furnaceId. "', '". $rowData[0] ."', '". $rowData[1] ."', '". $rowData[2] ."', '". $rowData[4] ."', '$remarks')";





$test = (mysqli_query($conn, $sql) or die(mysqli_error(conn)));


if (!$test) {
    return  0;
} else {
    return 1;
}
}


















        
