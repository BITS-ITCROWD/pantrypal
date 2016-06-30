<!DOCTYPE html>
<?php
//adds the header
include_once "header.php";
include_once "sidebar.php";
session_start();
if(!isset($_SESSION['login_success'])){ //if login in session is not set
    header("Location: index.php");
}
?>
<html>
   
   <head>
      <title>Home | Dashboard</title>
   </head>
   
   <body>
    <!--  <h1><?php echo 'Welcome '.$_SESSION['login_success']; ?> </h1> added to the header-->
       <h2><a href = "session_dump.php">View Session</a></h2>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h2><a href="luketemp_testpage.php">Luke's test area for single recipe page</a></h2>
   </body>

<?php
include_once "footer.php";
?>
</html>