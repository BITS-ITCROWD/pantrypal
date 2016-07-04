<!DOCTYPE html>
<?php
//adds the header
include_once "header.php";
include_once "sidebar.php";
session_start();
if(!isset($_SESSION['login_success'])){ //if login in session is not set
    header("Location: index.php");
}
?>
  
<!--header.php-->
<head>
    
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    
    <!--link to Bootstrap css stylesheets-->
  <link href="css/bootstrap.min.css" rel="stylesheet">; 
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">;
	
	 
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $( "#anim" ).change(function() {
      $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  });
  </script>
  
  <?php
		
		include("config.php");
      
      //adds the iterator to build the ingredient and recipe table
      include_once("recursiveIterator.php");
		
		//declare the recipeID number from the search results
		$rid = $_GET['rid'];
		
	?>
	
</head>


	

<body>
	
		<!-- Header -->
		
		

	<!-- End Header -->
	
	<!-- Side Bar -->
			
   <!-- End Side Bar -->
	
	<!-- SINGLERECIPE GO HERE -------------------------------------------------------------------------------------- -->
	
	   <!-- GET THE INGREDIENTS FOR THE RECIPEID -->
	
	<?php
	
   	echo "Your Recipe ID is: ".$rid.".";
   	
   	echo "<table style='border: solid 1px black;'>";
      echo "<tr><th>ingredientNo</th><th>Ingredient</th><th>mainIngredient</th></tr>";
   
   	$sql = $db->prepare("SELECT ingredientNo, ingredient, mainIngredients FROM ingredient where recipeNumber = :rid");
   	$sql->bindParam(':rid', $rid);
      $sql->execute();
      
      $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
       foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
           echo $v;
         }
         
         echo "</table>";

   ?>
   
      <!-- END INGREDIENTS -->
   
      <!-- GET THE RECIPE FOR THE RECIPEID -->
   
   <?php
   	
   	echo "<table style='border: solid 1px black;'>";
      echo "<tr><th>Step Number</th><th>Step Description</th>/tr>";
   	
   	$sql = $db->prepare("SELECT stepNumber, stepDescription FROM method where recipeNumber = :rid");
   	$sql->bindParam(':rid', $rid);
      $sql->execute();
      
      $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
       foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
           echo $v;
         }
         
         echo "</table>";

   ?>
   
   <?php
   
   echo "<table style='border: solid 1px black;'>";
      echo "<tr><th>Step Number</th>/tr>";
   	
   	//SELECT ingredient from ingredient where recipeNumber IN(select recipeNumber from meal_planner where 1=1 and userID = '' and mealDate between '' and '' order by 1 desc);
   	
   	$sql = $db->prepare("SELECT ingredient from ingredient where recipeNumber IN(select recipeNumber from meal_planner where 1=1 and userID = 2);");
      $sql->execute();
      
      $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
       foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
           echo $v;
         }
         
         echo "</table>";
   
   ?>
   
      <!-- END RECIPE -->
      


<!-- Trigger/Open The Modal -->
<button id="lukemyBtn">Open Modal</button>

<!-- The Modal -->
<div id="lukemyModal" class="lukemodal">

  <!-- Modal content -->
  <div class="lukemodal-content">
    <span class="lukeclose">x</span>
    
 <!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->

<form action="addtomealplan.php" method="post">
		<p>Date: <input type="text" id="datepicker" size="30" name="date"></p>
 
					<p>Meal:<br>
                 <select id="Meal" name="meal">
                   <option value="Breakfast">Breakfast (default)</option>
                   <option value="Lunch">Lunch</option>
                   <option value="Dinner">Dinner</option>
                   <option value="Dessert">Dessert</option>
                   <option value="MorningSnack">Morning Snack</option>
                   <option value="AfternoonSnack">Afternoon Snack</option>
                 </select>
               </p> 
     <input type="submit" value="Submit">          
</form>
    
  </div>

</div>
	 
	 
<script>
// Get the modal
var modal = document.getElementById("lukemyModal");

// Get the button that opens the modal
var btn = document.getElementById("lukemyBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("lukeclose")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>



	  </div>
	
	</div>

	<p>
		<a href="luketemp_testpage.php">Back to Recipe ID selector.php</a>
	</p>
	
	<!-- SINGLERECIPE CONTENTS END HERE -------------------------------------------------------------------------------------- -->
		
			
	<!-- Footer -->
			
		
	<!-- End Footer -->
	
	</body>
	
</html>