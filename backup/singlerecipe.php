<!DOCTYPE html>
<?php
//adds the header
include_once "header.php";

session_start();
if(!isset($_SESSION['login_success'])){ //if login in session is not set
    header("Location: index.php");
    
    $userID = $_SESSION['login_userid'];
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
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
    $( "#format" ).on( "change", function() {
      $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
    });
  } );
  </script>
  
                 <script type='text/javascript'>
                   /* attach a submit handler to the form */
                   $("#formoid").submit(function(event) {
               
                     /* stop form from submitting normally */
                     event.preventDefault();
               
                     /* get the action attribute from the <form action=""> element */
                     var $form = $( this ),
                         url = $form.attr( 'action' );
               
                     /* Send the data using post with element id meal and date and rid*/
                     var posting = $.post( url, { meal: $('#meal').val(), date: $('#datepicker').val(), rid: $('#rid').val() } );
               
                     /* Alerts the results */
                     posting.done(function( data ) {
                       alert('success');
                     });
                   });
               </script>
  
  <?php
		
		include("config.php");
      
      //adds the iterator to build the ingredient and recipe table
      include_once("recursiveIterator.php");
		
		//declare the recipeID number from the search results
		$rid = $_GET['rid'];
		$_SESSION['rid'] = $rid;

      // added by Jane: determine if recipe is a favourite		
		$fav_btn_name = "test";
               
            $records = $db->prepare('SELECT * FROM favourites WHERE recipeNumber = :rid');
      		$records->bindParam(':rid', $rid);
      		$records->execute();
      		$results = $records->fetch(PDO::FETCH_ASSOC);
         			
      			if($results > 0){
         				$fav_btn_name = "Remove Favourite";
         			}
         			else {
         			   $fav_btn_name = "Add Favourite";
               			}
	?>
	
</head>

<body>
   
   <div class = "container-fluid">
	
	   <!-- LEFT NAV -->
	
   	<div class="col-md-2">
      	<?php
      	
      	include_once "sidebar.php";
      	
      	?>
   	</div>
	
   	<!-- MIDDLE SECTION -->
   	
   	<div class="col-md-10">
   	   
   	   
   	   <div class = "row">
   	   
   	   
   	      <!-- GET THE IMAGE WITH THE RECIPEID -->
   	   
         	<div class = "col-md-4">
         	
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
            
            <div class = "col-md-4">
               
                  <!-- GET THE RECIPE NAME WITH THE RECIPEID -->
                  
                  <?php
            	
            	   $sql = $db->prepare("SELECT recipeName from recipe where recipeNumber = :rid");
               	$sql->bindParam(':rid', $rid);
                  $sql->execute();
            	
            	   $name = $sql->fetchColumn();
               	
            
                  echo "<h1> $name <h1>";
            
                  ?>
               
            </div>
            
            <div class = "col-md-4">
               
            </div>
            
         </div> <!-- end <div class = "row"> -->	
         
         <div class = "row">
            	
            <div class = "col-md-8">
         	   
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
            
            <div class = "col-md-4">
               
               
               
               <!-- RIGHT COLUMN -->
         	
               <!--Jane including add to favourites and remove favourite
                  button name confirms success-->

               <?php
               
               $userID = $_SESSION['login_userid'];
               
               
               if(isset($_POST['submit']))
               {
                  //check status of recipe
                        
                  	if($fav_btn_name == "Add Favourite"){

                        $sql_fav = $db->prepare('INSERT INTO favourites (recipeNumber, userID) VALUES(:rid, :userid)');
                        $sql_fav->bindParam(':rid', $rid);
                        $sql_fav->bindParam(':userid', $userID);
                              
                       // check that the recipe was added successfully 
                       // and update button name
                              
                           if($sql_fav->execute()) {
                           
                              $fav_btn_name = "Remove Favourite";
                           
                              }
                           
                     }
                        else {
                              
                              //remove favourite
                              
                              if($fav_btn_name == 'Remove Favourite'){
                     
                                 $sql_fav = $db->prepare('DELETE FROM favourites WHERE (recipeNumber = :rid AND userID= :userid)');
                                 $sql_fav->bindParam(':rid', $rid);
                                 $sql_fav->bindParam(':userid', $userID);
                                 
                                // check that the recipe was removed successfully 
                                // and update button name
                              
                                 if($sql_fav->execute()) {
                           
                                    $fav_btn_name = "Add Favourite";
                                 }
                                
                              }
                           }
                           
               }         
               ?>   	
         	
            	
               	<div>
                  
                                 <!-- Trigger/Open The Modal -->
                     <button id="lukemyBtn" class = "badge">Add to Meal Planner</button></br></br>
                     
                     
                                 <!--Added by Jane: Add to favourites button-->
                     
                     <form action = "" method="post">
                     <button type="submit" button id="Add_Favourites" class = "badge" 
                     name="submit"><?php echo $fav_btn_name?></button>
                     </form>
                     
                                    <!-- The Modal -->
                     <div id="lukemyModal" class="lukemodal">
                     
                       <!-- Modal content -->
                       <div class="lukemodal-content">
                         <span class="lukeclose">x</span>
                         
                      <!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->
                     
                        <form id="formoid" action="addtomealplan.php" title="" method="post">
                           
                           <input id="format" type="hidden" value="yy-mm-dd"></select>
                           
                        		<p>Date: <input type="text" id="datepicker" size="30" name="datepicker"></p>
                         
               					<p>Meal:<br>
               					
                                <input type="radio" id="meal" name="meal" value="B" checked> Breakfast<br>
                                  <input type="radio" id="meal" name="meal" value="L"> Lunch<br>
                                 <input type="radio" id="meal" name="meal" value="D"> Dinner
                 
                              </p> 
            
                             <div>
                                 <input type="submit" id="submitButton"  name="submitButton" value="Submit">
                             </div> 
                             
                        </form>
                        <div id="successMessage" style="display: none;">You've successfully added it in there!</div>
                         
                     </div>
                     
                  </div>
                     	 
                     <!-- submit script -->
      
                     <script type='text/javascript'>
                         /* attach a submit handler to the form */
                         $("#formoid").submit(function(event) {
                     
                           /* stop form from submitting normally */
                           event.preventDefault();
                     
                           /* get the action attribute from the <form action=""> element */
                           var $form = $( this ),
                               url = $form.attr( 'action' );
                     
                           /* Send the data using post with element id meal and datepicker*/
                           var posting = $.post( url, { meal: $('#meal').val(), datepicker: $('#datepicker').val() } );
                     
                           /* Alerts the results */
                           posting.done(function( data ) {
                             $("#formoid").hide();
                             $("#successMessage").show();
                           });
                         });
                     </script>
                     
                     
                    <!-- modal script -->
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
               
                  <!-- END INGREDIENTS -->
                  </div>
                  
         </div> <!-- end <div class = "row"> -->

         <!-- GET THE RECIPE FOR THE RECIPEID -->
                  
         <div class = "row">
            
            <div class = "col-md-9">
                  
                  <h2>How To Cook</h2>
               
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
               
         </div> <!-- end <div class = "row"> -->
         
         <!-- END RECIPE -->
      	
      </div>
      
      	<!-- SINGLERECIPE CONTENTS END HERE -------------------------------------------------------------------------------------- -->
      	
      		
   </div> <!-- end <div class = "container-fluid"> -->
   
</body>
	
<footer>
   <?php 
   // Add footer
   include_once "footer.php";
   ?>
</footer>
	
</html>