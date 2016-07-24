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
-->

<!DOCTYPE html> <!--indicates that this is a html5 document type to the browser-->
<html lang="en">
  
<!--header.php-->
<head>
    <!--Compatible with earlier versions of IE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--specifies the character	encoding of utf-8-->
    <meta charset="utf-8">
    
    <!--responsive to mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--link to Bootstrap css stylesheets-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!--include javascript-->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
</head>

<body>
  <div id = "header">
    <nav class="navbar navbar-default">
      <div class="container-fluid"> 
    
        <a class="navbar-brand" href="#">
        <!--<img alt="PantryPal Logo Goes Here" src="..."> -->
        PantryPal Logo Goes Here
       </a>
    
        <?php
          session_start();
    
          $user_welcome = ' (Guest)';
        
          //If logged in
          
          if(isset($_SESSION['login_success']))
          {
            $user_welcome = $_SESSION['firstname'];
          
                    //welcome and sign out links
          echo '<p class="navbar-text navbar-right">'.
               'Hi '.$user_welcome; 
          echo '! |<a href="logout.php" class="navbar-link">Logout</a></p>';
          
            
            echo  '<ul class="nav navbar-nav navbar-right">' .
              '<li class="active"><a href="dashboard.php">Home</a></li>'.
              '<li><a href="recipes.php">Recipes</a></li>'.
              '<li><a href="mealplan.php">Meal Plan</a></li>' .
              '<li><a href="mylist.php">My List</a></li></ul>' ;
          }
           
          //not logged in
          
          else {
            
            // login or register links
            echo '<p class="navbar-text navbar-right">'.
               '<a href="login.php" class="navbar-link">Login</a>';
            echo ' |<a href="registeruser.php" class="navbar-link">Register</a></p>';
          
          
            echo '<ul class="nav navbar-nav navbar-right">' .
            '<li class="active"><a href="index.php">Home</a></li>'.
            '<li><a href="login.php">Recipes</a></li>'.
            '<li><a href="login.php">Meal Plan</a></li>' .
            '<li><a href="login.php">My List</a></li></ul>' ;
          }
          
          ?>
      </div>
    </nav>  
  </div>
</body>
</html>



