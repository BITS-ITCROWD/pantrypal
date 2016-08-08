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
   // get the json file for this user
   $myfile = "files/mealplan-".$userID.".json";

   $jstring = file_get_contents($myfile);
   // decode the json
   $jobj = json_decode($jstring);

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

         $success = false;
         // submit the insert sql query and set the succes variable for later
         if ($db->query($sqlInsStr) === FALSE) {
            die(mysql_error());
         } else{
            $success = true;
         }

      } // end of outer for each in json object
   } // end of if...

?>

<head>
   <!-- seems to require its own style sheet-->
   <link rel="stylesheet" href="css/meal-plan-modal.css">
   
</head>

<body>
   
   
<?php
   // the body of the page is a message to the user stating success or failure
   echo "<div id='success-modal'>";
      echo "<div id='success-box'>";
      if($success == true){
         echo "<p>Your changes have been saved.</p>";
         echo "<p>...returning to you meal planner now...</p>";
      } else{
         echo "<p>Something went wrong. Please try to save again.</p>";
         echo "<p>...returning to you meal planner now...</p>";
      }
      echo "</div>";
   echo "</div>";
   // returns back to the mealplan in a second
   header("refresh:2; url=mealplan.php"); 
   
?>

</body>
