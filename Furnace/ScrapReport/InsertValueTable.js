


function testCheck (rowData){
    var scrapDate = document.getElementById("date").value;
        var furnaceName= document.getElementById("plantid").value;
        var reMarks= document.getElementById("remarks").value;
            $.ajax({
                url: 'AddScrap.php',
                type: 'post',
                async: false,
                data: {'action': 'checkTest', 'rowData': rowData,'scrapDate': scrapDate,'furnaceName':furnaceName,'reMarks':reMarks},
                error: function (xhr, desc, err) {
                    alert ('error');
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
        });
}




function scrapRegDuplicateDateCheck(){
    var scrapDate=document.getElementById("date").value;
    var finalResult;
    $(document).ready(function () {
        $.ajax({
            url: 'DuplicateDateCheck.php',
            type: 'post',
            async: false,
            data: {'action': 'duplicateDateCheck', 'scrapDate': scrapDate},
            success: function (result) {
               alert ('hi_a');
               alert (result); 
               alert('hi');
                if (result > 0) {
                    alert("Data for the Furnace is already present of this Date");
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
