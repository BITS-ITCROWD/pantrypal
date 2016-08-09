<!--
Version Control:
Jane Geard 30/06/2016: Added a welcome section with text. 
Amended the format of the login and added register button. Still more work to
do on layout.
Jane Geard 20/07/2016: Modified to store firstname variable and changed :demo
-->

<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   
   session_start();
   
 if(isset($_POST['submit'])){
		$errMsg = '';
		//username and password sent from Form
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($username == '')
			$errMsg .= 'You must enter your Username<br>';
		
		if($password == '')
			$errMsg .= 'You must enter your Password<br>';
		
		
		if($errMsg == ''){
			$records = $db->prepare('SELECT * FROM users WHERE username = :username AND password =:password');
			$records->bindParam(':username', $username);
			$records->bindParam(':password', $password);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			if($results > 0){
				$_SESSION['login_success'] = $results['username'];
				$_SESSION['login_userid'] = $results['ID'];
				$_SESSION['firstname'] = $results['firstname'];
				header('location:index.php');
				exit;
			}else{
				$errMsg .= 'Username and Password are not found';
			}
		}
	}
?>
<html>
<head>
	<link href="css/mark.css" rel="stylesheet">
	<title>Welcome Page - Logged Out</title>
</head>

<body>
	<?php // NOT LOGGED IN
	if(!isset($_SESSION['login_success'])){ ?>
	
      <!-- Welcome message-->
		<div class="jumbotron">
			<div class="container text-center">
		  		<h1>Welcome to <img class ="img-responsive center-block" alt="PantryPal Logo" src="/images/pantrypal_logo_transparent.png"></h1>
  				<p>PantryPal allows you to select from a wide range of recipes to build 
  				a meal plan for your weekly shop. It adds the ingredients required to a
  				shopping list that can be viewed online, printed or emailed. The list is 
  				updated each time a recipe is added to your meal plan so that the final
  				list shows the ingredients required. You can amend or delete ingredients
  				that may already exist in your pantry, simplifying your weekly shop.
  				You can also add favourites so that you do not have to search for the
  				same recipes each week.</p>
  				<h2>Why not give it a go?</h2>
  			</div>
  		</div>

		<div class="container">
		   <!--Row with two equal columns-->
     		<div class="row">
     	   	<div class="col-sm-2"> </div>
        
        			<div class="col-sm-4 form-group"><!--Column left-->
		      	
		      	<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
						}
					?>
					
   				<form action ="" method ="post">
		    	   	<input type="email" class="form-control" placeholder="Email" name="username" required></br>
		        	 	<input type="password" class="form-control" placeholder="Password" name="password" required></br>
		        		<button type="submit" class="btn btn-primary" name='submit'>Sign In</button>
					</form>
    			</div>
 
 				<div id = "register">
   				<div class="col-sm-4"> <!--Column right-->
 	   				<h2>Don't have a PantryPal Account?
  						<a class="btn btn-primary" href="registeruser.php" role="button">Register here</a>
  						</h2>
  					</div>
  				</div>
  				<div class="col-sm-2"> </div>
  		
    		</div>
		</div>
      
   <?php } 
   
   // LOGGED IN
	if(isset($_SESSION['login_success'])){ ?>
	
   	<?php include_once "sidebar.php"; ?>
   
   	<div class="container">  <!-- Container for the whole content section -->
	      <div id="main-content" class="col-sm-9" >
         	<h1>Welcome to PantryPal</h1>
         	<h3>It's as easy as...</h3>
         
         	<div class="container">
         	<div id="stepsContent" class="col-sm-9">  <!-- This div contains the steps -->
            
	            <div id="stepOne" class="steps col-md-3">
   	            <div id="stepNumber">
      	            <img src="/images/numberOne.png">
         	      </div>
            	   <div id="stepInstructions">
               	   <p>Search for a recipe</p>
                  	<!-- Search bar that links to recipes.php -->    
	                  <p><form  method="post" action="recipes.php?go"  id="searchform"> 
                  	<input  type="text" name="searchEntry" placeholder="  Search Recipes.." style="width: 150px;"> 
                  	<button type="submit" class="btn btn-default" name="submit">
	                     <span class="glyphicon glyphicon-search"></span>
                  	</button>
                  	</form></p> 
                  	<p>or view your <a href="favourites.php">favourites</a></p>
               	</div>
            	</div>
            	<div id="stepTwo" class="steps col-md-3">
	               <div id="stepNumber">
                  	<img src="/images/numberOne.png">
               	</div>
               	<div id="stepInstructions">
	                  <p>Plan your meals by adding recipes to your Meal Planner </p>
                  	<p><input type="button" class = "btn btn-primary" onclick="location.href='/recipes.php';" value="Add to Meal Planner" /></p>
               	</div>
            	</div>
            	<div id="stepThree" class="steps col-md-3">
	               <div id="stepNumber">
                  	<img src="/images/numberOne.png">
               	</div>
               	<div id="stepInstructions">
	                  <p>View, print or email your shopping list</p>
                  	<p><input type="button" class = "btn btn-primary" onclick="location.href='/mylist.php';" value="My List" /></p>
               	</div>
            	</div>
         	</div>
         	</div>
	         
         	<br>
         	<h2>Here are some recipes you might like</h2>
	         
         	<div class="container">
	            <div id="suggestedRecipes" class="col-sm-9">
               	<div id="recipeOne" class="recipe col-md-3">
	                  <?php 
                  	// Get recipe information
                  	$searchQuery = $db->query("SELECT * FROM recipe");
	            
                  	// Count recipes and generate random number
                  	$recipe_count = $searchQuery->rowCount();
	               
                  	$randomNumber= rand(1,$recipe_count);
	            
                  	// Values for while loop below
                  	$j=0;
	            
                  	while($r = $searchQuery->fetch()) {
	                     $j++;
               	
                     	// Get details for random recipe      
                     	if($j==$randomNumber) {
	                        $recipeNumber = $r['recipeNumber'];
                        	$recipeName = $r['recipeName'];
                        	$recipeImage =$r['imageURL'];
	                  
                        	$link_address = "singlerecipe.php?rid=$recipeNumber";
                        	echo "<a href='".$link_address."'><img src='$recipeImage' width='150' height='150'></a>";
                        	echo "<br><br>";
                        	echo "<a href='".$link_address."'>     $recipeName</a>"; 
                     	}
                  	}
                  	?>
               	</div>
               	<div id="recipeTwo" class="recipe col-md-3">
	                  <?php 
                  	// Get recipe information
                  	$searchQuery = $db->query("SELECT * FROM recipe");
	            
                  	// Count recipes and generate random number
                  	$recipe_count = $searchQuery->rowCount();
	               
                  	$randomNumber= rand(1,$recipe_count);
	            
                  	// Values for while loop below
                  	$j=0;
	            
                  	while($r = $searchQuery->fetch()) {
	                     $j++;
               	
                     	// Get details for random recipe      
                     	if($j==$randomNumber) {
                        	$recipeNumber = $r['recipeNumber'];
	                        $recipeName = $r['recipeName'];
                        	$recipeImage =$r['imageURL'];
	                  
                        	$link_address = "singlerecipe.php?rid=$recipeNumber";
                        	echo "<a href='".$link_address."'><img src='$recipeImage' width='150' height='150'></a>";
                        	echo "<br><br>";
	                        echo "<a href='".$link_address."'>     $recipeName</a>"; 
                     	}
                  	}
                  	?>
               	</div>
               	<div id="recipeThree" class="recipe col-md-3">
	                  <?php 
                  	// Get recipe information
                  	$searchQuery = $db->query("SELECT * FROM recipe");
	            
                  	// Count recipes and generate random number
                  	$recipe_count = $searchQuery->rowCount();
	               
                  	$randomNumber= rand(1,$recipe_count);
	            
                  	// Values for while loop below
                  	$j=0;
            
	                  while($r = $searchQuery->fetch()) {
   	                  $j++;
               	
                     	// Get details for random recipe      
                     	if($j==$randomNumber) {
	                        $recipeNumber = $r['recipeNumber'];
                        	$recipeName = $r['recipeName'];
                        	$recipeImage =$r['imageURL'];
	                  
                        	$link_address = "singlerecipe.php?rid=$recipeNumber";
                        	echo "<a href='".$link_address."'><img src='$recipeImage' width='150' height='150'></a>";
                        	echo "<br><br>";
                        	echo "<a href='".$link_address."'>     $recipeName</a>"; 
                     	}
                  	}
	                  ?>
               	</div>
            	</div>
	            
         	</div>
      	</div>
   	</div>
	   
	   <?php include_once "footer.php"; ?>
	
      
   <?php } ?>
	
</body>
<?php
include_once "footer.php";
?>
</html>