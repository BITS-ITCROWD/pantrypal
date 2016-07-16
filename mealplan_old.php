<!DOCTYPE html>
<?php
   session_start();
   include("config.php");
   //adds the header
   include_once "header.php";
   include_once "sidebar.php";

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
   
   // did it work ?
   if ($result === FALSE){
      die(mysql_error());
   }
   //create json
   $q = 0;
   //$row_array = array();
   $jfile = "mealplan.json";
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
   $jmealFile = "mealtime.json";
   // create an array of the sql result
   while($mealRow = $mealResult->fetchAll()) {
      $r++;
      $mealString = json_encode($mealRow,JSON_PRETTY_PRINT);
   }
   // write it to the json file
   file_put_contents($jmealFile,$mealString);
   
   
   /* OLD - write the array to a SESSION variable
   $_SESSION['MP'] = $row_array;
   var_dump($_SESSION['MP']);
   */
   


//test code only   
$change = array('key1' => hi, 'key2' => there, 'key3' => mum);
json_encode($change);
?>


<head>
   <title>Meal Planner</title>

   <script type="text/javascript" src="js/redips-drag-min.js"></script>
   <script type="text/javascript" src="js/meal-planner.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   
      <script>
   var globalMealTime = [];
   var globalMealDesc = [];
      
     $(document).ready(function(){
         $("#datepicker").change(function(){
            var newDate = this.value;
            console.log(newDate);
            var newMonday = getMondaysDate(newDate);
            loadNewData(newMonday);
            
      });
      

    
      $.ajax({
          async: false,
          url: "mealtime.json",
          success: function() {
             getMealTimes();
          }
      });
      
     });
   </script>
   <script>
      // datepicker script
      $(function() {
         $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
         $( "#dpicker" ).datepicker({dateFormat: 'dd/mm/yy'});
      }); //datepicker function

      // create variables
      //var today = new Date();
      //var Monday = getMondaysDate(today); //get the last monday
      
      //var mealDay = ["Breakfast","Lunch","Dinner"];
      //var mealTime = ["B","L","D"];
   
      
      
      
      // return the date of the most recently current/past monday
      function getMondaysDate(givenDate){
         givenDate = new Date(givenDate);  // make sure its a js date
         var givenIndex = givenDate.getDay();
         var lastMonday = new Date();
         var offset = 0;
         if (givenIndex == 0){ //Sunday
            ffset = 6;
         } else if (givenIndex == 1){ //Monday
            offset = 0;
         } else { // all other days
            offset = givenIndex-1;
         }
         lastMonday.setDate(givenDate.getDate() - offset);
         console.log("getMondaysDate func");
         return lastMonday;
      }  //getMondaysDate function
      

      function json_parse(json){
         $.getJSON('mealplan.json',function(data){
            $.each(data,function(key,val){
               var mealDate = val.mealDate;
               var mealTime = val.mealTime;
               var recipeNumber = val.recipeNumber;
               var userNote = val.userNote;
            }); //.each
         }); //det json
      } // json_parse function
      
      
            //extract the mealtime id and description from json
      function getMealTimes(){
         $.getJSON('mealtime.json',function(data){
            //var mealTime = [];
            //var mealDesc = [];
            var x = 0;
            $.each(data,function(key,val){
               globalMealTime[x] = val.mealTime;
               globalMealDesc[x] = val.mealDescription;
               x++;
            }); //.each
            //return the arrays
           
            //return mealTime;
            console.log("getmealtimes func");
            loadNewData(getMondaysDate("2016-07-07"));
         }); //get json mealtime data

      } //getmealtimes function
      
      // a and b are javascript Date objects (b-a)
      function dateDiff(a, b) {
         var date1 = new Date(a);
         var date2 = new Date(b);
         var utc1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
         var utc2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
         var diffDays = Math.floor((utc2 - utc1) /  (1000 * 3600 * 24))
         return diffDays;
      }
      
      
      
      function loadNewData(newMonday){
         // get the meal time types
         // mealTime[0-2] ...times (B,L,D)
         // mealdesc[0-2] ...desc (Breakfast, Lunch, Dinner)
         //var $mealTime = [];
         //var $mealDesc = [];

         
         // create the row arrays as row0,row1 etc and create description as first item in array
         var row = [];
         console.log("mealtime length : " + globalMealTime.length);
         for (var m = 0; m < globalMealTime.length; m++){
            row[m] = [];
            row[m][0] = globalMealDesc[m];
         } //for
         console.log("row is: " + row);
         // the outer table row tag
         var output = "<tbody><tr>";
         
         // get the mealplan json data
       
         
         $.getJSON('mealplan.json',function(data){
            $.ajax({
            async: true,
            url: "mealplan.json"
            });
            // loop thru it and look for dates within the week in question (ie based on "newMonday")
            $.each(data,function(key,val){
               var mealDate = val.mealDate;
               var mealTime = val.mealTime;
               
               var diff = dateDiff(Date(mealDate),newMonday);
               console.log("the mealdate: " + val.mealDate);
               // if within the current week evaluate further
               if (diff <=7 & diff >=0){
                  console.log("the diff is: " + diff);

                  console.log("mealtime is: " + mealtime);
                  //var recipeNumber = val.recipeNumber;
                  //var userNote = val.userNote; 
                  
                  mealDate = new Date(mealDate);  // make sure its a js date
                  var dayNum = mealDate.getDay();
               
                  for (var y = 0; y < globalMealTime.length; y++){
                     //console.log(globalMealTime[y]);
                     //console.log(mealtime);
                     if(globalMealTime[y] == val.mealtime){
                       //row[y][dayNum] = recipeNumber + " " + userNote;
                        console.log(row);
                     } // if
                  } //for
                  
                          
                     
               } //if
            }); //.each of data
         
         
            /*  
            for (var a in aaa){
               output += "<td> " + value[x] + "</td>";
            }
            output += "<td>This is the first cell</td>";
            output += "<td>This is the second cell</td>";
            output += "<td>This is the third cell</td>";
            output += "</tr><t/body>";
            */
            
         }); //getjson mealplan

         
                     
            
            console.log(output);
            replace(output);
      } //end of loadNewData function
   
   function replace(output) {
   $("#meal-data").replaceWith(output);

      }
   </script>
   
     
 <!--
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
   
   
   
   echo "<table id='meal-data' style='width:70%'>";   
   echo "<tr>";
   echo "<td class='redips-mark'>Breakfast</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   echo "<td class='redips-mark'>Lunch</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   echo "<td class='redips-mark'>Dinner</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   
   // close the table
   echo "</table>";
   -->

   
   


