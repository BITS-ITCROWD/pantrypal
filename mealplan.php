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
   
   // create the sql query and retrieve data
   $query =    "SELECT a.userID, a.mealDate, a.mealTime, a.userNote, a.recipeNumber, b.recipeName ";
   $query .=   "FROM meal_planner a, recipe b ";
   $query .=   "WHERE userID ='2' "; 
   $query .=   "and a.recipeNumber = b.recipeNumber ";
   $query .=   "ORDER BY a.mealDate, a.mealTime;";
   
   //$query = "SELECT * FROM meal_planner WHERE userID ='".$userID."' order by mealDate, mealTime";
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
   
   ?>
   
   
<head>
   <title>Meal Planner</title>

   <script type="text/javascript" src="js/redips-drag-min.js"></script>
   <script type="text/javascript" src="js/meal-planner.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   
   <script>
      // set some variables
      globalMealTime = new Array;
      globalMealDesc = new Array;
      globalChanges = false;
      
      
      // datepicker script
      $(function() {
         $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
      }); //datepicker function
      

      
      $(document).ready(function(){
         

         $( function() {
            $( document ).tooltip();
         } ); 
         
         // change in the date of the datepicker will initiate a change to the meal planner data
         $("#datepicker").change(function(){
            console.log("on change of date replace func");
            loadController();
         });
         
         
         // a click of the back or next buttons will initiate a change to the picker date & load new data
         $(".nav").click(function(){
            // work out if next or back has been clicked
            var val = 0
            if (this.id=="back"){
               val = -7;
            } else if (this.id=="next"){
               val = 7;
            }
            // set the datepicker date and call the controller to load new headings and planner data
            var selectedDate = $("#datepicker").datepicker('getDate', 'yyyy-mm-dd');
            selectedDate.setDate(selectedDate.getDate() + val); 
            $("#datepicker").datepicker('setDate', selectedDate);
            loadController();
         });
         
         
         $("#reset").click(function(){
            var msg =   "RESET means that any changes you \n";
            msg +=      "have made without saving will be lost. \n \n";
            msg +=      "Please click OK to reset or Cancel to go back.";
            if (confirm(msg)){
               location.reload(true);
            }
            
         });
         

         
      // set change indicator if any made to the meal planner
      var rd = REDIPS.drag;
      rd.event.changed = function () {
         globalChanges = true;
         console.log("CH-CH-CHANGES are " + globalChanges);
         
      // get current position (method returns positions as array)
      //var pos = rd.getPosition();
      // display current row and current cell
      //alert('Changed: ' + pos[1] + ' ' + pos[2]);
      }; 
         
         
         
      });
      
   </script>

   <script>
      // JS FUNCTIONS
      
      function loadController(){
               $.ajax({
               async: true,
               url: "mealplan.json",
               success: function(data) {
               
               //var newDate = document.getElementById('datepicker').value;
               var newDate = $("#datepicker").datepicker('getDate', 'yyyy-mm-dd');
               //alert("NEW date is: " + newDate);
               var newSunDate = getSundaysDate(newDate);
               console.log("#### the new Sun Date is: " + newSunDate);
               var newOutput = getNewPlanData(data,newSunDate);
               //console.log("new returned output: " + newOutput);
               
               // replace the meal plan data table
               $("#meal-data").replaceWith(newOutput);
               
               
               $('a[href="#userComm"]').click(function(){
                  //function myFunction(){
                  
                  var comm = prompt("Please enter your comment","");
                  if (comm!=null){
                     var xxx = "<a href='#userComm' title='" + comm + "'>love that...</a>";
                  }
                  
                  // ########  need to update the json ##########
                  //alert(xxx);
               });

               
               /*
               $("#meal-data").after(newOutput).remove();
                  $('.recName').hover(function(){
                  $(this).text("hi mum");
                  }, function(){
                  $(this).text();
                  });
               
               */
               
               // replace the "week starting..." subheading
               //alert("NEW sunday is: " + newSunDate);
               var weekStart = (newSunDate.getDate() + '-' + (newSunDate.getMonth()+1) + '-' +  newSunDate.getFullYear());
               var weekOutput = "<span id = 'week-start-heading'>for the week starting: " + weekStart + "</span>";
               $("#week-start-heading").replaceWith(weekOutput);
               
               // replace the week day sub heads
               weekDayOutput = getWeekDayHead(newSunDate);
               $("#week-day-heading").replaceWith(weekDayOutput);
               
               // re-initiate REPIPS
               REDIPS.drag.init();
               }
            });
            
      }
      
      
      function getWeekDayHead(sunday){
         var wdOutput ="";
         wdOutput += "<table id = 'week-day-heading' style='width:70%'>";
         wdOutput += "<tr>";
         wdOutput += "<td class='redips-mark'>MEAL</td>";
         wdOutput += "<td class='redips-mark'>Sun " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Mon " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Tue " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Wed " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Thu " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Fri " + sunday.getDate() + "</td>";
         sunday.setDate(sunday.getDate() + 1); 
         wdOutput += "<td class='redips-mark'>Sat " + sunday.getDate() + "</td>";
         wdOutput += "</tr>";
         wdOutput += "</table>";
    
         return wdOutput;
      }
      
       
      // this is called on page load and loads the planner data based on current date 
      function firstPageLoad(){
            console.log("in replace data func");
            
            $.ajax({
               async: false,
               url: "mealtime.json",
               success: function(data) {
               //extract the mealtime id and description from json
                  var x = 0;
                  $.each(data,function(key,val){
                     globalMealTime[x] = val.mealTime;
                     globalMealDesc[x] = val.mealDescription;
                     x++;
                  }); //.each
                  
                  //load the page data and heading via the controller
                  loadController();
                  console.log("getmealtimes func done!");
              
               } //end of data func
            }); //end of ajax
      } //end of firstPageLoad func
      
      
      // this func loads planner data based on a change in the date picker chosen by the user.
      // note the newSunday argument should be the date of the Sunday at the start of the planner week.
      function getNewPlanData(data,newSunday){
         console.log("get the new plan data func");
         var output ="";

                  
         // create the row arrays as row0,row1 etc and create description as first item in array
         var row = [];
         console.log("mealtime length : " + globalMealTime.length);
         for (var i = 0; i < globalMealTime.length; i++){
            row[i] = new Array(8);
            row[i][0] = globalMealDesc[i];
            for (var j = 1; j <= 7; j++){
               row[i][j] ="";
            }
         } //for
         
         console.log("row is: " + row);
         // the table tag
         output += "<table id='meal-data' style='width:70%'>";

         // get the mealplan json data
         var mealDate="";
         var mealTime="";
         var recipeNumber="";
         var userNote ="";
         
         $.each(data,function(key,val){
            mealDate = val.mealDate;
            mealTime = val.mealTime;
            
            // get the days difference to work out if the date is relevant (date2 minus date1)
            // send strings only in format 'yyyy-mm-dd'
            var diff = dateDiff(mealDate,newSunday);
            console.log("date is: " + mealDate + " Day no.is: " + dayNum + " diff is: " + diff + " recipe: " + val.recipeNumber);
            // if within the current week evaluate further
            if (diff >-7 && diff <=0){
               // get the day number (Sun=0, Mon=1 etc)
               var dayDate = new Date(mealDate);  
               var dayNum = dayDate.getDay();
               console.log("date is: " + mealDate + " Day no.is: " + dayNum);
               
               // determine the record's meal time and write details to correct row array
               for (var y = 0; y < row.length; y++){
                  if(globalMealTime[y] == mealTime){
                     console.log(val.recipeNumber + " " + val.userNote);
                     
                     row[y][dayNum+1] = val.recipeName + "|" + val.userNote;
                     //console.log("row: " + row);
                  } 
               } //for loop
            } // if diff...
         
         }); //.each of data
         
         // create the table tags and row detail output
         for (var a = 0; a < row.length; a++){
            output += "<tr>";
            for (var b = 0; b < row[a].length; b++){
               // no recipes
               if (row[a][b] == ""){
                  output += "<td>"+ row[a][b] + "</td>";
               // the row title
               }
               else if (b==0){
                  output += "<td class='redips-mark'>" + row[a][b] + "</td>";
               // the data itself   
               } 
               else{
                  var recSplit = row[a][b].split("|")
                  var recLong = clean(recSplit[0]);
                  var recShort ="";
                  // create the tooltip with jquery. 
                  // NOTE - vary the length as needed
                  var recLen = 20;
                  if (recSplit[0].length > recLen){
                     recShort = $.trim(recSplit[0]).substring(0,recLen).split(" ").slice(0, -1).join(" ") + "...";
                  } else {
                     recShort = recSplit[0];
                  }
                  
                  // do the same for comments
                  var recCommLg = recSplit[1];
                  var recCommSh ="";
                  var commLen = 15;
                  if (recSplit[1].length > commLen){
                     recCommSh = $.trim(recSplit[1]).substring(0,commLen).split(" ").slice(0, -1).join(" ") + "...";
                  } else if (recSplit[1].length == 0) {
                     recCommSh = "add comment...";
                  }
                  else {
                     recCommSh = recSplit[1];
                  }
                  output += "<td><div class='redips-drag'><p title='" + recLong + "'>" + recShort + "</p>";
                  output += "<p><a href='#userComm' title='" + recCommLg + "'>" + recCommSh + "</a></p></div></td>";
               }
            }
            output += "</tr>";
         }
         //close the table
         output += "</table>";
         console.log("the output is: " + output);
         return output;         
      }
      


      
      function clean(string) {
         var entityMap = {
         "&": "&amp;",
         "<": "&lt;",
         ">": "&gt;",
         '"': '&quot;',
         "'": '&#39;',
         "/": '&#x2F;'
         };
         
         return String(string).replace(/[&<>"'\/]/g, function (s) {
         return entityMap[s];
         });
      }
      
       
      
      // return the date of the most recently current/past Sunday
      function getSundaysDate(givenDate){
         givenDate = new Date(givenDate);  // make sure its a js date
         var givenIndex = givenDate.getDay();
         givenDate.setDate(givenDate.getDate() - givenIndex);
         return givenDate;
      }  //end of getSundaysDate function 


      // calc the diff between 2 dates (ie argument "b" minus argument "a")
      function dateDiff(a, b) {
         var date1 = new Date(a);
         var date2 = new Date(b);
         var utc1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
         var utc2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
         var diff = Math.floor((utc2 - utc1) /  (1000 * 3600 * 24))
         //console.log("in the diffdate func - date: " + date2 + " MINUS " + date1 + " EQUALS: " + diff);
         return diff;
      } 
      

      


   </script>


