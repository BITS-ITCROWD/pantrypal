<!DOCTYPE html>
   <?php
   
   session_start();

   // if not logged in go back to index page
   if(!isset($_SESSION['login_success'])){
      header("Location: index.php");
   }
   
   // set the user id
   $userID = $_SESSION['login_userid'];
   
   // include the headers, sidebar, and setup for sql
   include("config.php");
   include_once "header.php";

   // create the sql query and retrieve data
   $query =    "SELECT a.entryID, a.userID, a.mealDate, a.mealTime, a.userNote, a.recipeNumber, b.recipeName ";
   $query .=   "FROM meal_planner a, recipe b ";
   $query .=   "WHERE a.userID =".$userID." "; 
   $query .=   "and a.recipeNumber = b.recipeNumber ";
   $query .=   "ORDER BY a.mealDate, a.mealTime;";
   
   // test for a result
   $result = $db->query($query);
   
   // did it work ?
   if ($result === FALSE){
      die(mysql_error());
   }
   //create json
   $q = 0;
   //$row_array = array();
   $jfile = "files/mealplan-".$userID.".json";
   // create an array of the sql result
   while($row = $result->fetchAll()) {
      $q++;
      $jstring = json_encode($row,JSON_PRETTY_PRINT);
   }
   // write it to the json file
   file_put_contents($jfile,$jstring);
   //file_put_contents($jfile,$jstring, FILE_APPEND);
   
   
   // mealtime sql
   $mealQuery = "SELECT * FROM meal_time ORDER by ID";
   // test for a result
   $mealResult = $db->query($mealQuery);
   
   // did it work ?
   if ($mealResult === FALSE){
      die(mysql_error());
   }
   //create json
   $r = 0;
   $jmealFile = "files/mealtime.json";
   // create an array of the sql result
   while($mealRow = $mealResult->fetchAll()) {
      $r++;
      $mealString = json_encode($mealRow,JSON_PRETTY_PRINT);
   }
   // write it to the json file
   file_put_contents($jmealFile,$mealString);
   
   ?>
      
<head>
   <title>Meal Planner</title>

   <script type="text/javascript" src="js/redips-drag-min.js"></script>
   <script type="text/javascript" src="js/meal-plannerREDIPS.js"></script>
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript" src="js/meal-planner.js"></script>
   
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <link rel="stylesheet" href="css/meal-planner.css">
   


</head>

<!-- initiase redips and load the data on page load -->
<body onload="REDIPS.drag.init(),firstPageLoad()">

   <!-- MAIN CONTENT -->
   <?php 
      echo "<div class='container'>";
      include_once "sidebar.php";
      
      echo "<div class='col-sm-9' id='printable'>";
      echo "<h3>Meal Planner</h3>";
      
      echo "<form id='form_planner' method='post' action='mealplan_savetotable.php'>";
      echo "<h4><span id = 'week-start-heading'>for the week starting: </span></h4>";
      echo "<input type='hidden' name='date' id='date' value=''>";
      echo "<input type='hidden' name='user' id='user' value='".$userID."'>";
      echo "<div id='redips-drag'>";
      
      // table with controls
      echo "<table id ='controls'>";
      echo "<tr>";
      echo "<td class='redips-mark'><button type='button' class='nav button' id='back'>
            <span class='glyphicon glyphicon-triangle-left'></span>back</button></td>";
      // display todays date on the first load
      $displayDate = date('d-m-Y',strtotime(Today));   
      echo "<td class='redips-mark'>Select date:<p><input type='text' id='datepicker' value='$displayDate'</p></td>";
      echo "<td class='redips-mark'><button class='button' type='button' id='reset'>reset</button></td>";
      echo "<td class='redips-mark'><button class='button' type='button' id='list' onclick=\"seeMyList('mylist.php')\">view My List</td>";
      echo "<td class='redips-mark'><button class='button' type='button' onclick=\"printThis('printable')\" >print</button></td>";
      echo "<td class='redips-mark'><input type='submit' class='button' value='save' name='save'/></td>";
      echo "<td class='redips-trash'><span class='glyphicon glyphicon-trash'></span></br>trash bin</td>";
      echo "<td class='redips-mark'><button type='button' class='nav button' id='next'>next
            <span class='glyphicon glyphicon-triangle-right'></span></button></td>";
      echo "</tr>";
      echo "</table>";
      
      
      
      // create the current week planner headings
      echo "<table id ='week-day-heading'>";
      echo "<tr>";
      echo "<td class='redips-mark'>MEAL</td>";
      echo "<td class='redips-mark'>Sun</td>";
      echo "<td class='redips-mark'>Mon</td>";
      echo "<td class='redips-mark'>Tue</td>";
      echo "<td class='redips-mark'>Wed</td>";
      echo "<td class='redips-mark'>Thu</td>";
      echo "<td class='redips-mark'>Fri</td>";
      echo "<td class='redips-mark'>Sat</td>";
      echo "</tr>";
      echo "</table>";
   
      // construct the planner detail rows (no data - this is added by ajax script)
      echo "<table id='meal-data'>";   
      echo "<tr>";
      echo "<td class='redips-mark mealLabel'>Breakfast</td>";
      for($col=1; $col<=7; $col++) {
         echo "<td><div></div></td>";
      }
      echo "</tr>";
      echo "<td class='redips-mark mealLabel'>Lunch</td>";
      for($col=1; $col<=7; $col++) {
         echo "<td><div></div></td>";
      }
      echo "</tr>";
      echo "<td class='redips-mark mealLabel'>Dinner</td>";
      for($col=1; $col<=7; $col++) {
         echo "<td><div></div></td>";
      }
      echo "</tr>";
      echo "</table>";
      echo "</div>";  // redips-drag div
      echo "</form>";
      echo "</div>";  // col-sm-9 div
      echo "</div>";  // container div
      
      include_once "footer.php"; 
   ?>


   <!-- Byrons Debug Code -->
   <!--<pre>-->
   <!--  	<?php print_r ($_SESSION); ?>-->
   <!--  	<?php print_r ($_POST); ?>-->
   <!--  	<?php print_r ($_GET); ?>-->
   <!--  	<?php print_r ($_COOKIE); ?>-->
   <!--</pre>-->


</body>