

<?php
include('..\Connection.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Scrap supervisor Report</title>

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

                            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
                                <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
                                <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
                                <script language="javascript" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.14.3.js"></script>


                                <link rel="stylesheet" href="./css/bootstrap.min.css" />
                                <link rel="stylesheet" href="./css/bootstrap-datetimepicker.min.css" />
                                <link rel="stylesheet" href="./css/font-awesome-min.css" />
                                <script type="text/javascript" src="../js/jquery.min.js"></script>
                                <script type="text/javascript" src="../js/moment.min.js"></script>
                                <script type="text/javascript" src="../js/bootstrap.min.js"></script>
                                <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script> 
                                <script type="text/javascript" src="./ValidationPerHeat.js"></script>
                                <script type="text/javascript">
                                    function testClick(dataTable)
                                    {
                                        var table = document.getElementById(dataTable);
                                        for (var i = 3, row; row = table.rows[i]; i++) {
                                        for (var j = 1, col; col = row.cells[j]; j++) {
                                        alert(table.rows[i].cells[j].firstChild.value);
                                    }
                                }
                                    }
                                    </script>
                                    

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Scrap supervisor Report</a></h1>
		<form id="form_59195" class="appnitro"  method="post" action="testClick()">
					<div class="form_description">
			<h2>Scrap supervisor Report</h2>
			<p>This is your form description. Click here to edit.</p>
		</div>						
			<ul >
                            
                         
                                                            <li id="li_1">
                                                        <div ng-app="myApp" ng-controller="myCntrl"> 

                                                            <label class="description" for="element_1">Date<span class="required">*</span> </label>
                                                            <div>

                                                                <input type="text" uib-datepicker-popup="{{dateformat}}" ng-model="dt" is-open="showdp" max-date="dtmax" name="kpidate" id="kpidate"/>
                                                                <span>
                                                                    <button type="button" class="btn btn-default" ng-click="showcalendar($event)">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <script language="javascript">
                                                                        angular.module('myApp', ['ngAnimate', 'ui.bootstrap']);
                                                                        angular.module('myApp').controller('myCntrl', function ($scope) {
                                                                            $scope.today = function () {
                                                                                $scope.dt = new Date();
                                                                            };
                                                                            $scope.dateformat = "dd/MM/yyyy";
                                                                            $scope.today();
                                                                            $scope.showcalendar = function ($event) {
                                                                                $scope.showdp = true;
                                                                            };
                                                                            $scope.showdp = false;
                                                                            $scope.dtmax = new Date();
                                                                        });

                                                            </script>

                                                        </div> 		
 </li>
			
                            <li id="li_1" >
                                <label class="description" for="element_1">Plant </label>
                                <div>
                                    <select class="element select medium" id="plantname" name="plantid"> 
                                        <option disabled selected value> -- select -- </option>
                                        <?php
                                        $q1="select * from furnace";
                                        $s1 = mysqli_query($conn, $q1);
                                        while ($r1 = mysqli_fetch_array($s1)):;
                                        ?>
                                        <option value="<?php echo $r1[0]; ?>"><?php echo $r1[1]; ?></option>
<?php
endwhile;
?>	
                        
                                    </select>
                                </div> 
                            </li>
                        <li id="li_2" >
                            
                            <table border="1" BORDER=2 CELLSPACING=2 CELLPADDING=1 id="dataTable">
                                <label class="description" for="element_1" align ="center"><h5 style="color:#8B0000;">Scrap Supervisor Register </h5></label><br>  
          <tr rowspan='2'><th rowspan="2">Types of Scrap</th>
              <th colspan="4" rowspan="1" align="center" type="text">Scrap Details</th> </tr>
         <tr>
     <th colspan="2"  align="center"  size="small" type="text"> Stock</th> 
     <th colspan="1"  align="center"  size="small" type="text"> SR% </th>
     <th colspan="2"  align="center"  size="small" type="text"> ASC% </th>

             </tr>
             <tr size="10%">
                                        <?php 
       include('..\Connection.php');
      
       $sql= mysqli_query($conn,"select scraptype from scrap");
       
 
  
       while($scrap_row=mysqli_fetch_row($sql))
       {
          
           $scrap_arr[]=$scrap_row;

       }
       
          $scrapdetails= array('x','y','z');
          
          foreach ($scrap_arr as $key => $value1){
              $value1[]='';
             echo "<tr rowspan='2'><td colspan='2'> $value1[0]</td>";
             
             foreach ($scrapdetails as $value) {
               // $str_scrapdet=implode('-',$value);
                //$str_scraptype= implode('-', $scrapdetails)
                
               echo "<td><input type='text' maxlength='255'></input></td>";
             }
            
  echo "</tr>";
           }
           echo "</table>";
        ?>   
                                        
                                        
                                        
                               
                        
                        
                        </li>
                            
                            
			
                            <li class="buttons">
                                <input type="hidden" name="form_id" value="59195" />

                                <input id="saveForm" class="button_text" type="button" value="Submit" onclick="testClick('dataTable');"/>
                            </li>
                        </ul>
                </form>	
                <div id="footer">
                    Generated by <a href="http://www.phpform.org">pForm</a>
                </div>
        </div>
        <img id="bottom" src="bottom.png" alt="">
            </body>
            </html>