</head>

<body onload="REDIPS.drag.init(),firstPageLoad()">

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
   echo "<span id = 'week-start-heading'>for the week starting: </span>";
   echo "<form id='form_planner' method='post' action=".$_SERVER['PHP_SELF'].">";
   echo "<div id='redips-drag'>";
   echo "<table style='width:70%'>";
   echo "<tr>";
   echo "<td class='redips-mark'><button type='button' class='nav' id='back'>back</button></td>";
   //echo "<td class='redips-mark'><input type='submit' class='button' value='back' name='back'/></td>";
   $displayDate = date('d-m-Y',strtotime(Today));   
   echo "<td class='redips-mark'>Please select new date:<p>Date: <input type='text' id='datepicker' value='$displayDate'</p></td>";
   echo "<td class='redips-mark'><button type='button' id='reset'>reset</button></td>";
   echo "<td class='redips-mark'><button type='button'>copy to another week</button></td>";
   echo "<td class='redips-mark'><button type='button'>print planner</button></td>";
   echo "<td class='redips-mark'><input type='submit' class='button' value='save' name='save'/></td>";
   echo "<td class='redips-trash'>trash bin</td>";
   echo "<td class='redips-mark'><button type='button' class='nav' id='next'>next</button></td>";
   echo "</tr>";
   echo "</table>";
   
   
   // create the current week planner headings
   echo "<table id = 'week-day-heading' style='width:70%'>";
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

   // construct the planner detail rows (no data)
 
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
   echo "</table>";
   echo "</div>";
   echo "</form>";
   

?>


<?php include_once "footer.php"; ?>




<!-- If user drags recipe into another cell where a recipe exists then provide options via jQuery dialog -->
<div id="dialog" title="Planner Change">A recipe already exists at that time slot. What would you like to do ?</div>



</body>