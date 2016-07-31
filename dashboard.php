<!--Version control
Jane Geard 12/07/2016: Align footer with sidebar and main content

<!DOCTYPE html>
<?php
//adds the header
$current = 'home';
include "header.php";

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
       <?php include_once "sidebar.php"; ?>
      <div class = "container">
         
       <!--  <h1><?php echo 'Welcome '.$_SESSION['login_success']; ?> </h1> added to the header-->
       <h2><a href = "session_dump.php">View Session</a></h2>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h2><a href="luketest_singlerecipe.php">Luke's test area for single recipe page</a></h2>
   
      </div>
      
      <?php
      include_once "footer.php";
      ?>
</body>
</html>