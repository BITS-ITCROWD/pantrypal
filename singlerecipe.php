<!DOCTYPE html>

<html lang="en">


	<?php
		
		include("config.php");
      //adds the header
      include_once "header.php";
      //adds the iterator to build the ingredient and recipe table
      include_once("recursiveIterator.php");
		
		//declare the recipeID number from the search results
		$rid = $_GET['rid'];
		
		echo '<link href="css/lightbox.css" rel="stylesheet">';
		echo '<link href="css/calendar.css" type="text/css" rel="stylesheet">';
		
	?>

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
      


	<!-- link that opens popup -->

	<!-- Trigger/Open The Modal -->
	<button id="myBtn">Open Modal</button>
	
	<!-- The Modal -->
	<div id="myModal" class="modal">
	
	  <!-- Modal content -->
	  <div class="modal-content">
	    <span class="close">x</span>

<!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $( "#anim" ).change(function() {
      $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  });
  </script>
 
<p>Date: <input type="text" id="datepicker" size="30"></p>
 
<p>Animations:<br>
  <select id="anim">
    <option value="show">Show (default)</option>
    <option value="slideDown">Slide down</option>
    <option value="fadeIn">Fade in</option>
    <option value="blind">Blind (UI Effect)</option>
    <option value="bounce">Bounce (UI Effect)</option>
    <option value="clip">Clip (UI Effect)</option>
    <option value="drop">Drop (UI Effect)</option>
    <option value="fold">Fold (UI Effect)</option>
    <option value="slide">Slide (UI Effect)</option>
    <option value="">None</option>
  </select>
</p>

	  </div>
	
	</div>




	<p>
		<a href="luketemp_testpage.php">Back to Recipe ID selector.php</a>
	</p>
	
	
	
	<!-- SINGLERECIPE CONTENTS END HERE -------------------------------------------------------------------------------------- -->
		
			
	<!-- Footer -->
			
		
	<!-- End Footer -->


	<!-- scripts go here -->
	
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

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
	
	</body>
	
</html>