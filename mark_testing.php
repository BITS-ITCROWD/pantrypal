<!DOCTYPE html>

<html lang="en">
   
<?php

   include("config.php");
   
   //adds the header
   include_once "header.php";

?>

<head>
   <title>Recipes</title>
</head>

<body>
   
   <a href="recipes.php">Link to Actual Recipes page</a>
   <h3>Search  Recipes</h3> 
   <p></p> 
   <form  method="post" action="mark_testing.php?go"  id="searchform"> 
      <input  type="text" name="searchEntry"> 
      <input  type="submit" name="submit" value="Search"> 
   </form> 
   
   <?php
   
   //Playing around with pages
   $requested_page =($_GET['page']) ? intval($_GET['page']) : 1;
   $display = false;
   
   if($requested_page>1) {
      $searchEntry = $_GET['search'];
      $display = true;
   } else {
      if(isset($_POST['submit'])){ 
         if(isset($_GET['go'])){ 
            if(preg_match("/^[  a-zA-Z]+/", $_POST['searchEntry'])){ 
               $searchEntry = $_POST['searchEntry']; 
               $display = true;
            }
         }
      }
   }

   if($display==true) {
      
      // Get the product count
      $searchQuery = $db->query("SELECT * FROM recipe WHERE recipeName LIKE '%" . $searchEntry .  "%'");
   
      //$d = mysql_fetch_row($searchQuery);
      $product_count = $searchQuery->rowCount();
      echo 'Count is '.$product_count.'<br>';

      $products_per_page = 10;

      // 55 products => $page_count = 3
      $page_count = ceil($product_count / $products_per_page);

      // You can check if $requested_page is > to $page_count OR < 1,
      // and redirect to the page one.
   
      if(($page_count<=1)||($requested_page==1)) {
         $first_product_shown = 1;
          echo 'first product: '.$first_product_shown.'<br>'.'';
      } else {
         $first_product_shown = ($requested_page - 1) * $products_per_page;
         echo 'first product: '.($requested_page - 1).'*'.$products_per_page.' = ' .$first_product_shown;
      }
   

   
      echo '</p>';
   
      echo 'Line 74 '. $first_product_shown.' '.$products_per_page;
      echo"<br>";

      $i = $first_product_shown;
      $j = 1;
      
      // Then we retrieve the data for this requested page
      while($r = $searchQuery->fetch()) {
         $j++;
               
         if($j>($first_product_shown-1)) {
            $recipeNumber = $r['recipeNumber'];
            $recipeName = $r['recipeName'];
            $recipeImage =$r['imageURL'];
               
            if($i==1) {
              echo "<br>Showing search results for \"".$searchEntry."\"<br><br>";
            }
               
            echo "<img src='$recipeImage' width='50' height='50'>";
            $link_address = "singlerecipe.php?rid=$recipeNumber";
            echo "<a href='".$link_address."'>     $recipeName</a>";
            echo "<br>";
            $i++;
         }
               
         if($i==($first_product_shown+$products_per_page)) {
            echo "Got to break";
            break;
         }
            
      } 
   
   
   
   // Ok, we write the page links  
   echo '<p>';
   echo 'Page ';
   for($i=1; $i<=$page_count; $i++) {
      if($i == $requested_page) {
         echo $i.' ';
      } else {
         $page_address = "mark_testing.php?page=$i&search=$searchEntry";
         echo '<a href="'.$page_address.'">'.$i.'</a> ';
      }
   }
      
   }
   
   
   
   //$r2 = $db->query("SELECT * FROM recipe WHERE recipeName LIKE '%" . $searchEntry .  "%' LIMIT $first_product_shown, $products_per_page");

echo "here";

   /*while($d = $r2->fetch()) {
      $recipeNumber = $r['recipeNumber'];
      $recipeName = $r['recipeName'];
      $recipeImage =$r['imageURL'];
               
      if($i==0) {
         echo "<br>Showing search results for \"".$searchEntry."\"<br><br>";
      }
               
      echo "<img src='$recipeImage' width='50' height='50'>";
      $link_address = "singlerecipe.php?rid=$recipeNumber";
      echo "<a href='".$link_address."'>     $recipeName</a>";
      echo "<br>";
      $i++;
   }*/

   /*while($d = mysql_fetch_assoc($r2)) {
      var_dump($d);
      $link_address = "singlerecipe.php?rid=$recipeNumber";
      echo "<a href='".$link_address."'>     $recipeName</a>";
      echo "<br>";
   }*/
   
   
   
   
   /*
   //** Working search function
   if(isset($_POST['submit'])){ 
      if(isset($_GET['go'])){ 
         if(preg_match("/^[  a-zA-Z]+/", $_POST['searchEntry'])){ 
            $searchEntry = $_POST['searchEntry']; 
            
            $query = $db->query('SELECT * FROM recipe WHERE recipeName LIKE "%' . $searchEntry .  '%"');
            $i = 0;
            
            while($r = $query->fetch()) {
               $recipeNumber = $r['recipeNumber'];
               $recipeName = $r['recipeName'];
               $recipeImage =$r['imageURL'];
               
               if($i==0) {
                  echo "<br>Showing search results for \"".$searchEntry."\"<br><br>";
               }
               
               echo "<img src='$recipeImage' width='50' height='50'>";
               $link_address = "singlerecipe.php?rid=$recipeNumber";
               echo "<a href='".$link_address."'>     $recipeName</a>";
               echo "<br>";
               $i++;
            
            } 
            
            
             
         } else{ 
            echo  "<p>Please enter a search query</p>"; 
         } 
      } 
   } */
   
   echo '<br><br>';
   include_once "footer.php";
   ?>
</body>

</html>