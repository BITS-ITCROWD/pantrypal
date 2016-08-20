<!--
Version Control:
Jane Geard 23/06/2016: Added html head settings including windows 10 and mobile 
compatibility. Added Bootstrap link and basic header navigation menu
Jane Geard 27/06/2016: Added different navigation links depending on if the 
user is successfully logged in or not
Jane Geard 28/6/16: Added a placeholder for pantrypal logo and aligned 
user welcome / logout links
Jane Geard 30/06/16 Added Login and Register links when user not signed in.
Corrected home link when logged in to Dashboard
Jane Geard 20/07/16 - Modified welcome message to display first name
Jane Geard 26/07/16 - Modified navigation to be active depending on the page
Jane Geard 02/08/16 - Added link to javascript, the logo, collapsable hamburger, nav colour. 
Jane Geard 11/08/16 - Add a reference to the source of data on the website
Jane Geard 15/08/2016 - adding references and sources of info for code

-->
<!--All recipe data and images displayed on the website have been scraped from
www.taste.com.au and are used for educational purposes only-->

<!DOCTYPE html> <!--indicates that this is a html5 document type to the browser-->
<html lang="en">
  
<!--header.php    http://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
<head>
    <!--Compatible with earlier versions of IE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--specifies the character	encoding of utf-8-->
    <meta charset="utf-8">
    
    <!--responsive to mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--link to Bootstrap css stylesheets-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--link to our override css stylesheet-->
    <link rel="stylesheet" href="css/styles.css">
    
    <!--include javascript-->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
  
</head>
<!--http://getbootstrap.com/components/#navbar-->
<body>
  <div id = "header">
    <nav class="navbar navbar-default">
      <div class="container"> 
        <div class="navbar-header">
          
          <!--adding hamburger collapsable menu item courtesy of 
          https://www.lynda.com/Bootstrap-tutorials/Collapsing-your-navigation/417641/429462-4.html-->
          
          <button type = "button"
            class = "navbar-toggle collapsed"
            data-toggle="collapse"
            data-target="#collapsemenu"
            aria-expanded="false">
            <span class = "sr-only">Toggle navigation</span>
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
          </button>
          
        <a class="navbar-brand navbar-left" href="index.php">
        <img class ="logo" alt="PantryPal Logo" src="/images/pantrypal_logo_transparent.png">
        </a>
        </div>
        
        <?php
          session_start();
    
          //http://stackoverflow.com/questions/13032930/how-to-get-current-php-page-name
          $user_welcome = ' (Guest)';
          $page = basename($_SERVER['PHP_SELF']); 
          
          //If logged in
          
          
          ?>
          <?php if(isset($_SESSION['login_success'])) : ?>
          
            <?php $user_welcome = $_SESSION['firstname']; 
          
           //welcome and sign out links
          
          echo '<p class="navbar-text navbar-right">'.
               'Hi '.$user_welcome; 
          echo '! | <a href="logout.php" class="navbar-link">Logout</a></p>';
          ?>
          
          <!--navigation--http://stackoverflow.com/questions/13336200/add-class-active-to-active-page-using-php>-->
          
          <div class="collapse navbar-collapse" id="collapsemenu">
            <ul class="nav navbar-nav navbar-right">
            <li class="<?php if($page == 'index.php' || $page =='index.php') : ?> active <?php else : ?>noactive <?php endif;?>"><a href='index.php'>Home</a></li>
            <li class="<?php if($page == 'recipes.php'|| $page =='favourites.php'|| $page =='singlerecipe.php') : ?> active <?php else : ?>noactive <?php endif;?>"><a href='recipes.php'>Recipes</a></li>
            <li class="<?php if($page == 'mealplan.php') : ?> active <?php else : ?>noactive <?php endif;?>"><a href='mealplan.php'>Meal Plan</a></li>
            <li class="<?php if($page == 'mylist.php'|| $page =='IngredList.php') : ?> active <?php else : ?>noactive <?php endif;?>"><a href='mylist.php'>My List</a></li></ul> 
          
          </div>
          
          <?php else : ?>
          
          <!--not logged in-->
            
            <!--login or register links-->
              
            <?php echo '<p class="navbar-text navbar-right">'.
               '<a href="login.php" class="navbar-link">Login</a>';
            echo ' | <a href="registeruser.php" class="navbar-link">Register</a></p>';
          ?>
          
            <!--navigation-->
            
          <div class="collapse navbar-collapse" id="collapsemenu">
            <ul class='nav navbar-nav navbar-right'>
            <li class="active"><a href='index.php'>Home</a></li>
            <li><a href='login.php'>Recipes</a></li>
            <li><a href='login.php'>Meal Plan</a></li>
            <li><a href='login.php'>My List</a></li></ul>
          </div>
            
          <?php endif; ?>
      </div>
    </nav>  
  </div>
</body>
</html>



