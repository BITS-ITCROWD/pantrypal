<!--
Version Control:
Jane Geard 28/06/2016: Created sidebar page with basic button links.

-->

<!DOCTYPE html> <!--indicates that this is a html5 document type to the browser-->
<html lang="en">

<!-- sidebar.php-->
<head>
    <!--Compatible with earlier versions of IE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--specifies the character	encoding of utf-8-->
    <meta charset="utf-8">
    
    <!--responsive to mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--link to Bootstrap css stylesheets-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
  <!-- Mark - Playing with bootstrap layout -->
  <div class="col-sm-3">
  <!--<div id = "sidebar">-->
  <!-- Mark - Playing with bootstrap layout -->  
    <?php 
    session_start();
    
    ?>
      <!-- Search bar that links to recipes.php by Mark -->    
      <form  method="post" action="recipes.php?go"  id="searchform"> 
        <input  type="text" name="searchEntry" placeholder="  Search Recipes.."> 
        <button type="submit" class="btn btn-default" name="submit">
          <span class="glyphicon glyphicon-search"></span>
        </button>
      </form> 
      
      <div class="btn-group-vertical" role="group" aria-label="...">
        <button type="button" class="btn btn-default navbar-btn">
           <a href="favourites.php">View Favourite Recipes</a></button>
        <button type="button" class="btn btn-default navbar-btn">
           <a href="mealplan.php">View Meal Plan</a></button>
        <button type="button" class="btn btn-default navbar-btn">
           <a href="mylist.php">View Shopping List</a></button>
      </div>
      
        
    
  </div>
</body>
</html>