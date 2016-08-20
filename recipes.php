<!DOCTYPE html>

<html lang="en">
   

<?php
     
   include("config.php");
   
   //Add header
   include_once "header.php";
   

?>

<head>
   <link href="css/mark.css" rel="stylesheet">
   <title>Recipes</title>
</head>

<body>
   
   
   <div class="container"> <!-- haven't indented everything since adding this line-->
   
   <?php include_once "sidebar.php"; ?> <!--jane moving sidebar within content container-->
   
   <div id="main-content" class="col-sm-9" >
      
   <br>
   <h1>Search  Recipes</h1> 
   <p></p> 
   <form  method="post" action="recipes.php?go"  id="searchform"> 
      <input  type="text" name="searchEntry" placeholder="  Search.."> 
      <button type="submit" class="btn btn-default" name="submit">
         <span class="glyphicon glyphicon-search"></span> Search
      </button>
   </form> 
   
   <?php
   
   // Using the search bar above, display results as links to singlerecipe.php
   
   // Check page number
   $requested_page =($_GET['page']) ? intval($_GET['page']) : 1;
   $display = false;
   
   /*If searchEntry is not blank set $display to true. 
     If submit button has been clicked and searchEntry value fits requirements, 
      set $display to true 
   */
   if($_GET['search']!='') {
      $searchEntry = $_GET['search'];
      $display = true;
   } else {
      if(isset($_POST['submit'])){ 
         if(isset($_GET['go'])){ 
            if(preg_match("/^[  a-zA-Z]+/", $_POST['searchEntry'])){ 
               $searchEntry = $_POST['searchEntry']; 
               $display = true;
            } else {
               echo "<p>Please enter a search query</p>";
            }
         }
      } 
   } 

   if($display==true) {
      
      // Get the product count
      $searchQuery = $db->query("SELECT * FROM recipe WHERE recipeName LIKE '%" . $searchEntry .  "%'");
   
      $product_count = $searchQuery->rowCount();
      
      $products_per_page = 10;

      // Set page_count
      $page_count = ceil($product_count / $products_per_page);
      
      // Set $first_product_shown dependant on page number
      if(($page_count<=1)||($requested_page==1)) {
         $first_product_shown = 1;
      } else {
         $first_product_shown = ($requested_page - 1) * $products_per_page;
      }
      
      //Values for while loop below
      $i = $first_product_shown;
      $j = 1;
      
      // Retrieve the data for this requested page
      while($r = $searchQuery->fetch()) {
         $j++;
         
         // Only display results higher than $first_product_shown      
         if($j>($first_product_shown-1)) {
            $recipeNumber = $r['recipeNumber'];
            $recipeName = $r['recipeName'];
            $recipeImage =$r['imageURL'];
            
            ?> <div id="searchResults"> <?php
               
            if((($requested_page>1)&&($i%$products_per_page==0))||$i==1) {
              echo "<br><p>Showing search results for \"".$searchEntry."\"</p>";
              echo "<br>";
            }
            
            echo "<img src='$recipeImage' width='80' height='80'>";
            $link_address = "singlerecipe.php?rid=$recipeNumber";
            echo "<a href='".$link_address."'>     $recipeName</a>";
            echo "<br><br>";
            $i++;
            
            ?> </div> <?php
         }
         
         // Break the loop when $products_per_page has been reached      
         if($i==($first_product_shown+$products_per_page)) {
            break;
         }
      } 
   
      // Display the page links  
      echo '<p><br>';
      echo 'Page ';
      for($i=1; $i<=$page_count; $i++) {
         if($i == $requested_page) {
            echo $i.' ';
         } else {
            $page_address = "recipes.php?page=$i&search=$searchEntry";
            echo '<a href="'.$page_address.'">'.$i.'</a> ';
         }
      }
      
   } 
   
   echo '<br>';
   
   ?>
   
         <h3>Or try one of these</h3>
         
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