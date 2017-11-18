    <?php
//TP GET THE DETAILS FROM THE FILLED FORMS AND INSERTING THEM TO THE ROLLING DATABASE IN BREAKDOWN TABLE
    
    
    
include('..\DBfile.php');
include('..\Connection.php');
include('..\postMessagesToSlack.php');
/* Attempt MySQL server connection. Assuming you are running MySQL
  server with default setting (user 'root' with no password) */


// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// FORMATING THE DATE IN THE YYYY-MM-DD , AS THE DATABASE SUPPORTS ONLY THIS FORMAT
$date = strtr($_REQUEST['date'], '/', '-');
$bd_date= date('Y-m-d', strtotime($date));

//$date = $_POST['date'];
//echo $date;
//$bd_date=date('Y-d-m', strtotime($date));

$hnumber = $_POST['hnumber'];
// GETTING THE M1SIZE AND M2SIZE FROM THE DBFILE.PHP (FROM SIZE TABLE)
$m1size = RollingBD::getInstance()->get_size_id($_POST['m1size']);
//echo $m1size;

$m2size = RollingBD::getInstance()->get_size_id($_POST['m2size']);
//echo $m2size;



$shift = $_POST['shift'];
$start_time = $_POST['sTime_only'];
$end_time = $_POST['eTime_only'];
$start_time_whole = $_POST['start_time'];
$end_time_whole = $_POST['end_time'];
$stand = $_POST['stand'];
$dependent_mr = $_POST['dependent_mr'];
$independent_mr = $_POST['independent_mr'];
$cutting = $_POST['cutting'];
$bp_3mtr = $_POST['bp_3mtr'];
$bp_6mtr = $_POST['bp_6mtr'];
$avg_3mtr = $_POST['avg_3mtr'];
$avg_6mtr = $_POST['avg_6mtr'];
$responsible_person = $_POST['responsible_person'];
$location_code = $_POST['location_code'];
$department = $_POST['department'];
$shift_formen = $_POST['shift_formen'];
$reasonid = $_POST['reasonid'];
$bd_action = $_POST['bd_action'];


//calculating time diff in decimal
$total_time = abs(strtotime($end_time_whole) - strtotime($start_time_whole)) / 3600;

//converting time from decimal to hh:mm format
// start by converting to seconds
 $seconds = ($total_time * 3600);
// we're given hours, so let's get those the easy way
$hours = floor($total_time);
// since we've "calculated" hours, let's remove them from the seconds variable
$seconds -= $hours * 3600;
// calculate minutes left
$minutes = floor($seconds / 60);
// remove those from seconds as well
$seconds -= $minutes * 60;
// return the time formatted HH:MM:SS
$total_time = lz($hours) . ":" . lz($minutes); //.":".lz($seconds);

//$total_billets_bypass = $bp3_mtr + ($bp6_mtr * 2);

