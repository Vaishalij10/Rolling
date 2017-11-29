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
             var checkreg=document.getElementById("register").checked;
             var checkkpi=document.getElementById("kpi").checked;
             var formx=document.getElementById("dateHolder");
             
             
              if( checkreg === true)
                            
        {
           <!-- alert('breakdown');-->
            formx.action='ScrapReport/ViewScrapReg.php';
            formx.submit();
           
        }

        else if(checkkpi === true)
        {
            <!--alert('perheat');-->
            formx.action='ScrapKPI/ViewScrapKPI.php';
            formx.submit();
        }   
        
         else
        {
            alert('please select check box ');
        }
    }
    
    
   
    </script>
    
     <div class="demo-content">
                <h2 class="title_with_link">Furnace Form</h2>
                <h3> PLEASE SELECT OPTION TO GET THE DETAILS IN THE EXCEL </h3>
                <input type="radio" name="furnace" id="register" />Scrap Register  
                <input type="radio" name="furnace" id="kpi"/> Scrap KPI <br> <br>
             
                  
                  <form id="dateHolder" name="dateHolder" method="GET"  action="">
                      
                      <input type="text" placeholder="From Date" id="from" name="date1"  class="input-control" required/>
                        <input type="text" placeholder="To Date" id="to" name="date2"  class="input-control"  required/>			 




                        <input  type="button" name="search" value="Submit"  onclick="redirect();" /><br>
                    <br>
                </form>
                Still not filled a Scrap Register form <a href="ScrapReport/NewScrapReg.php">Click here to fill Scrap Register</a>
                
                  <br><br>
                        
                 
                  Still not filled a Scrap KPI form   <a href="ScrapKPI/NewScrapKPI.php"> Click here to fill Scrap KPI </a>
                </html>   