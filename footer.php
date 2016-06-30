<!--
Version Control:
Jane Geard 28/06/2016:

-->

<!DOCTYPE html> <!--indicates that this is a html5 document type to the browser-->
<html lang="en">
<head>
    <!--Compatibility with earlier versions of IE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--specifies the character	encoding of utf-8-->
    <meta charset="utf-8">
    
    <!--responsive to mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<?php // footer.php 
session_start();


//link to Bootstrap css stylesheets
echo '<link href="css/bootstrap.min.css" rel="stylesheet">';

// adds the copyright text
echo  '<p class="navbar-text">'.
        '&copy The IT Crowd 2016 </p>';

//If logged in

if(isset($_SESSION['login_success']))
{
  // adds the footer links
  echo  '<ul class="nav navbar-nav navbar-right">'.
        '<li><a href="contactus.php">Contact</a></li>'.
        '<li><a href="sitemap.php">Site Map</a></li>'.
        '<li><a href="faq.php">FAQ</a></li>' .
        '<li><a href="aboutus.php">About Us</a></li></ul>';
}
 
//not logged in

else {
  
  // adds the footer links
  echo  '<ul class="nav navbar-nav navbar-right">'.
        '<li><a href="login.php">Contact</a></li>'.
        '<li><a href="login.php">Site Map</a></li>'.
        '<li><a href="faq.php">FAQ</a></li>' .
        '<li><a href="aboutus.php">About Us</a></li></ul>';
}


?>