//Function to check the time Difference

    
    
        
function lz($num) {
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

// CALCULATING TOTAL MISSROLLS (TOTAL MISSROL- INDEPENDENT + DEPENDENT MISSROLL)

$total_mr = $dependent_mr + $independent_mr;
//CALCULATING TOTAL BILLETS BYPASS 

$total = $bp_3mtr + ($bp_6mtr * 2);

//ALL THE PRODUCTION RELATED DATA MSUT BE CALCULATED IN METRIC TON 
//CALCULATING TOTAL MISS ROLLS PRODUCTION ( MR PRODUCTION = TOTAL MISSROLL * AVG 3MTR BILLET WEIGHT)

$mr_production= ($total_mr * $avg_3mtr)/1000;

// 3TR BILLETS BYPASS PRODUCTION ( 3MTRBILLETSBYPASS PRODUCTION = BILLETSBYPAS3MTR *AVG 3MTR BILLETSWEIGHT)/1000
$three_mtr_billets_bp_production = ($bp_3mtr * $avg_3mtr)/1000;
// 6MTR BILLETS BYPASS PRODUCTION ( 6MTR BILLETS BYPASS PRODUCTION= BILLETS BYPASS 6MTR* AVG 6MTR BILLET WEIGHT)/1000
$six_mtr_billets_bp_production = ($bp_6mtr * $avg_6mtr)/1000;

// TOAL BILLETS BYPASS PRODUCTION I.E. DUE TO 3MTR BILLETS AND 6MTRR BILLETS WEIGHT)
$total_bbp_production = $three_mtr_billets_bp_production + $six_mtr_billets_bp_production;

//TOTAL CUTTING WEIGHT
$total_cutting_wt= ($cutting)/10;

// GETTHE DETAILS FROM THE DEPARTMENT TABLE 
$dpt_id = RollingBD::getInstance()->get_department_id($_POST['department']);
//GET THE DETAILS FROM THE PERSON TABLE
$per_id = RollingBD::getInstance()->get_person_id($_POST['responsible_person']);
// GET THE DETAILS FROM THE LOCATION 
$loc_id = RollingBD::getInstance()->get_location_id($_POST['location_code']);
// GET THE DETAILS FROM THE REASON TABLE 
$rea_id = RollingBD::getInstance()->get_reason_id($_POST['reasonid']);


  // QUERY TO INSERT VALUES IN TO THE BREAKDOWN TABLE 
 $sql = "INSERT INTO `breakdown` (`date`, `heat_number`, `m1s`, `m2s`,
    `shift`, `bd_start_time`,`bd_end_time`,`bd_total_time`, `stand`, `dependent_mr`, `independent_mr`,`total_mr`,
    `no_of_cutting`, `bp3_mtr`,`bp6_mtr`,`total`, `avg_3mtr_wt`, `avg_6mtr_wt`, 
    `responsible_person`, `location_code`, `department`, `shift_foreman`, `reasonid`,`bd_detail`,
    `mr_production`,`three_mtr_billets_bp_production`,`six_mtr_billets_bp_production`,`total_bbp_production`,`cutting_wt`)
     
VALUES 
     
('" . $bd_date . "','" . $hnumber . "','" . $m1size . "',"
 . "'" . $m2size . "', '" . $shift . "','" . $start_time_whole . "','" . $end_time_whole . "','" . $total_time . "',"
 . " '" . $stand . "', '" . $dependent_mr . "', "
 . "'" . $independent_mr . "', '" . $total_mr . "', '" . $cutting . "',"
 . " '" . $bp_3mtr . "', '" . $bp_6mtr . "', '" . $total . "',"
 . "'" . $avg_3mtr . "', '" . $avg_6mtr . "' ,"
 . "'" . $responsible_person . "','" . $location_code . "', "
 . "'" . $department . "', '" . $shift_formen . "', " 
 . "'" . $reasonid . "', '" . $bd_action . "','" . $mr_production ."', '" .$three_mtr_billets_bp_production . "', '".$six_mtr_billets_bp_production."', '".$total_bbp_production."','".$total_cutting_wt."')";





$test = (mysqli_query($link, $sql) or die(mysqli_error($link)));

if (!$test) {
    echo "not added";
    //echo "$hn";
} else {
    echo "Records added";
   
    if($dependent_mr==""){
        $dependent_mr=0;
    }
    else{
        $dependent_mr=$_POST['dependent_mr'];
    }
    if($independent_mr==""){
        $independent_mr=0;
    }
    else{
        $independent_mr=$_POST['independent_mr'];
    }
   
 if( $bp_3mtr==""){
         $bp_3mtr=0;
    }
    else{
         $bp_3mtr=$_POST['bp_3mtr'];
    }
    if( $bp_6mtr==""){
         $bp_6mtr=0;
    }
    else{
         $bp_6mtr=$_POST['bp_6mtr'];
    }
    // SEND MESSAGE TO SLACK IN ROLLING CHANNEL
    Slack::getInstance()->postMessagesToSlack("*Date-* *$date*
    *HN-* *`$hnumber`* *M1S-* *`$m1size`* *M2S-* *`$m2size`*
    *BD Start-* *`$start_time`* *BD End-* *`$end_time`* *Net-* *`$total_time`*
    *DEP-* *`$dependent_mr`*  *INDEP-* *`$independent_mr`* *TMR-* *`$total_mr`*
    *BP3-* *`$bp_3mtr`* *BP6-* *`$bp_6mtr`* *TBP-* *`$total`*
     *`$loc_id`*
     *`$rea_id`*
     *`$dpt_id`*
     *`$per_id`*
     
    "
    ,"Rathi-test"
            );
    //echo "$hn";
}

//print '<script type="text/javascript">';
//print 'alert("Record Added successfully..")';

mysqli_close($link);
header("Location: http://192.168.2.141/Rolling/Home.php");
exit();
?>

<!--<a href="home.php"> Home </a> -->
