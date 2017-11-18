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
                    function IsDecimalmwh(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mwherror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    
                             function IsDecimalmvah(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mvaherror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalmva(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mvaerror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalpf(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("pferror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimalccd(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("ccderror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalunit3(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("unit3error").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalmoira(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("moiraerror").style.display = ret ? "none" : "inline";
                        return ret;
                    }

                    function IsDecimallt(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("lterror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalbpress(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("bpresserror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalblower(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("hpblowererror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalmpebmwh(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mpebmwherror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalmpebmvah(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mpebmvaherror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    function IsDecimalmpebmva(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("mpebmvaerror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
          
                   function onFormSubmit(){
      //alert ('hi');
      
       var val1 = confirm('Are you sure you want to submit this form?');
      // alert(val1);
       //alert (val2);
       //alert (val3);
       if(val1){
      return true;
       }
       else{
       alert('Please Check Values Again and Submit the Form Again');
       return false;
       
       }
  } 
   function duplicateDateCheck() {
    //  alert ('in test Validation Function ');
   
    var readingDate = document.getElementById("datetime").value;
    //alert(heatnumber);
    //alert(readingDate);
    var finalResult;
    $(document).ready(function () {
        $.ajax({
            url: 'DateCheckValidation.php',
            type: 'post',
            async: false,
            data: {'action': 'powerDateCheck', 'readingDate': readingDate},
            success: function (result) {
               //alert ('hi_a');
              // alert (result); 
               //alert('hi');
                if (result > 0) {
                    alert("Date is already exists ,Please check date and Enter Correct One");
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
   
    // alert('FinalResulpowerDateCheckt');
    return finalResult;
   }     
