<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--
             ADD PERHEAT PRODUCTION  FORM .
LOGS TO TO ENTER THE  LAST CHANGED DETAILS IN THE CODE
WHENEVER ANY CHANGES DONE IN THE CODE , PLEASE MENTION HERE WITH DATE AND ALSO MENTION
THAT DATE JUST ABOVE THE SECTION WHERE YOU HAVE MADE CHANGES IN THE CODE IN THE COMMENT  LINE.
DATE     lASTCHANGED DETAILS                  USERNAME 

2017-09-12 COMMENTED ALL THE ECHOS AND          VAISHALI JAIN
           FINAL CODE IS TESTED PROPERLY       
-->
<?php
require_once ('../Connection.php');
?>



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
                 <!-- // INCLUDE VALIDATIONPERHEAT.JS FOR THE VALIDATIONS OF  THE 3MTRBILLET WEIGHT(M1S1,M1S2,M2S2 AND M2S2) AND CCM 3MTR BILLET WEIGHT AND CCM 6MTR BILLET WEIGHT  -->
                 <script type="text/javascript" src="./ValidationPerHeat.js"></script>
                 
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                      
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                     
                            <title>Per Heat Production</title>
                            <link rel="stylesheet" type="zzz/css" href="view.css" media="all">
                                <script type="text/javascript" src="view.js"></script>

                                </head>
                                <body id="main_body" >
                                    <img id="top" src="top.png" alt="">
                                        <div id="form_container">
                                            <h1><a>Per Heat Production</a></h1>
                                            <form id="form_44769" class="appnitro"  method="post" action="AddPerHeatProd.php" onsubmit="return heatNumberCheck();">
                                                <div class="form_description">
                                                    <h2>Per Heat Production</h2>
                                                    <p>This is your form description. Click here to edit.</p>
                                                </div>						
                                                <ul >

                                                    <li id="li_1">
                                                        <div ng-app="myApp" ng-controller="myCntrl"> 

                                                            <label class="description" for="element_1">Date<span class="required">*</span> </label>
                                                            <div>

                                                                <input type="text" uib-datepicker-popup="{{dateformat}}" ng-model="dt" is-open="showdp" max-date="dtmax" name="perheatdate" id="perheatdate"/>
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
                                                    <li id="li_15" >
                                                        <label class="description" for="element_15">Roughing <span class="required">*</span></label>
                                                        <div>
                                                            <select class="element select small" id="element_15" name="roughing"  /> 
                                                            <option disabled selected value> -- select -- </option>
                                                            <option value='16'>16</option>
                                                            <option value='18'>18</option>
                                                            <option value='16+18'>16+18</option>

                                                            </select>
                                                        </div> 
                                                    </li>	
                                                    <li id="li_16" >
                                                        <label class="description" for="element_16">Heat Number <span class="required">*</span> </label>
                                                        <div>
                                                            <select class="element select small"  name="heatnumber" id="heatnumber"/>
                                                           <option disabled selected value> -- select -- </option>

                                                            <option value="1" >1</option>
                                                            <option value="2" >2</option>
                                                            <option value="3" >3</option>
                                                            <option value="4" >4</option>
                                                            <option value="5" >5</option>
                                                            <option value="6" >6</option>
                                                            <option value="7" >7</option>
                                                            <option value="8" >8</option>
                                                            <option value="9" >9</option>
                                                            <option value="10" >10</option>
                                                            <option value="11" >11</option>
                                                            <option value="12" >12</option>
                                                            <option value="13" >13</option>
                                                            <option value="13" >14</option>

                                                            </select>
                                                        </div> 



                                                        <li id="li_4" >
                                                            <label class="description" for="element_4">Heat Start time <span class="required">*</span></label>
                                                     
                                                            <div class="form-group">
                                                               <div class='input-group date' id='datetimepicker3'>
                                                                    <input type='text'name ="heatstarttime" id ="starttime" required/>
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--</div>-->
                                                            <script type="text/javascript">
                                                                $(function () {
                                                                    $('#datetimepicker3').datetimepicker({
                                                                        format: 'LT'
                                                                    });
                                                                });
                                                            </script>
                                                         
                                                        </li>	
                                                        <li id="li_41" >
                                                            <label class="description" for="element_41">Heat End time <span class="required">*</span></label>
                                                        
                                                            <div class="form-group">
                                                                <div class='input-group date' id='datetimepicker4'>
                                                                    <input type='text' name ="heatendtime" id="endtime"  required />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!--</div>-->
                                                            <script type="text/javascript">
                                                                $(function () {
                                                                    $('#datetimepicker4').datetimepicker({
                                                                        format: 'LT'
                                                                    });
                                                                });
                                                            </script>
                                                       <h5 style="color:#8B0000;"><b>MILL-1 SIZE-1</b></h5>

                                                            <li id="li_13" >
                                                                <label class="description" for="element_13">M1S1 <span class="required">*</span></label>
                                                                <div>

                                                                    <select class="element select small" id="element_13" name="m1s1" required/>

                                                                    <option disabled selected value> -- select -- </option>
