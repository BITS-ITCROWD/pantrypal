<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   include_once "sidebar.php";

   session_start();
   if(!isset($_SESSION['login_userid'])){
      header("Location: index.php");
   }
   else{
      $userID = $_SESSION['login_userid'];
   }

   // create the sql and retrieve data
   $query = "SELECT * FROM meal_planner WHERE userID ='".$userID."' order by mealDate, mealTime";
   // test for a result
   $result = $db->query($query);
   if ($result === FALSE){
      die(mysql_error());
   }
   
   // place the data into an array
   $row_array = array();
   foreach ($result as $key=>$row){
      $contructed_row ="";
      foreach($row as $index=>$value){
         // this will eliminate the duplicated row and seperate the values with a pipe
         if (!is_string($index)){   
            $seperator = "|";
            $contructed_row .= $value.$seperator;
         }
      }
      // build the array
      array_push($row_array,$contructed_row);
   }
   // write the array to a SESSION variable
   $_SESSION['MP'] = $row_array;
   var_dump($_SESSION['MP']);
   $Monday = getMondaysDate(date('Y-m-d'));
   echo $Monday;
   $mealDay = [Breakfast,Lunch,Dinner];
   $mealTime = [B,L,D];

?>


<head>
   <title>Meal Planner</title>

   <script type="text/javascript" src="js/redips-drag-min.js"></script>
   <script type="text/javascript" src="js/meal-planner.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <!-- datepicker script-->
   <script>
     $(function() {
      $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
     });
   </script>
   
   
   <script>
     $(document).ready(function(){
         $("#datepicker").change(function(){
            var new_date = this.value;
            $Monday = getMondaysDate(new_date);
            alert(new_date);
            
      });
       
     });
   
   </script>





</head>

<body onload="REDIPS.drag.init()">

<!-- NOTE - delete this styling when code completed. Also some styles used in the table elements. -->
<style>
   table, th,td {
      border: 1px solid black;
      
   }    
   td {
      height:50px;
   }
</style>  


<?php

// FUNCTIONS

// determine and return the date of the last Monday
function getMondaysDate($givenDate){
   $givenIndex = date('N',strtotime($givenDate));
   $lastMonday = $givenDate;
   //echo $givenDate;
   //echo "sub no: ".$sub;
   //echo $givenIndex;
   if ($givenIndex != 1){
      $sub = "-". strval($givenIndex-1). " day" ;
      $lastMonday = strtotime ( $sub, strtotime ( $givenDate ) ) ;
      $lastMonday = date( 'Y-m-d' , $lastMonday );
   }
   return $lastMonday;
}






// START

  // draw table containing controls
   $displayDate = date('d/m/Y',strtotime($Monday));
   
   echo "<h2>Meal Planner</h2>";
   echo "<form id='form_planner' method='post' action=".$_SERVER['PHP_SELF'].">";
   echo "<div id='redips-drag'>";
   echo "<table style='width:70%'>";
   echo "<tr>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='back' name='back'/></td>";
   echo "<td class='redips-mark'>Please select new date:<p>Date: <input type='text' id='datepicker' value='$displayDate'</p></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='reset' name='reset'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='copy to another week' name='copy'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='print planner' name='print'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='save' name='save'/></td>";
   echo "<td class='redips-trash'>trash bin</td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='next' name='next'/></td>";
   echo "</tr>";
   echo "</table>";
   
   
   // draw the current week planner details
   // table Day Headings
   
   echo "<table style='width:70%'>";
   echo "<tr>";
   echo "<td class='redips-mark'>MEAL</td>";
   echo "<td class='redips-mark'>Mon</td>";
   echo "<td class='redips-mark'>Tue</td>";
   echo "<td class='redips-mark'>Wed</td>";
   echo "<td class='redips-mark'>Thu</td>";
   echo "<td class='redips-mark'>Fri</td>";
   echo "<td class='redips-mark'>Sat</td>";
   echo "<td class='redips-mark'>Sun</td>";
   echo "</tr>";

   // construct the row
   for ($x=0; $x< sizeof($mealDay); $x++){
         echo "<tr>";
   echo "<td class='redips-mark'>".$mealDay[$x]."</td>";
      $daytemp ="";
      foreach ($row_array as $row) {
         $row_explode = explode("|",$row);
         $diff = date("d",(strtotime($row_explode[1]) - strtotime($Monday)));
         if ($diff <=7 & $diff >=0){
            //echo $diff." - ".$row_explode[1]." , ";
            
            $dIndex = date('N',strtotime($row_explode[1]));
            //echo "index: ".$dIndex. ", ";
            for($col=1; $col<=7; $col++) {
               if($col == $dIndex & $row_explode[2] == $mealTime[$x]){
                  $daytemp[$col] = "<td><div class='redips-drag'> Recipe No: ".$row_explode[3]." ".$row_explode[4]."</div></td>";
               }
               elseif (strlen($daytemp[$col]) <= 9) {
                  $daytemp[$col] = "<td></td>";
               }
            }
         }
      }
      
      foreach($daytemp as $day){
         echo $day;
      }
      echo "</tr>";
   }



   echo "</table>";
   echo "</div>";
   echo "</form>";
   
?>











<?php include_once "footer.php"; ?>
	
<!-- If user drags recipe into another cell where a recipe exists then provide options via jQuery dialog -->
<div id="dialog" title="Planner Change">A recipe already exists at that time slot. What would you like to do ?</div>



</body>