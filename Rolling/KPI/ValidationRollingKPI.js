                      var specialKeys = new Array();
                     specialKeys.push(8); //Backspace
                       function IsNumericValidationDecimal(e) {
                        var keyCode = e.which ? e.which : e.keyCode;
                        var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1);
                        return ret;
                    }
                    
                      function IsDecimal8mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error8mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                       function IsDecimal10mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error10mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                       function IsDecimal12mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error12mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                       function IsDecimal16mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error16mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                       function IsDecimal20mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error20mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                       function IsDecimal25mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error25mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                     function IsDecimal28mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error28mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    
                     function IsDecimal32mm(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("error32mm").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                     function IsDecimalendcutmr(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("encuterror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                     function IsDecimalpowercon(e) {
                        var ret = IsNumericValidationDecimal(e);
                        document.getElementById("powerconerror").style.display = ret ? "none" : "inline";
                        return ret;
                    }
                    
                    
                             /** function onFormSubmit(){
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
  } **/
      function kpiDuplicateDateCheck() {
      alert ('in test Validation Function ');
   
    var kpiDate = document.getElementById("kpidate").value;
    alert(kpiDate);
    var finalResult;
    $(document).ready(function () {
        $.ajax({
            url: 'KPIDateCheckValidation.php',
            type: 'post',
            async: false,
            data: {'action': 'kpiDateCheck', 'kpiDate': kpiDate},
            success: function (result) {
               alert ('hi_a');
               alert (result); 
               alert('hi');
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
   
   
     function kpiDeleteSummary(primaryKey){
          
    if(confirm('Are you sure you want to delete this row?')){
            $.ajax({
                url: 'KPIDateCheckValidation.php',
                type: 'post',
                async: false,
                data: {'action': 'deleteKPISummary', 'primaryKeyForDelete': primaryKey},
                success: function (result) {
                     if(result > 0){
                         alert('KPI FOR THE DAY DELETED SUCCESSFULLY');
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