<?php
$query1 = "SELECT * FROM `size`";
$size1 = mysqli_query($link, $query1);
while ($row_per = mysqli_fetch_array($size1)):;
    ?>
                                                                        <option value="<?php echo $row_per[0]; ?>"><?php echo $row_per[1]; ?></option>
                                                                    <?php endwhile; ?>	

                                                                    </select>
                                                                </div> 
                                                            </li>	
                                                            <li id="li_5" >
                                                                <label class="description" for="element_5"> 3 mtr billet Wt(m1s1) </label>
                                                                <div>
                                                                    <input id="element_5" name="3mbwtm1s1" class="element text small" type="text" maxlength="255" onkeypress="return IsDecimalm1s1(event);" /> 
                                                                </div> 
                                                                <span id="m1s1error" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	

                                                            <li id="li_9" >
                                                                <label class="description" for="element_9"> No. of pieces rolled(m1s1)</label>
                                                                <div>
                                                                    <input id="element_9" name="rpm1s1" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsNumrpm1s1(event);"/> 
                                                                </div> 
                                                                <span id="error1" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	


                                                            <h5 style="color:#8B0000;"><b>MILL-1 SIZE-2</b></h5>

                                                            <li id="li_14" >
                                                                <label class="description" for="element_14">M1S2<span class="required">*</span> </label>
                                                                <div>
                                                                    <select class="element select small" id="element_14" name="m1s2" required> 
                                                                        <option disabled selected value> -- select -- </option>
