<!--
Version Control:
Jane Geard 28/06/2016: Created footer page with links and copyright
Jane Geard 11/07/2016: Modified layout so that footer comes after the
sidebar and main body of text.
Jane Geard 03/08/2016: Updated to include fixed footer and collapsible menu
Jane Geard 15/08/2016: Added references / sources for code
-->

<!--http://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->

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
<body>
  <div id = "footer">
      <!--source http://stackoverflow.com/questions/17966140/twitter-bootstrap-3-sticky-footer-->
      <div class = "footer navbar navbar-default navbar-fixed-bottom">
       <div class = "container">
        
          
          <!--adding hamburger collapsable menu item courtesy of 
          https://www.lynda.com/Bootstrap-tutorials/Collapsing-your-navigation/417641/429462-4.html-->
          
          <button type = "button"
            class = "navbar-toggle collapsed"
            data-toggle="collapse"
            data-target="#collapsefootermenu"
            aria-expanded="false">
            <span class = "sr-only">Toggle navigation</span>
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
            <span class ="icon-bar"></span>
          </button>
            
            <!-- adds the copyright text-->
                <p class="navbar-text">
                  &copy The IT Crowd 2016 </p>
                 
        <?php // footer.php 
        session_start();
        
        //If logged in
    
        if(isset($_SESSION['login_success']))
          {
            // adds the footer links
            
            echo '<div class="collapse navbar-collapse" id="collapsefootermenu">'.
                 '<ul class="nav navbar-nav navbar-right">'.
                  '<li><a href="contactus.php">Contact</a></li>'.
                  '<li><a href="sitemap.php">Site Map</a></li>'.
                  '<li><a href="faq.php">FAQ</a></li>' .
                  '<li><a href="aboutus.php">About Us</a></li></ul></div>';
          }
     
        //not logged in
    
            else {
      
          // adds the footer links
                echo '<div class="collapse navbar-collapse" id="collapsefootermenu">'.
                      '<ul class="nav navbar-nav navbar-right">'.
                      '<li><a href="contactus.php">Contact</a></li>'.
                      '<li><a href="sitemap.php">Site Map</a></li>'.
                      '<li><a href="faq.php">FAQ</a></li>' .
                      '<li><a href="aboutus.php">About Us</a></li></ul></div>';
                  }
        ?>
        </div>
        </div>
    </div>
</body>
</html>
