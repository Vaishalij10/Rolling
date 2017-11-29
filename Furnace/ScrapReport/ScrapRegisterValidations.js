/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
                          var specialKeys = new Array();
                                    specialKeys.push(8); //Backspace

                                 function IsNumericValidationDecimal(e) {
                                    var keyCode = e.which ? e.which : e.keyCode;
                                    var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1);
                                    return ret;
                                    }
                 function IsNumeric(e) {
                     var ret = IsNumericValidationDecimal(e);
                      document.getElementById("error3").style.display = ret ? "none" : "inline";
                     return ret;
                                  }