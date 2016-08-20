// JS written for the mealplan page - Paul Gauci 2016

// set some variables
globalMealTime = new Array;
globalMealDesc = new Array;


// jquery UI datepicker script
$(function() {
   $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
}); //datepicker function


$(document).ready(function(){

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
      var msg =   "Any changes you have made \n";
      msg +=      "without saving will be lost. \n \n";
      msg +=      "Click OK to reset or Cancel to go back.";
      if (confirm(msg)){
         location.reload(true);
      }
   });
   
   // All the REDIPS events
   var rd = REDIPS.drag;
   
   // returns the manipulated REDIPS div id
   function getRDid(){
      var rdID = rd.obj.children[0].id;
      rdID = rdID.split("-");
      var theID = rdID[1];  
      return theID;
   };
   
   // redips trash - only initiated when the user confirms deletion
   rd.event.deleted = function(){
      // get the id of the item being deleted
      var theID = getRDid();
      // call the func to save to new json
      updateMealData(theID,3,"",0);
      var xxx = "gone !";
      console.log(theID + " was deleted and is now ... " + xxx);
   };
   
   // resips - item dragged and dropped
   rd.event.dropped = function () {
      // get the id of the item being moved           
      var theID = getRDid();
      // get the resulting co-ordinates 
         // get target and source position (method returns positions as array)
         // pos[0] - target table index
         // pos[1] - target row index
         // pos[2] - target cell (column) index
         // pos[3] - source table index
         // pos[4] - source row index
         // pos[5] - source cell (column) index
      var pos = rd.getPosition();
      //console.log('Changed to: ' + pos[1] + ' ' + pos[2]);
      // call the func to save to new json
      updateMealData(theID,2,"",pos);
   };
   

});

// JS FUNCTIONS

// this func controls the load of the headings, dates, data of the planner. This is called on any date and nav change.
function loadController(){
      // use ajax to get the meal plan data and only proceed if successful
      console.log("in the load controller");
      var userID = document.getElementById("user").value;
      $.ajax({
      async: true,
      url: "files/mealplan-" + userID + ".json",
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
            updateMealData(partID[1],1,comm,0);
         }
      });

      // replace the "week starting..." subheading
      //alert("NEW sunday is: " + newSunDate);
      var weekStart = (newSunDate.getDate() + '-' + (newSunDate.getMonth()+1) + '-' +  newSunDate.getFullYear());
      var weekOutput = "<span id = 'week-start-heading'>for the week starting: " + weekStart + "</span>";
      $("#week-start-heading").replaceWith(weekOutput);
      // replace the hidden date field
      var weekDateReformed = (newSunDate.getFullYear() + '-' + (newSunDate.getMonth()+1) + '-' + newSunDate.getDate());
      // var weekDate = "<input type='hidden' name='date' id='date' value='" + weekDateReformed + "'>"; 
      var weekDate = "<input type='hidden' name='datepicker' id='date' value='" + weekDateReformed + "'>"; 
      weekDate = weekDate + "<input type='hidden' name='date' id='date' value='" + weekDateReformed + "'>"; 
      console.log(weekDate);
      $("#date").replaceWith(weekDate);
      
      // replace the week day sub heads
      weekDayOutput = getWeekDayHead(newSunDate);
      $("#week-day-heading").replaceWith(weekDayOutput);
      
      // re-initiate REPIPS
      REDIPS.drag.init();
      
      }
   });
}

// update the JSON file
// note - 'mode' is: 1 - update a comment; 2 - change the details of a moved recipe; 3 - remove/trash a recipe
// note - 'coords' is the resulting co-ordinates (an array where pos 1=dest'n row and 2= dest'n col. 4 & 5 = source etc)
function updateMealData(ID,mode,comments,coords){
   // get the current json meal plan data via ajax
   var newJSON = "[\n";
   var userID = document.getElementById("user").value;
   $.ajax({
      async: true,
      url: "files/mealplan-" + userID + ".json",
      success: function(data) {
   
         var currJSONStr = JSON.stringify(data);
         var currJSONObj = JSON.parse(currJSONStr);
         console.log("got the current json");
         console.log(currJSONObj);               
         
         switch (mode){
            // update comments
            case 1:
               for (var i=0; i<currJSONObj.length; i++) {
                  if (currJSONObj[i].entryID == ID) {
                     currJSONObj[i].userNote = comments;
                     //console.log(currJSONObj);
                     break;
                  }
               }
               break;
            
            // move a recipe
            case 2:
               // assign new mealtime from coords (pos 1=row)
               var newMealTime = globalMealTime[coords[1]];

               for (var i=0; i<currJSONObj.length; i++) {
                  if (currJSONObj[i].entryID == ID) {
                     // work out meal date from coords
                     var offSet = coords[2] - coords[5];
                     console.log(offSet);
                     newMealDate = new Date(currJSONObj[i].mealDate);
                     newMealDate.setDate(newMealDate.getDate() + offSet);
                     // change to new meal date
                     currJSONObj[i].mealDate = newMealDate;
                     // change to new mealtime
                     currJSONObj[i].mealTime = newMealTime;
                     break;
                  }
               }
               break;
            
            // remove/trash a recipe
            case 3:
               for (var i=0; i<currJSONObj.length; i++) {
                  if (currJSONObj[i].entryID == ID) {
                     currJSONObj.splice(i, 1);
                     break;
                  }
               }
               break;
         } // end of switch-case
         
         // stringify and encode
         var newJSONstring = JSON.stringify(currJSONObj);
         var encoded = btoa(newJSONstring);
         
         // AJAX does NOT work - using xml request instead to post the newJSON php
         var xhr = new XMLHttpRequest();
         xhr.open('POST','mealplan_newjson.php',true);
         xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
         xhr.send('json=' + encoded);
         
         //console.log("new JSON data created");
      }
   });
}


// format the week day headings with dates
function getWeekDayHead(sunday){
   var wdOutput ="";
   wdOutput += "<table id = 'week-day-heading'>";
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
      url: "files/mealtime.json",
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
   output += "<table id='meal-data'>";

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
               var userNoteEval="";
               //test for the value of "null"
               if(val.userNote=="NULL"){
                  userNoteEval="";
               } else{
                  userNoteEval=val.userNote;
               }
               row[y][dayNum+1] = val.recipeName + "|" + userNoteEval + "|" + val.entryID;
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
            output += "<td class='redips-mark mealLabel'>" + row[a][b] + "</td>";
         } 
         // the data itself   
         else{
            // split the recipe name and comments
            var recSplit = row[a][b].split("|")
            // Capitalise the first letter of each word
            var recLongCap = capitalIdea(recSplit[0]);
            // replace special chars
            var recLen = 25;
            var recShort = getAbbreviated(recLongCap,recLen);
            
           
            // NOTE - vary the length as needed
            
            // do the same for user comments
            var commLen = 20;
            var recCommLg = recSplit[1];
            var recCommSh = getAbbreviated(recCommLg,commLen);

            
            // create the TD tag with and id of the 'entryID' from 'meal_planner' table. 
            // Include the recipe name amd user comments within the tag.
            var recID = recSplit[2];
            output += "<td><div class='redips-drag'><div class='tip' id='rec-" + recID + "'>" + recShort + "<span class='tiptext'>" + recLongCap + "</span></div>";
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

// print the planner
function printThis() {
   window.print();
}

// submit to the mylist page with dates
function seeMyList(page){
   document.getElementById('form_planner').action = page;
   document.getElementById('form_planner').submit();
}