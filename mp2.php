<!DOCTYPE html>
<?php
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
   
   
   /////////////////////////////////////

   // if(isset($_POST['json'])){
      echo "here I am";
      $decoded = base64_decode($_POST['json']);
      $jsonFile = fopen('mp1.json','w+');
      fwrite($jsonFile,$decoded);
      fclose($jsonFile);
   // }
  // else{
      echo "now I am here";
   $query =    "SELECT * FROM paul_test WHERE id = '1' ";
   $result = $db->query($query);
   
   // did it work ?
   if ($result === FALSE){
      die(mysql_error());
   }
  // }
   
   //create json

   $myfile = "mp1.json";
   // create an array of the sql result
   while($row = $result->fetchAll()) {

      $jstring = json_encode($row,JSON_PRETTY_PRINT);
   }
   // write it to the json file
   file_put_contents($myfile,$jstring);
   
   $jstring = file_get_contents($myfile);
   $jobj = json_decode($jstring);
   var_dump($jobj);
   
   
   echo "<div class = 'col-sm-9'>";
   echo "<form id='myForm' method='post' action=".$_SERVER['PHP_SELF'].">";
   foreach ($jobj as $part) {
      foreach ($part as $key=>$value) {
   //echo "{$key} => {$value} ";
      if ($key == "colour"){
         echo "<label for='aaa'>".$key."</label>";
         echo "<input type='text' id='aaa' value='".$value."'>";
         echo "<button type='button' class='update' id='update1'>update json 1</button></br>";  
      }

      if ($key == "thing"){
         echo "<label for='bbb'>".$key."</label>";
         echo "<input type='text' id='bbb' value='".$value."'>";
         echo "<button type='button' class='update' id='update2'>update json 2</button></br>";
      }
   }
   print_r($part);
   }
   
   echo "<input type='submit' value='save to table'>";
   echo "</form>";
   echo "</div>";
   
   ?>
   
   
   
   <pre>
   <?php echo "mp2"; ?>
  	<?php print_r ($_SESSION); ?>
  	<?php print_r ($_POST); ?>
  	<?php print_r ($_GET); ?>
   </pre>
