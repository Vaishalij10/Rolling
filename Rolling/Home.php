


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                var dateFormat = "dd/mm/yyyy",
                        from = $("#from")
                        .datepicker({
                            //defaultDate: "1w",
                            changeMonth: true,
                            numberOfMonths: 1
                        })
                        .on("change", function () {
                            to.datepicker("option", "minDate", getDate(this));
                        }),
                        to = $("#to").datepicker({
                    //defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                        .on("change", function () {
                            from.datepicker("option", "maxDate", getDate(this));
                        });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }
            });
        </script>
    </head>
    <body>


        <script>
       function redirect()
       {
             var checkbd=document.getElementById("breakdown").checked;
             var checkph=document.getElementById("perheat").checked;
             var checkpr=document.getElementById("powerreport").checked;
             
             var formx=document.getElementById("dateHolder");
             
             if( checkbd === true)
                            
        {
           <!-- alert('breakdown');-->
            formx.action='Breakdown/viewbreakdown.php';
            formx.submit();
        }

        else if(checkph === true)
        {
            <!--alert('perheat');-->
            formx.action='Perheat/ViewPerHeat.php';
            formx.submit();
        }   
        
        
         else if(checkpr === true)
        {
            <!--alert('perheat');-->
            formx.action='PowerReport/ViewPowerReport.php';
            formx.submit();
        }   
        else
        {
            alert('please select check box ');
        }
    }

    </script>
    
            <div class="demo-content">
                <h2 class="title_with_link">Rolling Form</h2>
                <h3> PLEASE SELECT OPTION TO GET THE DETAILS IN THE EXCEL </h3>
                <input type="radio" name="rolling" id="breakdown" />Breakdown 
                <input type="radio" name="rolling" id="perheat"/> Per heat 
                <input type="radio" name="rolling" id="powerreport"/> Power Report <br><br>
                  
                  <form id="dateHolder" name="dateHolder" method="GET"  action="">
                      
                      <input type="text" placeholder="From Date" id="from" name="date1"  class="input-control" required/>
                        <input type="text" placeholder="To Date" id="to" name="date2"  class="input-control"  required/>			 





                        <input  type="button" name="search" value="Submit"  onclick="redirect();"/><br>
                    <br>
                </form>
                Still not filled a breakdown form <a href="Breakdown\Newbreakdown.php">Click here to fill Rolling Breakdown</a>
              
                 <br><br>
                        
                 
               Still not filled a Per Heat form   <a href="Perheat\NewPerHeatProd.php"> Click here to fill Per heat Production </a>

                <br><br>
                        
                 
                Still not filled a Power Report Form  <a href="PowerReport\NewPowerReport.php"> Click here to fill Power Report </a>
                 <br><br>
                        
                 
                 Still not filled a KPI Report Form  <a href="KPI\NewRollingKPI.php"> Click here to fill Rolling KPI </a>

                
                
                
                <!--</body>-->
                </html>
