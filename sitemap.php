<!DOCTYPE html>
<?php
   session_start();
   include_once "header.php";
?>

<head>
   <title>Site Map</title>
   
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <link rel="stylesheet" href="css/sitemap.css">
</head>


<body>
   <div class='container'>
      <div class='col-sm-12'>
         <h1>Site Map</h1>
         <p>This is a site map of the PantyPal web app. 
         If you find an issue with this site please <a href='https://bits-it-crowd-melbnetworks.c9users.io/contactus.php'>contact us.</a>
         </p>
         </br>
      
         <div class='col-sm-12'>
            <p id='note'>* Please note that you will need to login to access these pages.</p> 
            <ul>
            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/index.php'>Home Page</a></li>
            <li class='idented'><a href='https://bits-it-crowd-melbnetworks.c9users.io/registeruser.php'>New User Registration</a></li>
            <li class='idented'><a href='https://bits-it-crowd-melbnetworks.c9users.io/login.php'>Existing User Login</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/recipes.php'>*Recipes</a></li>
            <li class='idented'><a href='https://bits-it-crowd-melbnetworks.c9users.io/favourites.php'>*Favourites</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/mealplan.php'>*Meal Plan</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/mylist.php'>*My List</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/contactus.php'>Contact Us</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/sitemap.php'>Site Map</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/faq.php'>FAQ</a></li>

            <li class='main'><a href='https://bits-it-crowd-melbnetworks.c9users.io/aboutus.php'>About Us</a></li>
            </ul>
         </div>
      </div>
   </div>
   
<?php include_once "footer.php"; ?>   
   
</body>