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
    
    
    
    <!--link to Bootstrap css stylesheets-->
  <link rel="stylesheet" type="text/css" href="css/modal.css">
  
  
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
      include_once("recursiveIterator_mod.php");
		
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
	
	<title>Selected Recipe</title>
	
</head>

<body>
   
   <div class = "container">
	
	   <!-- LEFT NAV MENU -->
	
   	<div class="col-md-2">
      	<?php
      	
      	include_once "sidebar.php";
      	
      	?>
   	</div>
	
   	<!-- MIDDLE SECTION - main contents of page -->
   	
   	<div class="col-md-10">
   	   
   	   
   	   <!-- top row - contmains the recipe image, recipe name, and blank space -->
   	   <div class = "row">
   	   
   	   
   	      <!-- GET THE IMAGE WITH THE RECIPEID -->
   	   
         	<div class = "col-md-5" style = "padding: 1.5em 0em 0 1em">
         	
               	<?php
               	
               	$sql = $db->prepare("SELECT imageName from recipe where recipeNumber = :rid");
                  	$sql->bindParam(':rid', $rid);
                     $sql->execute();
               	
               	$result = $sql->fetchColumn();
               	$dir = "images/recipe_images";
               
                  echo "<div><img src='".$dir."/". $result ."' alt='".$result."' style='max-width:350px;max-height:350px;display: block;width: auto;height: auto;' class = 'img-thumbnail'></div>";
                  
                  ?>
                  
                  <!-- END IMAGE -->
                  
            </div>
            
            <div class = "col-md-6 jumbotron text-center" style="margin: 1.5em 0 0 0">
               
                  <!-- GET THE RECIPE NAME WITH THE RECIPEID -->
                  
                  <?php
            	
            	   $sql = $db->prepare("SELECT recipeName from recipe where recipeNumber = :rid");
               	$sql->bindParam(':rid', $rid);
                  $sql->execute();
            	
            	   $name = $sql->fetchColumn();
               	
            
                  echo "<h2> $name </h2>";
            
                  ?>
               
            </div>
            
            <div class = "col-md-1">
               
            </div>
            
         </div> <!-- end <div class = "row"> -->	
         
         <!-- middle row - contains the ingredients list and "Add" buttons and logic -->
         <div class = "row">
            	
            <div class = "col-md-8 panel panel-default" style = "margin: 2em 0 0 1em">
               
               <div class = "panel-body">
         	   
         	   <!-- GET THE INGREDIENTS FOR THE RECIPEID -->
         	   
         	   <h2>Ingredients</h2>
         	   
            	<?php
               	
               	echo "<table class='table' style='width:100%;border: solid 1px black; padding: 0.5em'>";
                  echo "<tr><th>Ingredient</th></tr>";
               
               	$sql = $db->prepare("SELECT ingredient FROM ingredient where recipeNumber = :rid");
               	$sql->bindParam(':rid', $rid);
                  $sql->execute();
                  
                  $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
                   foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
                       echo $v;
                     }
                     
                     echo "</table>";
            
               ?>
               </div>
            </div>
            
            <div class = "col-md-3" style = "margin: 2em 0 0 0">
               
               
               
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
                     <button id="lukemyBtn" class = "btn btn-primary">Add to Meal Planner</button></br></br>
                     
                     
                                 <!--Added by Jane: Add to favourites button-->
                     
                     <form action = "" method="post">
                     <button type="submit" button id="Add_Favourites" class = "btn btn-primary" 
                     name="submit"><?php echo $fav_btn_name?></button>
                     </form>
                     
                                    <!-- The Modal -->
                     <div id="lukemyModal" class="lukemodal">
                     
                       <!-- Modal content -->
                       <div class="lukemodal-content">
                         <span class="lukeclose">x</span>
                         
                      <!-- borrowed from https://jqueryui.com/datepicker/#animation on 28/6 -->
                     
                        <form id="formoid" action="addtomealplan.php" title="" method="post">
                           
                           <input id="format" type="hidden" value="yy-mm-dd">
                           
                           <div class = "row">
                              
                                 <div class = "col-md-4">
                              
                           		   <h3>Date:  </h3><input type="text" id="datepicker" size="30" name="datepicker" required />
                            
                                 </div>
                              
                                 <div class = "col-md-2">
                            
                  					   <h3>Meal:  </h3> 
                  					   
                  					   <div id = "lukestyled">
                  					
                                       <select id="meal" name="mtime" required>
                                         <option value="B">Breakfast</option>
                                         <option value="L">Lunch</option>
                                         <option value="D">Dinner</option>
                                       </select>
                                    
                                    </div>
                                    
                                 </div>
                                 
                              </div>
                              
                              <div class = "row">
                                 
                                <div class = "col-md-2" style = "margin: 2em 0 2em 0">
                                   
                                    <input class = "btn btn-primary" type="submit" id="submitButton"  name="submitButton" value="Submit">
                                    
                                </div> 
                               
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

         
         <!-- bottom row - contains the recipe -->
         <!-- GET THE RECIPE FOR THE RECIPEID -->
                  
         <div class = "row">
            
            <div class = "col-md-8 panel panel-default" style = "margin: 2em 0 0 1em">
               
               <div class = "panel-body">
                  
                  <h2>How To Cook</h2>
               
                  <?php
                  	
                  	echo "<table class='table' style='width:100%;border: solid 1px black; padding: 0.5em'>";
                     echo "<tr><th>Description</th></tr>";
                  	
                  	$sql = $db->prepare("SELECT stepDescription FROM method where recipeNumber = :rid");
                  	$sql->bindParam(':rid', $rid);
                     $sql->execute();
                     
                     $result = $sql->setFetchMode(PDO::FETCH_ASSOC); 
                      foreach(new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k=>$v) { 
                          echo $v;
                        }
                        
                        echo "</table>";
               
                  ?>
                 </div>
                 
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