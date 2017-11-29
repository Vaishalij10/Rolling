

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
                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                    <script type="text/javascript" src="./InsertValueTable.js"></script>
                    <script type="text/javascript" src="./SlackMessage.js"></script>
                    <script type="text/javascript" src="./ScrapRegisterValidations.js"></script>
                    <script type="text/javascript">
                        
                        function testClick(dataTable)
                            {
                                                      
                            if(confirm('Do you want to submit the form?')){
                                var table = document.getElementById(dataTable);
                                var callInsert;
                                var totalScrap = 0;
                                    var typeOfScrapArray = [];
                                    var stockArray = [];
                                    var srArray = [];
                                    var ascArray = [];
                                for (var i = 3, row; row = table.rows[i]; i++) {
                                if(table.rows[i].cells[1].firstChild.value !== ""){
                                    totalScrap = parseFloat(totalScrap) + parseFloat(table.rows[i].cells[1].firstChild.value);
                                        }
                                    }
                                for (var i = 3, row; row = table.rows[i]; i++) {
                                    callInsert = false;
                                    var rowData = [];
                                    for (var j = 1, col; col = row.cells[j]; j++) {
                                        if(table.rows[i].cells[1].firstChild.value !== ""){
                                            callInsert = true;
                                            rowData.push(table.rows[i].cells[j].firstChild.value);
                                        }
                                    }
                                    
                                            
                                    if(callInsert){
                                        typeOfScrapArray.push(table.rows[i].cells[0].firstChild.data);
                                        stockArray.push(table.rows[i].cells[1].firstChild.value);
                                        srArray.push(table.rows[i].cells[0].firstChild.data);
                                        ascArray.push(table.rows[i].cells[0].firstChild.data);
                                        rowData.push(totalScrap);
                                    testCheck (rowData);
                                }
                                
                              window.location.href = "/Furnace/Home.php/"; 
                                }
                                testSlack(typeOfScrapArray, stockArray, srArray, ascArray);
                            
                                
    }                      
                              
                            }
                    </script>
 
                    </head>
                    <body id="main_body" >
                          
                        <img id="top" src="top.png" alt="">
                            <div id="form_container">
                                <h1><a>Scrap supervisor Report</a></h1>
                                 <p> <a href="http://192.168.2.141/Furnace/Home.php"> Home </a> </p>
                                 <form id="form_59195" class="appnitro"  method="post" action="testClick()">
                                    <div class="form_description">
                                        <h2>Scrap Supervisor Report</h2>
                                        <p>This is your form description. Click here to edit.</p>
                                    </div>						
                                    <ul >
                                        <li id="li_1">
                                            <div ng-app="myApp" ng-controller="myCntrl"> 

                                                <label class="description" for="element_1">Date <span class="required">*</span> </label>
                                                <br>
                                                <div>

                                                    <input type="text" uib-datepicker-popup="{{dateformat}}" ng-model="dt" is-open="showdp" max-date="dtmax" name="date" id="date" required />
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
                                            <label class="description" for="element_1">Plant<span class="required">*</span> </label>
                                            <div>
                                                <select class="medium" id="plantid" name="plantname" required/> 
                                                    <option disabled selected value> -- select -- </option>
                                                    <?php
                                                    $q1 = "select * from furnace";
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
                                            <!-- Hidden Input type for the -->
                                            <table border="1" BORDER=2 CELLSPACING=2 CELLPADDING=1 id="dataTable">
                                                <label class="description" for="element_1" align ="center"><h3 style="color:#8B0000;">Scrap Supervisor Register </h3></label> 
                                                    <tr rowspan='2'><th rowspan="2">Types of Scrap</th>
                                                        <th colspan="4" rowspan="1" align="center" type="text">Scrap Details</th> </tr>
                                                    <tr>
                                                        <th  align="center"  size="small" type="text"> Stock(in MT)</th> 
                                                        <th  align="center"  size="small" type="text"> SR% </th>
                                                        <th  align="center"  size="small" type="text"> ASC% </th>

                                                    </tr>
                                                    <tr size="10%">
                                                        <?php
                                                        include('..\Connection.php');

                                                        $sql = mysqli_query($conn, "select * from scrap");



                                                        while ($scrap_row = mysqli_fetch_row($sql)) {

                                                            $scrap_id[] = $scrap_row[0];
                                                            $scrap_type[] = $scrap_row[1];
                                                        }

                                                        $scrapdetails = array('x', 'y', 'z');
                                                        $scrap_id_keys = array_keys($scrap_id);
                                                        $scrap_type_keys = array_keys($scrap_type);

                                                        for ($index = 0; $index < count($scrap_type_keys); $index++) {
                                                            echo "<tr><td>" . $scrap_type[$scrap_type_keys[$index]] . "</td>";
                                                            foreach ($scrapdetails as $value) {
                                                                // $str_scrapdet=implode('-',$value);
                                                                //$str_scraptype= implode('-', $scrapdetails)

                                                                echo "<td><input type='text' maxlength='255'onkeypress= 'return IsNumeric(event);'/></input></td>";
                                                            }
                                                            echo "<td style='display:none;'><input type='text' value=" . $scrap_id[$scrap_id_keys[$index]] . "></input></td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "</table>";
                                                        ?>   
                                                   <span id="error" style="color: Red; display: none">* Please Enter Number </span>
                                        
                                                        </li>		<li id="li_11" >
                                                            <label class="description" for="element_11">Remarks</label>
                                                            <div>
                                                                <textarea id="remarks" name="remarks" class="element textarea small"></textarea> 
                                                            </div> 
                                                        </li>

                                        
                                        
                                                        <li class="buttons">
                                                            <input type="hidden" name="form_id" value="59195" />

                                                            <!--<input id="saveForm" class="button_text" type="button" value="Submit" onclick="testClick('dataTable');"/>-->
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