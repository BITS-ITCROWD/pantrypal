<!DOCTYPE html>
<?php
   // written by Paul Gauci s3529106 2016.
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
   
   // decode the new json data in the POST and write it to the json file
   $decoded = base64_decode($_POST['json']);
   $jsonFile = fopen('files/mealplan-'.$userID.'.json','w+');
   fwrite($jsonFile,$decoded);
   fclose($jsonFile);
      
?>