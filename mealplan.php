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

?>

<head>
   <title>Meal Planner</title>

   <script type="text/javascript" src="js/redips-drag-min.js"></script>
   <script type="text/javascript" src="js/meal-planner.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

   <script>
     $(function() {
       $( "#datepicker" ).datepicker();
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

// function will create and return the detail of the row from the sql result. $daytemp is indexed from 1 to 7 for each weekday (Monday=1 etc)
function getMealRow($result){
   $daytemp ="";
   foreach ($result as $res) {
      //var_dump($res);
      $dIndex = date('N',strtotime($res["mealDate"]));
      
      for($col=1; $col<=7; $col++) {
         if($col == $dIndex) {
            //echo "if".$col.", ";
            $daytemp[$col] = "<td><div class='redips-drag'> Recipe No: ".$res["recipeNumber"]." ".$res["userNote"]."</div></td>";
         }
         elseif (strlen($daytemp[$col]) <= 9) {
            //var_dump($daytemp[$col]);
            //echo "else" .$col.", ";
            $daytemp[$col] = "<td></td>";
         }
      }
   }
   return $daytemp; 
}

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


?>



   <!--  determine if first time to page -->

 

   <!--  draw table containing controls -->
   <h2>Meal Planner</h2>
   <div id='redips-drag'>
   <table style='width:70%'>
      <tr>
         <td class='redips-mark'>back</td>
         <td class='redips-mark'>Please select new date:<p>Date: <input type='text' id='datepicker' value='2016-07-04'></p></td>
         <td class='redips-mark'>reset this week</td>
         <td class='redips-mark'>copy this weeks to another week</td>
         <td class='redips-mark'>print out for my fridge</td>
         <td class='redips-trash'>trash bin</td>
         <td class='redips-mark'>next</td>
      </tr>
   </table>
   
   
   <!--  draw the current week planner details -->
   <!--  table Day Headings -->
   <table style='width:70%'>
      <tr>
         <td class='redips-mark'>MEAL</td>
         <td class='redips-mark'>Mon</td>
         <td class='redips-mark'>Tue</td>
         <td class='redips-mark'>Wed</td>
         <td class='redips-mark'>Thu</td>
         <td class='redips-mark'>Fri</td>
         <td class='redips-mark'>Sat</td>
         <td class='redips-mark'>Sun</td>
      </tr>
   

<?php   
   // construct the sql
   $mealDay = [Breakfast,Lunch,Dinner];
   $mealTime = [B,L,D];
   // set the from & to dates for the sql - the previous monday to sunday
   $dFrom = getMondaysDate(date('Y-m-d'));
   $dTo = strtotime('+6 day',strtotime($dFrom));
   $dTo = date('Y-m-d',$dTo);
   
   echo "from: ".$dFrom." to: ".$dTo;
   
   for ($x=0; $x< sizeof($mealDay); $x++){
      $result = $db->query("SELECT mealDate,recipeNumber,userNote FROM meal_planner WHERE userID ='".$userID."' 
      and mealTime ='".$mealTime[$x]."' and mealDate >= '".$dFrom."' and mealDate <= '".$dTo."' order by mealDate");
      //var_dump($result);
      echo "<tr>";
      echo "<td class='redips-mark'>".$mealDay[$x]."</td>";
      
      // construct the details of the row
      $daytemp = getMealRow($result);
      //var_dump($daytemp);
      // echo the row data
      foreach($daytemp as $day){
         echo $day;
      }
      
      echo "</tr>";
   }
   echo "</table>";
   echo "</div>";
   

   
   
   include_once "footer.php";
   
?>

	<!-- If user drags recipe into another cell where a recipe exists then provide options via jQuery dialog -->
	<div id="dialog" title="Planner Change">A recipe already exists at that time slot. What would you like to do ?</div>



</body>