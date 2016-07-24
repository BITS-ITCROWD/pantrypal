<!DOCTYPE html>
<?php
//adds the header
include_once "header.php";

session_start();
if(!isset($_SESSION['login_success'])){ //if login in session is not set
    header("Location: index.php");
}
?>
  
<!--header.php-->
<head>
    
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    
    <!--link to Bootstrap css stylesheets-->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
	 
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
	
	<!-- LEFT NAV COLUMN -->
	
	<div style = "height:100vh;" class = "pull-left">
	<?php
	
	include_once "sidebar.php";
	
	?>
	</div>
	
	<!-- MIDDLE COLUMN -->
	
	<div class = "pull-left">
	   
	   
	   <!-- GET THE IMAGE WITH THE RECIPEID -->
	   
      	<div class = "pull-left">
      	
            	<?php
            	
            	$sql = $db->prepare("SELECT imageName from recipe where recipeNumber = :rid");
               	$sql->bindParam(':rid', $rid);
                  $sql->execute();
            	
            	$result = $sql->fetchColumn();
            	$dir = "images/recipe_images";
            
               echo "<div class = 'img-thumbnail'><img src='".$dir."/". $result ."' alt='".$result."' style='width:250px;height:200px;'></div>";
               
               ?>
               
               <!-- END IMAGE -->
               
         </div>
         
         <div class = "pull-left">
            
               <!-- GET THE RECIPE NAME WITH THE RECIPEID -->
               
               <?php
         	
         	   $sql = $db->prepare("SELECT recipeName from recipe where recipeNumber = :rid");
            	$sql->bindParam(':rid', $rid);
               $sql->execute();
         	
         	   $name = $sql->fetchColumn();
            	
         
               echo "<h1> $name <h1>";
         
               ?>
            
         </div>
         
         <div style = "clear:both"></div>
         
      	
      	
      	<div>
      	   
      	   <!-- GET THE INGREDIENTS FOR THE RECIPEID -->
      	   
      	   <h2>Ingredients</h2>
      	   
      	<?php
         	
         	echo "<table style='border: solid 1px black;'>";
            echo "<tr><th>Ingredient</th><th>Main Ingredient</th></tr>";
         
         	$sql = $db->prepare("SELECT ingredient, mainIngredients FROM ingredient where recipeNumber = :rid");
         	$sql->bindParam(':rid', $rid);
            $sql->execute();
            
            $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
             foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
                 echo $v;
               }
               
               echo "</table>";
      
         ?>
         
         </div>
         
            <!-- END INGREDIENTS -->
            
         
            <!-- GET THE RECIPE FOR THE RECIPEID -->
            
         <div>
            
            <h2>How to cook</h2>
         
         <?php
         	
         	echo "<table style='border: solid 1px black;'>";
            echo "<tr><th>#</th><th>Description</th></tr>";
         	
         	$sql = $db->prepare("SELECT stepNumber, stepDescription FROM method where recipeNumber = :rid");
         	$sql->bindParam(':rid', $rid);
            $sql->execute();
            
            $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
             foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
                 echo $v;
               }
               
               echo "</table>";
      
         ?>
         
         </div>
         
         
            <!-- END RECIPE -->
            
            
    </div>

      
      	<!-- RIGHT COLUMN -->
      	
   <div class = "pull-left">   
      	
         	<div style = "height:200px"></div>
            
                           <!-- Trigger/Open The Modal -->
               <button id="lukemyBtn" class = "badge">Add to Meal Planner</button>
               
               <!-- The Modal -->
               <div id="lukemyModal" class="lukemodal">
               
                 <!-- Modal content -->
                 <div class="lukemodal-content">
                   <span class="lukeclose">x</span>
                   
                <!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->
               
               <form action="addtomealplan.php" method="post">
               		<p>Date: <input type="text" id="datepicker" size="30" name="date"></p>
                
               					<p>Meal:<br>
                                <input type="radio" id="Meal" name="meal" value="breakfast" checked> Breakfast<br>
                                  <input type="radio" id="Meal" name="meal" value="lunch"> Lunch<br>
                                 <input type="radio" id="Meal" name="meal" value="dinner"> Dinner
                 
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
      	
      	<!-- SINGLERECIPE CONTENTS END HERE -------------------------------------------------------------------------------------- -->
      		
      			
      	<!-- Footer -->
      			
      		
      	<!-- End Footer -->
	</body>
	
</html>