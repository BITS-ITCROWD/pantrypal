<!DOCTYPE html>
<?php session_start();

   if(!isset($_SESSION['login_userid'])){
      header("Location: index.php");
   }
   else{
      $userID = $_SESSION['login_userid'];
   }

?>

<head>
   <title> Add ingredients </title>
   
   
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   
 <!-- script for date picker -->  
   <script>
      // jquery UI datepicker script
      $(document).ready(function() {
         $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'});
      }); 
     
   </script>
   
</head>

<body>
<div>
<?php 
   include_once("header.php");
   
   include("config.php"); 
   include("recursiveIterator.php");

// POST for selected ingredients
   if (!isset($_SESSION['requiredIngredients'])){
         $_SESSION['requiredIngredients'] = array();
   }
   
   if (isset($_POST['addIngredients']))
   { 
      $_SESSION['requiredIngredients'] = array(
         $_POST['list']);
         header('will_test2.php');
   }

?>
<div>
   <div class = "container">   <!--Jane adding a container to fix the footer
                                 overlap issue and sidebar alignment-->
      
      <?php include_once("sidebar.php");?> <!--sidebar needs to be within container of main content-->
   
<div class='col-sm-9'> <!--Jane moving this div class to the start of the main content for alignment
                           with sidebar-->

<h3>My List</h3>
<p></p>

<!-- Form for date submission -->
<form action ="mylist.php" method ="post">
<?php
   if (isset($_POST['date'])) {
      if (!$_POST['datepicker']==""){
         $displayDate = date('d-m-Y',strtotime($_POST['datepicker']));  
      }
   } 
    
   echo "<p>Please select the start of your weeks shopping list: <input type='text' 
            id='datepicker' name='datepicker' value = '$displayDate'></p>";
?>
<input type= 'submit' id = 'datevalue' value ='Submit' name ='date'></input>
</form>
<br />

<form action="IngredList.php" method="post">




<?php 

// Will - I have added inclusive start and end dates to the sql. 
// The start date is the display date and the end date is 7 days from that date. Paul 28/07/16

// Checking to see if a date has been selected. If it has the following code will be executed
if(isset($_POST['date']) && $_POST['date']!=""){
   $displayStart = $_POST['datepicker'];
   $dateStartLabel = date("d-m-Y", strtotime($displayStart));
   $dateStart =  date("Y-m-d", strtotime($displayStart));
   $dateEndLabel = date("d-m-Y", strtotime($displayStart.'+7 day'));
   $dateEnd = date("Y-m-d", strtotime($displayStart.'+7 day'));
   
   echo "<br/><h3><b>Displaying the results for the period:<br/>
         $dateStartLabel - $dateEndLabel<br/></b></h3>";
         
   echo "<br/><input type = 'submit' name = 'addIngredients' value = 'Save and Email'>
              </input><br/><br/>";


   // SQL query returning ingredients for the sleceted date range
   foreach ($db->query("SELECT ingredient FROM ingredient WHERE recipeNumber IN 
      (SELECT recipeNumber FROM meal_planner WHERE mealDate >= '".$dateStart."' and mealDate <= '".$dateEnd."' and userID =".$userID.")") as $row)
      {
         $ingredient = $row ['ingredient'];
         echo "<label for='list'></label><input type='checkbox' name ='list[]' value = '$ingredient'
                checked='checked'></input>";
         echo "$ingredient <br/>";
   }
         
}
?>
</div>
</form>   
</div> <!--jane closing container-->
<div>
   <?php include_once("footer.php"); ?>
</div>
</div>
</body>

   <!--<pre>-->
    <?php// print_r ($_SESSION); ?
    <?php// print_r ($_POST); ?>
    <?php// print_r ($_GET); ?>
    <?php// print_r ($_COOKIE); ?>
   <!--</pre>-->
</html>