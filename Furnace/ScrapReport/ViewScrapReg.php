<?php

echo "in view Scrap Register page";

session_start();
include('..\Connection.php');

extract($_GET);

//START AND DATE DAT  IN YYYY-MM-DD (BECAUSE CAN ACCEPT ONLY THIS FORMAT)
$date1 = date('Y-m-d', strtotime($date1));
$date2 = date('Y-m-d', strtotime($date2));


$_SESSION["date1"] = $date1;
$_SESSION["date2"] = $date2;
echo $date1;
echo $date2;


if ($conn!= NULL) {
     
$sql_scrap=mysqli_query($conn,
    "SELECT `Date`, `scraptype`, `furnacename`, `stock`, `sr%`, `asc%` FROM `scrap register` sr,scrap s,
         furnace f WHERE s.scrapid=sr.scrapid and f.furnaceid=sr.furnaceid and sr.Date >='$date1' and  sr.Date <= '$date2' order by date");


echo "<table border='black'>";
    echo "<tr><td align ='center'width='10%'> Date </td>"
    . "<td align ='center' width='10%'>Scrap Type  </td>"
    . "<td align ='center'width='10%'>  Furnace  </td>"
    . "<td align ='center'width='10%'>   Stock  </td>"
    . "<td align ='center'width='10%'>  Asc%  </td>"
    . "<td align ='center'width='10%'>  Sr%  </td>";
    
    while ($row = mysqli_fetch_array($sql_scrap)) {
        echo "<tr>";
        for ($i = 0; $i <6; $i++){
            echo "<td>" . $row[$i] . "</td>";
        }
      
}

      echo "</table>";
}  
else
    {

    echo "Not Connect";
    }
    ?>
<br><br>
   <a href="ScrapRegister.php"> Export To Excel </a> </br></br>
<a href="../home.php"> Home </a> 



