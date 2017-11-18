<html>
<body>
    
       <TABLE border="1" BORDER=2 CELLSPACING=2 CELLPADDING=2>

     <label class="description" for="element_25" align="">Scrap Supervisor Register :</label> </br>
     <tr><th colspan="1" rowspan="2">Types of Scrap</th>
         <th colspan="4" align="center"  size="small" class="element text small" type="text">Scrap Details </th> </tr>
     <tr>
     <th colspan="1" align="center"  size="small" type="text">x</th> 
     <th colspan="1" align="center"  size="small" type="text">y</th>
     <th colspan="1" align="center"  size="small" type="text">z</th>
     <th colspan="1" align="center"  size="small" type="text">e</th>
     </tr>
     <tr size="10%">
        <?php 
       include('..\Connection.php');

       $sql= mysqli_query($link,"select scraptype from scrap");
       
       $scrap_arr[]=array();
       while($scrap_row=mysqli_fetch_row($sql))
       {
           $scrap_arr[]=$scrap_row;
           
       }
       
       
          $scrapdetails= array('x','y','z','e');
          
          foreach ($scrap_arr as $key => $value1){
             echo "<tr><td> $value1[0]</td>";
             foreach ($scrapdetails as $value) {
                
               echo "<td><input type='text' class='element text large' maxlength='255'></td>";
             }
            
  echo "</tr>";
           }
           echo "</table>";
        ?>  
          
      </TR>