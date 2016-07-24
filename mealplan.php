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


      /*
      $myFile = "mealplan1.json";
      $fh = fopen($myFile, 'w') or die("can't open file");
      $stringData = $_POST["upateJSON"];
      fwrite($fh, $stringData);
      fclose($fh);
      */
   
   
   
   
   // create the sql query and retrieve data
   $query =    "SELECT a.entryID, a.userID, a.mealDate, a.mealTime, a.userNote, a.recipeNumber, b.recipeName ";
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
      
      
      // jquery UI datepicker script
      $(function() {
         $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
      }); //datepicker function
      

      
      $(document).ready(function(){
         
         /* initialise jquery UI tooltip
         $( function() {
            $( document ).tooltip();
         } ); 
         
         // this makes the tooltip "title" content accessible
         $( document ).tooltip( {
         track:    true,
         content:  function() {
         return  $( this ).attr( "title" );
         }
         });
         */
         
         
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
         
         // reset the page (ie reload and any changes to the json are LOST)
         $("#reset").click(function(){
            var msg =   "RESET means that any changes you \n";
            msg +=      "have made without saving will be lost. \n \n";
            msg +=      "Please click OK to reset or Cancel to go back.";
            if (confirm(msg)){
               location.reload(true);
            }
         });
         
         
         // print the planner
         $("#print").click(function(){
            var msg =   "you pressed print. \n";
            msg +=      "(this is not working yet) \n \n";
            msg +=      "Please click OK to print or Cancel to go back.";
            if (confirm(msg)){
               alert("print something");
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
      
      // this func controls the load of the headings, dates, data of the planner. This is called on any date and nav change.
      function loadController(){
               // use ajax to get the meal plan data and only proceed if successful
               console.log("in the load controller");
               $.ajax({
               async: true,
               url: "mealplan.json",
               success: function(data) {
               
               // get the date in the picker and work out the last Sunday (because the planner starts on a Sunday)
               var newDate = $("#datepicker").datepicker('getDate', 'yyyy-mm-dd');
               var newSunDate = getSundaysDate(newDate);
               // get the formated/tagged data for this week
               var newOutput = getNewPlanData(data,newSunDate);
               
               // replace the meal plan data table
               $("#meal-data").replaceWith(newOutput);
               
               // this is a click event on the user's comment. It needs to be placed after the data load to work.
               $('a[href="#userComm"]').click(function(){
                  //var commCurr = $('#' + $(this).attr('aria-describedby')).children().html();
                  var commCurr = $(this).next().html();
                  var commCurr = commCurr.trim();
                  // prompt for comment and provide current comment
                  var comm = prompt("Please enter your comment",commCurr);
                  var comm = comm.trim();
                  // test that is has changed and update html and write it to the JSON
                  if (comm!=commCurr){
                     // get the abbreviated comment
                     var commAbbrev = comm;
                     commAbbrev = getAbbreviated(comm,15);

                     // get the element ID and extract the unique number  
                     var partID = this.id.split("-");
                     var tipID = "tip-" + partID[1];  
                     var tipTextID = "tiptext-" + partID[1];                    
                     document.getElementById(tipID).innerHTML = commAbbrev;
                     document.getElementById(tipTextID).innerHTML = comm;
                     
                     // json update
                     updateMealData(partID[1],comm);
                  }
                  
               
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
      
      // update the JSON file
      function updateMealData(recID,comments){
         // get the current json meal plan data via ajax
         var newJSON = "[\n";
         $.ajax({
            async: true,
            url: "mealplan.json",
            success: function(data) {
               // build a new json
               newJSON = "[\n";
               var update = false;
               // loop thru the json arrays
               $.each(data,function(key,val){
                  // open new array
                  newJSON += "{\n";
                  // loop thru the items
                  $.each(val,function(name,data){
                     // if this is the record to update change the indicator
                     if (name=="entryID" && data ==recID){
                        update = true;
                     }
                     // test if note item to update
                     if (name=="userNote"){
                        if( update == true){
                           newJSON += "'" + name + "' : '" + comments + "'\n";
                           update = false;
                        } else{
                           newJSON += "'" + name + "' : '" + data + "',\n";
                        }
                     // test for the last item - close off array
                     } else if (name=="recipeName") {
                        newJSON += "'" + name + "' : '" + data + "'\n},\n";
                     // every other item
                     } else if (!$.isNumeric(name)){
                        newJSON += "'" + name + "' : '" + data + "',\n";
                     }
                  });
               });
               // remove the comma and add the closing ]
               newJSON = newJSON.substring(0, newJSON.length-2) + "\n]";
               
               // console.log(newJSON);
               console.log("new JSON data created");
               
               // use ajax to update the mealplan.json file
               $.ajax({
               async: false,
               type: 'POST',
               url: "mealplan.json", 
               data: newJSON, 
               dataType: "json", 
               success: console.log("JSON should be updated?")  
               // success: loadController() 
               });



               /* // tried alternative and failed !!!
               var xmlhttp;
               if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
                }
               else
                 {// code for IE6, IE5
                 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                 }
               xmlhttp.onreadystatechange=function()
                 {
                 if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 {
               alert('done');
                }
               }
               
               xmlhttp.open("POST","mealplan.php",true);
               //xmlhttp.open(mpWrite,"mealplan.php",true);
               
               xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
               xmlhttp.send("upateJSON="+newJSON);
               */

















            }
         });
      }
      
      
  
      
      
      // format the week day headings with dates
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
      
       
      // this is called on page load only to get the meal time reference data
      function firstPageLoad(){
            console.log("in replace data func");
            // use ajax to get the meal times
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
                  }); // end of .each loop
                  
                  //load the page data and heading via the controller
                  loadController();
              
               } //end of data func
            }); //end of ajax
      } //end of firstPageLoad func
      
      
      // this func creates formatted planner data for the appropriate week.
      // It is called by the loadController (ie nav and date changes) 
      // note the newSunday argument should be the date of the Sunday at the start of the planner week.
      function getNewPlanData(data,newSunday){
         console.log("get the new plan data func");
         var output ="";
         // create the row arrays as row0, row1 etc for each mealtime and also create description as first item in array
         var row = [];
         // loop thru each mealtime type
         for (var i = 0; i < globalMealTime.length; i++){
            // array is mealtime type + 7 days of the week
            row[i] = new Array(8);
            // mealtime desc in the first place
            row[i][0] = globalMealDesc[i];
            // fill the rest with ""
            for (var j = 1; j <= 7; j++){
               row[i][j] ="";
            } // end of for inner loop
         } // end of for outer loop
         
         //console.log("row is: " + row);
         // open the table
         output += "<table id='meal-data' style='width:70%'>";

         // get the mealplan json data
         var mealDate="";
         var mealTime="";
         var recipeNumber="";
         var userNote ="";
         
         // loop thru the json data
         $.each(data,function(key,val){
            mealDate = val.mealDate;
            mealTime = val.mealTime;
            // get the days difference to work out if the date is relevant (date2 minus date1)
            // send strings only in format 'yyyy-mm-dd'
            var diff = dateDiff(mealDate,newSunday);
            //console.log("date is: " + mealDate + " ID is: " + val.entryID + " diff is: " + diff + " recipe: " + val.recipeNumber);
            // if the item is within the current week evaluate further
            if (diff >-7 && diff <=0){
               // get the day number (Sun=0, Mon=1 etc)
               var dayDate = new Date(mealDate);  
               var dayNum = dayDate.getDay();
               //console.log("date is: " + mealDate + " Day no.is: " + dayNum);
               
               // determine the record's meal time and write details to correct row array
               for (var y = 0; y < row.length; y++){
                  if(globalMealTime[y] == mealTime){
                     //console.log(val.recipeNumber + " " + val.userNote);
                     
                     row[y][dayNum+1] = val.recipeName + "|" + val.userNote + "|" + val.entryID;
                     //console.log("row: " + row);
                  } 
               } //end of for loop
            } // end of if diff...
         
         }); //end of .each of data loop
         
         // create the table tags and row detail output
         for (var a = 0; a < row.length; a++){
            output += "<tr>";
            for (var b = 0; b < row[a].length; b++){
               // no recipes
               if (row[a][b] == ""){
                  output += "<td>"+ row[a][b] + "</td>";
               }
               // the row title (ie breakfast, lunch etc)
               else if (b==0){
                  output += "<td class='redips-mark'>" + row[a][b] + "</td>";
               } 
               // the data itself   
               else{
                  // split the recipe name and comments
                  var recSplit = row[a][b].split("|")
                  // Capitalise the first letter of each word
                  var recLongCap = capitalIdea(recSplit[0]);
                  // replace special chars
                  var recLen = 20;
                  var recShort = getAbbreviated(recLongCap,recLen);
                  
                 
                  // NOTE - vary the length as needed
                  
                  // do the same for user comments
                  var commLen = 15;
                  var recCommLg = recSplit[1];
                  var recCommSh = getAbbreviated(recCommLg,commLen);

                  
                  // create the TD tag with and id of the 'entryID' from 'meal_planner' table. 
                  // Include the recipe name amd user comments within the tag.
                  var recID = recSplit[2];
                  output += "<td><div class='redips-drag'><div class='tip'>" + recShort + "<span class='tiptext'>" + recLongCap + "</span></div>";
                  output += "<div class='tip'><a id='tip-" + recID + "' href='#userComm'>" + recCommSh + "</a>";
                  output += "<span class='tiptext' id ='tiptext-" + recID + "'>" + recCommLg + "</span></div></div></td>";
               }
            }
            // close the row
            output += "</tr>";
         }
         //close the table and return the output
         output += "</table>";
         //console.log("the output is: " + output);
         return output;         
      }
      
      
      
      // examines the deatil and creates a string for the label and another for the tooltip
      function getAbbreviated(detail,detLen){
         var detOut = "";
         if (detail.length > detLen){
            detOut = $.trim(detail).substring(0,detLen).split(" ").slice(0, -1).join(" ") + "...";
         } else if (detail.length == 0) {
            detOut = "add comment...";
         }
         else {
            detOut = detail;
         }
         return detOut;
      }
     
     
      // Capitalise The First Letter Of Each Word      
      function capitalIdea(aString){
      return aString.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
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
   
   .tip {
    position: relative;
    display: inline-block;
   }

   .tip .tiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
   }
   
   
   .tip:hover .tiptext {
    visibility: visible;
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
   echo "<td class='redips-mark'><button type='button' id='print'>print planner</button></td>";
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