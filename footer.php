<!--
Version Control:
Jane Geard 28/06/2016: Created footer page with links and copyright
Jane Geard 11/07/2016: Modified layout so that footer comes after the
sidebar and main body of text.
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

    <!--link to Bootstrap css stylesheets-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
  <div id = "footer">
    <?php // footer.php 
    session_start();
    

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
  </div>
</body>
</html>
