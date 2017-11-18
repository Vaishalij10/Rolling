                    var specialKeys = new Array();
                    specialKeys.push(8); //Backspace
                    function IsNumericValidationDecimal(e) {
                        var keyCode = e.which ? e.which : e.keyCode;
                        var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1);
                        return ret;
                    }
                    function IsNumericValidation(e) {
                        var keyCode = e.which ? e.which : e.keyCode;
                        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1);
                        return ret;
                    }
                    function IsDecimalm1s1(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("m1s1error").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    
                             function IsDecimalm1s2(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("m1s2error").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalm2s1(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("m2s1error").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalm2s2(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("m2s2error").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimal3s3m(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("3s3merror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimal3s6m(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("3s6merror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalccm3m(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("ccm3merror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalccm6m(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("ccm6merror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    //Numeric Validations

                    function IsNumrpm1s1(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error1").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumrpm1s2(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error2").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumrpm2s1(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error3").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumrpm2s2(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error4").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumbbp3(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error5").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumbbp6(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error6").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumbbp3c(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error7").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsNumbbp6c(e) {
                        var ret = IsNumericValidation(e);
                        document.getElementById("error8").style.display = ret ? "none" : "inline";
                        return ret;
                    }

/**
 * VALIDATIONS TO AVOID DUPLICATE HEAT NUMBER
 */
 
 function heatNumberCheck() {
    //  alert ('in test Validation Function ');
    var heatnumber = document.getElementById("heatnumber").value;
    var perDate = document.getElementById("perheatdate").value;
    //alert(heatnumber);
    //alert(perDate);
    var finalResult;
    $(document).ready(function () {
        $.ajax({
            url: 'HeatNumValid.php',
            type: 'post',
            async: false,
            data: {'action': 'checkHeat', 'heatnumber': heatnumber, 'perDate': perDate},
            success: function (result) {
                // alert ('hi1');
                //alert(result); 
                // alert('hi');
                if (result > 0) {
                    alert("HEAT NUMBER IS ALREADY PRESENT");
                    alert("PLEASE ENTER NEW HEAT NUMBER");
                    finalResult = false;
                } else {
                    if (confirm('ARE YOU SURE YOU WANT TO SUBMIT THE FORM ?'))
                  
                    {
                        finalResult = true;
                         
                    } else {
                        finalResult = false;
                    }
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });
    // alert('FinalResult');
    return finalResult;
}                                                           
      /**function heatTimeValidation() {
   /** var endTime = document.getElementById('endtime').value;
    var startTime = document.getElementById('starttime').value;
    $endTime = moment(endTime, ["h:mm A"]).format("HH:mm");
    $startTime = moment(startTime, ["h:mm A"]).format("HH:mm");
   if ($endTime === $startTime) {
        alert("Heat Start time and End time Cannot be Same");
        return false;
    }
    if ($endTime < $startTime) {
        alert("Start Time Cannot be Greater than Endtime ");
        return false;
    }
    if (confirm('Are you sure you want to submit this form?')) {      
        return true;
    } else {
        return false;
    }
}**/




       function perheatDeleteSummary(primaryKey){
          
    if(confirm('Are you sure you want to delete this row?')){
            $.ajax({
                url: 'HeatNumValid.php',
                type: 'post',
                async: false,
                data: {'action': 'deletePerHeatSummary', 'primaryKeyForDelete': primaryKey},
                success: function (result) {
                     if(result > 0){
                         alert('Heat Number Deleted Successfully');
                         location.reload();
                     }
                     else{
                         alert('Issue in deleting Breakdown.');
                     }
                },
                error: function (xhr, desc, err) {
                    alert ('error');
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
        });
    }
}       
     