<?php
$query1 = "SELECT * FROM `size` order by sizename";
$size1 = mysqli_query($link, $query1);
while ($row_per = mysqli_fetch_array($size1)):;
    ?>  
                                                                            <option value="<?php echo $row_per[0]; ?>"><?php echo $row_per[1]; ?></option>
                                                                        <?php endwhile; ?>	


                                                                    </select>
                                                                </div> 
                                                            </li>		


                                                            <li id="li_51" >
                                                                <label class="description" for="element_51"> 3 mtr billet Wt(m1s2) </label>
                                                                <div>
                                                                    <input id="element_51" name="3mbwtm1s2" class="element text small" type="text" maxlength="255"  onkeypress="return IsDecimalm1s2(event);"/> 
                                                                </div> 
                                                                <span id="m1s2error" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	

                                                            <li id="li_91" >
                                                                <label class="description" for="element_91"> No. of pieces rolled(m1s2)</label>
                                                                <div>
                                                                    <input id="element_91" name="rpm1s2" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumrpm1s2(event);"/> 
                                                                </div> 
                                                                <span id="error2" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>
                                                            <h5 style="color:#8B0000;"><b>MILL-2 SIZE-1</b></h5>

                                                            <li id="li_80" >
                                                                <label class="description" for="element_80">M2S1 <span class="required">*</span></label>
                                                                <div>

                                                                    <select class="element select small" id="element_80" name="m2s1" required/>

                                                                    <option disabled selected value> -- select -- </option>
                                                                    <?php
                                                                    $query1 = "SELECT * FROM `size`";
                                                                    $size1 = mysqli_query($link, $query1);
                                                                    while ($row_per = mysqli_fetch_array($size1)):;
                                                                        ?>
                                                                        <option value="<?php echo $row_per[0]; ?>"><?php echo $row_per[1]; ?></option>
                                                                    <?php endwhile; ?>	

                                                                    </select>
                                                                </div> 



                                                            </li>	
                                                            <li id="li_81" >
                                                                <label class="description" for="element_82"> 3 mtr billet Wt(m2s1) </label>
                                                                <div>
                                                                    <input id="element_81" name="3mbwtm2s1" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsDecimalm2s1(event);"/> 
                                                                </div> 
                                                                <span id="m2s1error" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	

                                                            <li id="li_82" >
                                                                <label class="description" for="element_82"> No. of pieces rolled(m2s1)</label>
                                                                <div>
                                                                    <input id="element_82" name="rpm2s1" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumrpm2s1(event);"/> 
                                                                </div> 
                                                                <span id="error3" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	


                                                            <h5 style="color:#8B0000;"><b>MILL-2 SIZE-2</b></h5>

                                                            <li id="li_80" >
                                                                <label class="description" for="element_80">M2S2<span class="required">*</span> </label>
                                                                <div>

                                                                    <select class="element select small" id="element_80" name="m2s2"required/>

                                                                   <option disabled selected value> -- select -- </option>
                                                                    <?php
                                                                    $query1 = "SELECT * FROM `size`";
                                                                    $size1 = mysqli_query($link, $query1);
                                                                    while ($row_per = mysqli_fetch_array($size1)):;
                                                                        ?>
                                                                        <option value="<?php echo $row_per[0]; ?>"><?php echo $row_per[1]; ?></option>
                                                                       <?php endwhile; ?>	

                                                                    </select>
                                                                </div>       

                                                            </li>	
                                                            <li id="li_81" >
                                                                <label class="description" for="element_81"> 3 mtr billet Wt(m2s2) </label>
                                                                <div>
                                                                    <input id="element_81" name="3mbwtm2s2" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsDecimalm2s2(event);"/> 
                                                                </div> 
                                                                <span id="m2s2error" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	

                                                            <li id="li_83" >
                                                                <label class="description" for="element_83"> No. of pieces rolled(m2s2)</label>
                                                                <div>
                                                                    <input id="element_9" name="rpm2s2" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumrpm2s2(event);"/> 
                                                                </div> 
                                                                <span id="error4" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>	
                                                            <h5 style="color:#8B0000;"><b>3RD STAND</b></h5>

                                                            <li id="li_111" >
                                                                <label class="description" for="element_111"> 3mtr Billet weight </label>
                                                                <div>
                                                                    <input id="element_111" name="bwt3m3s" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsDecimal3s3m(event);"/> 
                                                                </div> 
                                                                <span id="3s3merror" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>		
                                                            <li id="li_112" >
                                                                <label class="description" for="element_112">6mtr Billet weight </label>
                                                                <div>
                                                                    <input id="element_112" name="bwt6m3s" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsDecimal3s6m(event);"/> 
                                                                </div> 
                                                                <span id="3s6merror" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>


                                                            <li id="li_11" >
                                                                <label class="description" for="element_11"> Billets bypass (3 mtr) </label>
                                                                <div>
                                                                    <input id="element_11" name="bbp3mtr3s" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumbbp3(event);"/> 
                                                                </div> 
                                                                <span id="error5" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>		
                                                            <li id="li_12" >
                                                                <label class="description" for="element_12">Billets bypass (6 mtr) </label>
                                                                <div>
                                                                    <input id="element_12" name="bbp6mtr3s" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumbbp6(event);"/> 
                                                                </div> 
                                                                <span id="error6" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>
                                                            <h5 style="color:#8B0000;"><b>CCM BILLETS BYPASS</b></h5>
                                                            <li id="li_71" >
                                                                <label class="description" for="element_71">CCM (3mtr) Billet Weight </label>
                                                                <div>
                                                                    <input id="element_71" name="3mtrbwtccm" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsDecimalccm3m(event);"/> 
                                                                </div> 
                                                                <span id="ccm3merror" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li> 
                                                            <li id="li_72" >
                                                                <label class="description" for="element_72">CCM (3mtr) Billet Bypass</label>
                                                                <div>
                                                                    <input id="element_72" name="3mtrbbpccm" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsNumbbp3c(event);" /> 
                                                                </div> 
                                                                <span id="error7" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>		

                                                            <li id="li_75" >
                                                                <label class="description" for="element_75"> CCM (6mtr)Billets Weight </label>
                                                                <div>
                                                                    <input id="element_75" name="6mtrbwtccm" class="element text small" type="text" maxlength="255" value="" onkeypress="return IsDecimalccm6m(event);"/> 
                                                                </div> 
                                                                <span id="ccm6merror" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>

                                                            <li id="li_76" >
                                                                <label class="description" for="element_76"> CCM (6mtr)Billets Bypass </label>
                                                                <div>
                                                                    <input id="element_76" name="6mtrbypassccm" class="element text small" type="text" maxlength="255" value=""onkeypress="return IsNumbbp6c(event);"/> 
                                                                </div> 
                                                                <span id="error8" style="color: Red; display: none">* Please Enter Number </span>
                                                            </li>			


                                                            <li class="buttons">
                                                                <input type="hidden" name="form_id" value="44769" />

                                                                <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
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