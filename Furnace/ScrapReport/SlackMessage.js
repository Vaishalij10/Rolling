


function testSlack(typeOfScrapArray, stockArray, srArray, ascArray){
        var scrapDate = document.getElementById("date").value;
        var furnaceName= document.getElementById("plantid").value;

           $.ajax({
               url: 'Slack.php',
               type: 'post',
               async: false,
               data: {'action': 'checkSlack', 'typeOfScrapArray' : typeOfScrapArray, 'stockArray' : stockArray, 'srArray' : srArray, 'ascArray' : ascArray, 'scrapDate': scrapDate, 'furnaceName':furnaceName},                                                                                                                                                                                                                            
               error: function (xhr, desc, err) {
                   alert ('error');
                   console.log(xhr);
                   console.log("Details: " + desc + "\nError:" + err);
               }
       });
}

