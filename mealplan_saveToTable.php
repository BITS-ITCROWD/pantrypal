<!DOCTYPE html>
<?php
   // session stuff
   session_start();
   
   if(!isset($_SESSION['login_userid'])){
      header("Location: index.php");
   }
   else{
      $userID = $_SESSION['login_userid'];
   }
      if(!isset($_SESSION['login_userid'])){
      header("Location: index.php");
   }
   else{
      $userID = $_SESSION['login_userid'];
   }
   include("config.php");

   // start here
   echo "in the table updater";
   
   // get the json file for this user
   $myfile = "mealplan.json";

   $jstring = file_get_contents($myfile);
   // decode the json
   $jobj = json_decode($jstring);
   var_dump($jobj);
   
   // delete all records from the mealplanner table for this user
   $query = "DELETE FROM meal_planner WHERE userID = '" .$userID."'";
   $result = $db->query($query);
   // did it work ?
   if ($result === FALSE){
      die(mysql_error());
   }

   // test for the object before insert
   if (!$jobj ==""){
      // go thru the json object
      foreach ($jobj as $part) {
         foreach ($part as $key=>$value) {
            // get the values to be updated
            switch ($key)
            {
               case "entryID" :
                  $entryID = $value;
                  break;
               case "userID" :
                  $userID = $value;
                  break;
               case "mealDate" :
                  $mealDate = $value;
                  break;
               case "mealTime" :
                  $mealTime = $value;
                  break;
               case "userNote" :
                  $userNote = $value;
                  break;
               case "recipeNumber" :
                  $recipeNumber = $value;
                  break;
            } // end of switch-case
         } // end of inner for each in json object

         // construct the SQL string
         $sqlInsStr = "INSERT INTO meal_planner (entryID, userID, mealDate, mealTime, recipeNumber, userNote) "; 
         $sqlInsStr .= "VALUES (";
         $sqlInsStr .= "'".$entryID."',";
         $sqlInsStr .= "'".$userID."',";
         $sqlInsStr .= "'".$mealDate."',";
         $sqlInsStr .= "'".$mealTime."',";
         $sqlInsStr .= "'".$recipeNumber."',";
         $sqlInsStr .= "'".$userNote."')";
         
         echo $sqlInsStr;
         
         // submit the insert sql query
         if ($db->query($sqlInsStr) === FALSE) {
            echo"FAILED MAN!!!!!!!!!!!!";
            die(mysql_error());
         } else{
            echo"SUCCESS DUDE !!!!!!!!!!!!!";
         }
      } // end of outer for each in json object
   } // end of if...
      
?>