

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Rolling Mill KPI</title>
            <link rel="stylesheet" type="text/css" href="view.css" media="all">
              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                  <script src="js/refreshform.js"></script>
                   <link rel="stylesheet" type="text/css" href="view.css" media="all">

    <!-- Load jQuery from Google's CDN -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
                <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
                <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
                <script language="javascript" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.14.3.js"></script>

                <link rel="stylesheet" href="./css/bootstrap.min.css" />
                <link rel="stylesheet" href="./css/bootstrap-datetimepicker.min.css" />
                <link rel="stylesheet" href="./css/font-awesome-min.css" />
                <script type="text/javascript" src="./js/jquery.min.js"></script>
                <script type="text/javascript" src="./js/moment.min.js"></script>
                <script type="text/javascript" src="./js/bootstrap.min.js"></script>
                <script type="text/javascript" src="./js/bootstrap-datetimepicker.min.js"></script> 
                <script type="text/javascript" src="./ValidationRollingKPI.js"></script>
                 <p> <a href="http://192.168.2.141/Rolling/Home.php"> Home </a> </p>
                            </head>
                            <body id="main_body" >

                                <img id="top" src="top.png" alt="">
                                    <div id="form_container">

                                        <h1><a>Rolling Mill KPI</a></h1>
                                        <form id="form_55349" class="appnitro"  method="post" action="AddRollingKPI.php" onsubmit="return kpiDuplicateDateCheck();">
                                            <div class="form_description">
                                                <h2>Rolling Mill KPI</h2>
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
     <li id="li_2" >
		                                            <label class="description" for="element_2">8mm EndCut Wt(kg) </label>
		                                                      <div>
                                                            <input id="element_2" name="endcut8mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal8mm(event);"/> 
                                                    </div> 
                                                   <span id="error8mm" style="color: Red; display: none">* Please Enter Number </span>         
                                                </li>		<li id="li_3" >
                                                    <label class="description" for="element_3">10mm EndCut Wt(kg) </label>
                                                    <div>
                                                        <input id="element_3" name="endcut10mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal10mm(event);"/> 
                                                    </div> 
                                                     <span id="error10mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_4" >
                                                    <label class="description" for="element_4">12mm EndCutWt(kg) </label>
                                                    <div>
                                                        <input id="element_4" name="endcut12mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal12mm(event);"/> 
                                                    </div> 
                                                     <span id="error12mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		
                                                <li id="li_5" >
                                                    <label class="description" for="element_5">16mm EndCut Wt(kg) </label>
                                                    <div>
                                                        <input id="element_5" name="endcut16mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal16mm(event);"/> 
                                                    </div> 
                                                     <span id="error16mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_6" >
                                                    <label class="description" for="element_6">20mm EndCut Wt(kg) </label>
                                                    <div>
                                                        <input id="element_6" name="endcut20mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal20mm(event);"/> 
                                                    </div> 
                                                     <span id="error20mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_7" >
                                                    <label class="description" for="element_7">25mm EndCut Wt(kg) </label>
                                                    <div>
                                                        <input id="element_7" name="endcut25mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal25mm(event);"/> 
                                                    </div> 
                                                     <span id="error25mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_8" >
                                                    <label class="description" for="element_8">28mm EndCut Wt (kg)</label>
                                                    <div>
                                                        <input id="element_8" name="endcut28mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal28mm(event);"/> 
                                                    </div> 
                                                     <span id="error28mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_9" >
                                                    <label class="description" for="element_9">32mm EndCut Wt (kg)</label>
                                                    <div>
                                                        <input id="element_9" name="endcut32mm" class="medium" type="text" maxlength="255" onkeypress="return IsDecimal32mm(event);"/> 
                                                    </div> 
                                                     <span id="error32mm" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_10" >
                                                    <label class="description" for="element_10">EndCut Missroll Wt(kg) </label>
                                                    <div>
                                                        <input id="element_10" name="endcutmrwt" class="medium" type="text" maxlength="255" value=""onkeypress="return IsDecimalencut(event);"/> 
                                                    </div> 
                                                     <span id="errorencut" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>		<li id="li_11" >
                                                    <label class="description" for="element_11">PerTon Power Consumption </label>
                                                    <div>
                                                        <input id="element_11" name="pertonpower" class="medium" type="text" maxlength="255" onkeypress="return IsDecimalpowercon(event);"/> 
                                                    </div> 
                                                     <span id="powerconerror" style="color: Red; display: none">* Please Enter Number </span>
                                                </li>

                                                <li class="buttons">
                                                    <input type="hidden" name="form_id" value="55349" />

                                                    <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
                                                </li>
                                            </ul>
                                        </form>	
                                        <div id="footer">
                                            Generated by <a href="vaishali.jain@moirasariya.com">MoiraSariya</a>
                                        </div>
                                    </div>
                                    <img id="bottom" src="bottom.png" alt="">
                                        </body>
                                        </html>

