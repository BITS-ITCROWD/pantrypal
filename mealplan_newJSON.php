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
   
   // decode the new json in the POST and write it to the json file
   $decoded = base64_decode($_POST['json']);
   $jsonFile = fopen('mealplan.json','w+');
   fwrite($jsonFile,$decoded);
   fclose($jsonFile);
      
?>