</head>

<body onload="REDIPS.drag.init()">

<!-- NOTE - delete this styling when code completed. Also some styles used in the table elements. -->
<style>
   table, th,td {
      border: 1px solid black;
   }    
   td {
      height:50px;
      width:70px;
   }
</style>  


<!-- MAIN CONTENT -->
<!-- table containing planner controls -->
<?php 
   echo "<h2>Meal Planner</h2>";
   echo "<form id='form_planner' method='post' action=".$_SERVER['PHP_SELF'].">";
   echo "<div id='redips-drag'>";
   echo "<table style='width:70%'>";
   echo "<tr>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='back' name='back'/></td>";
   $displayDate = date('d/m/Y',strtotime(Today));   
   echo "<td class='redips-mark'>Please select new date:<p>Date: <input type='text' id='datepicker' value='$displayDate'</p></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='reset' name='reset'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='copy to another week' name='copy'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='print planner' name='print'/></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='save' name='save'/></td>";
   echo "<td class='redips-trash'>trash bin</td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='next' name='next'/></td>";
   echo "</tr>";
   echo "</table>";
   
   
   // create the current week planner headings
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
   echo "</table>";

   // construct the planner detail rows
   
   /*
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
   }
      */
   echo "<table id='meal-data' style='width:70%'>";   
   echo "<tr>";
   echo "<td class='redips-mark'>Breakfast</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   echo "<td class='redips-mark'>Lunch</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   echo "<td class='redips-mark'>Dinner</td>";
   for($col=1; $col<=7; $col++) {
      echo "<td><div></div></td>";
   }
   echo "</tr>";
   
   // close the table
   echo "</table>";
   echo "</div>";
   echo "</form>";
   
   
   
   
   
   // test stuff only
   echo "<table id ='test_table'>";
   echo "<tr>";
   echo "<td>some details</td>";
   echo "<td><input type='text' id='dpicker' value='09/07/2016'</p></td>";
   echo "</tr>";
   echo "</table>";
   
   
?>






<?php include_once "footer.php"; ?>

<!-- If user drags recipe into another cell where a recipe exists then provide options via jQuery dialog -->
<div id="dialog" title="Planner Change">A recipe already exists at that time slot. What would you like to do ?</div>



</body>