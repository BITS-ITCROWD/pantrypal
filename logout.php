<!DOCTYPE html>
<?php
   session_start();
   
   if(session_destroy()) {
      header( "refresh:7; url=index.php" ); 
   }
   
   //Add header
   include_once "header.php";
?>
<head>
   <title>Logout</title>
</head>

   <body>
      
   
      <div class="container"> 
         
         <?php include_once "sidebar.php"; ?> <!--jane including the sidebar 
                                             in the main content container-->
         
         <div class="col-sm-10" >
            <h1>You have been logged out</h1>
            <h3>Click <a href="login.php">here to log in</a> or wait to be returned to the Welcome page</h3>
            
         </div>
      </div>
      <?php include_once "footer.php"; ?>
   </body>

</html>