<!--
Version Control:
Jane Geard 28/06/2016: Created sidebar page with basic button links.
Jane Geard 04/08/2016: Updated so that sidebar is to be included as part of the
container of each page's main content. Changed buttons to use Primary format 
from Bootstrap
Jane Geard 11/08/2016: Adjusting sidebar to span 2 coloumns and aligning search 
with button widths
Jane Geard 15/08/2016: Added references / sources for code

-->

<!DOCTYPE html> <!--indicates that this is a html5 document type to the browser-->
<html lang="en">

<!-- sidebar.php     http://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
<head>
    <!--Compatible with earlier versions of IE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--specifies the character	encoding of utf-8-->
    <meta charset="utf-8">
    
    <!--responsive to mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
   
</head>
<body>
  <div id = "sidebar">
  
  <!-- Mark - Playing with bootstrap layout -->
  <div class="col-sm-2">
  
  <!-- Mark - Playing with bootstrap layout -->  
    <?php 
    session_start();
    
    ?>
    <!--Jane aligning the search and the buttons--  http://getbootstrap.com/components/#btn-groups-vertical>-->
    
    <div class="btn-group-vertical" role="group" aria-label="...">
      
      <div id =sidebar_search>
        
           <!-- Search bar that links to recipes.php by Mark -->    
        <form  method="post" action="recipes.php?go"  id="searchform"> 
          <input  type="text" name="searchEntry" placeholder="  Search Recipes..">
          <button type="submit" class="btn btn-primary" name="submit">
            <span class="glyphicon glyphicon-search"></span> Search
          </button>
        </form> </br>
       </div>
        
      <!--button links-- http://getbootstrap.com/components/#navbar-buttons>-->
      
        <button type="button" class="btn btn-primary navbar-btn col-xs-2">
           <a href="favourites.php">View Favourites</a></button>
        <button type="button" class="btn btn-primary navbar-btn">
           <a href="mealplan.php">View Meal Plan</a></button>
        <button type="button" class="btn btn-primary navbar-btn">
           <a href="mylist.php">View My List</a></button>
    </div>
      
       
   </div>
  </div>
</body>
</html>