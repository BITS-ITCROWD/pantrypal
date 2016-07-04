<!DOCTYPE html>

<html lang="en">
   
<?php

   include("config.php");
   
   //Add header
   include_once "header.php";
   
?>

<head>
   <title>Recipes</title>
</head>

<body>
   <?php include_once "sidebar.php"; ?>
   
   <div class="container"> <!-- haven't indented everything since adding this line-->
   
   <div class="col-sm-9" >
      
   <h3>Search  Recipes</h3> 
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
               
            if((($requested_page>1)&&($i%$products_per_page==0))||$i==1) {
              echo "<br><p>Showing search results for \"".$searchEntry."\"</p>";
              echo "<br>";
            }
               
            echo "<img src='$recipeImage' width='50' height='50'>";
            $link_address = "singlerecipe.php?rid=$recipeNumber";
            echo "<a href='".$link_address."'>     $recipeName</a>";
            echo "<br>";
            $i++;
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
   
   echo '<br><br>';
   
   ?>
   </div>
   </div>
   <?php include_once "footer.php"; ?>
</body>

</html>