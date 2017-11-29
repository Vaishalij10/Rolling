<?php


//   require_once '..\Connection.php';
   require_once '..\DBfile.php';
   require_once '..\PostMessagetoSlack.php';
   
   if ($_POST['action'] === "checkSlack") {

       
       $scrapDate = $_POST['scrapDate'];
        $show_date = DateTime::createFromFormat('d/m/Y', $scrapDate)->format('Y-m-d');
       $typeOfScrapArray = $_POST['typeOfScrapArray'];
       $stockArray = $_POST['stockArray'];

      $furnaceId=ScrapRpt::getInstance()->get_furnace_id($_POST['furnaceName']);
 
 $slackMsg=''."Date-".$show_date."\n"."Furnace-".$furnaceId;
   
     
      for($r=0; $r <= count($typeOfScrapArray)-1; $r++){
          
       $slackMsg = $slackMsg."\n " .$typeOfScrapArray[$r].'=' .$stockArray[$r];
          
      }
      
      echo $slackMsg;
      Slack::getInstance()->postMessagesToSlack_scrapregister("$slackMsg","Test");
      // echo var_dump($typeOfScrapArray);

 
   }
 