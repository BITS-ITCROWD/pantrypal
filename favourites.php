<!--
Version Control:
Jane Geard 25/07/2016: Create base bage layout
Jane Geard 26/07/2016: Added retrieval of favourites based on user signed in.
Used quite a bit of Mark's code from recipes.php for the pagination 
and adapted it to fit with the requirements of this page
-->

<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   session_start();
?>
<html>
<head>
   <title>Favourites</title>
</head>

<body>
   
   
   <div class="container">
   <?php include_once "sidebar.php"; ?>
   
   <div class="col-sm-9" >
      
<?php

   // obtain user ID
   $userID = $_SESSION['login_userid'];
   
   // retrieve user's favourites
    $records = $db->prepare('SELECT recipe.* FROM favourites, recipe WHERE userid = :userid 
                              and favourites.recipeNumber = recipe.recipeNumber');
               			$records->bindParam(':userid', $userID);
               			$records->execute();
               			
   //Borrowed Mark's recipe retrieval code
   
   // Check page number
   $requested_page =($_GET['page']) ? intval($_GET['page']) : 1;
   
   $product_count = $records->rowCount();
   
      
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
      while($r = $records->fetch()) {
         $j++;
         
         // Only display results higher than $first_product_shown      
         if($j>($first_product_shown-1)) {
            $recipeNumber = $r['recipeNumber'];
            $recipeName = $r['recipeName'];
            $recipeImage =$r['imageURL'];
               
            if((($requested_page>1)&&($i%$products_per_page==0))||$i==1) {
              echo "<br><h2>These are your favourite recipes</h2>";
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
            $page_address = "favourites.php?page=$i";
            echo '<a href="'.$page_address.'">'.$i.'</a> ';
         }
      }
   

?>  

     </div>
   </div>

<?php include_once "footer.php"; ?>
</body>

</html>