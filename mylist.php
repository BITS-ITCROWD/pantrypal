<!DOCTYPE html>
<?php session_start(); ?>
	<!-- session_start(); -->

<head>
   <title> Add ingredients </title>
   
   
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   
 <!-- script for date picker -->  
   <script>
      // jquery UI datepicker script
      $(document).ready(function() {
         $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy'}).val('');
      }); 
     
   </script>
   
</head>

<body>

<?php 
   include_once("header.php");
   include_once("sidebar.php");
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

<h3>My List</h3>
<p></p>

<!-- Form for date submission -->
<form action ="mylist.php" method ="post">
<?php
   $displayDate = date('d-m-Y',strtotime(Today));   
   echo "<p>Please select the start of your weeks shopping list: <input type='text' 
            id='datepicker' name='datepicker' value = '$displayDate'></p>";
?>
<input type= 'submit' id = 'datevalue' value ='Submit' name ='date'></input>
</form>
<br />
<form action="IngredList.php" method="post">
<div class='col-sm-8'>


<?php 

// Will - I have added inclusive start and end dates to the sql. 
// The start date is the display date and the end date is 7 days from that date. Paul 28/07/16

// Checking to see if a date has been selected. If it has the following code will be executed
if(isset($_POST['date']) && $_POST['date']!=""){

   
   $displayStart = $_POST['datepicker'];

$dateStart =  date("Y-m-d", strtotime($displayStart));
$dateEnd = date("Y-m-d", strtotime($displayStart.'+7 day'));

echo "<br/><h3><b>Displaying the results for the period:<br/>
                  $dateStart - $dateEnd<br/></b></h3>";


// SQL query returning ingredients for the sleceted date range
foreach ($db->query("SELECT ingredient FROM ingredient WHERE recipeNumber IN 
                   
                   (SELECT recipeNumber FROM meal_planner WHERE mealDate >= '".$dateStart."' and mealDate <= '".$dateEnd."')") as $row)
         {
                           $ingredient = $row ['ingredient'];
                           echo "<label for='list'></label><input type='checkbox' name ='list[]' value = '$ingredient'
                                  checked='checked'></input>";
                           echo "$ingredient <br/>";
         }
         
   echo "<br/><input type = 'submit' name = 'addIngredients' value = 'Save and Email'></input>";
}
?>
</div>
</form>   
</body>

<?php include_once("footer.php"); ?>
   <pre>
     	<?php print_r ($_SESSION); ?>
     	<?php print_r ($_POST); ?>
     	<?php print_r ($_GET); ?>
     	<?php print_r ($_COOKIE); ?>
   </pre>
</html>