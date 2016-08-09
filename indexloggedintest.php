<!DOCTYPE html>

<html lang="en">
   

<?php
     
   include("config.php");
   
   //Add header
   include_once "header.php";
   

?>

<head>
   <link href="css/mark.css" rel="stylesheet">
   <title>Welcome To PantryPal</title>
</head>

<body>
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
</body>

</html>