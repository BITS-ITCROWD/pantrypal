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
         <h2>Hi Quinto(set up function to call name later)</h2>
         <h1>Welcome to PantryPal</h1>
         <h3>It's as easy as...</h3>
         
         <div class="container"style="margin: auto;">
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
                  <p>or view your favourite recipes</p>
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
                  
               </div>
            </div>
         </div>
         </div>
      </div>
   </div>
   
   <?php include_once "footer.php"; ?>
</body>

</html>