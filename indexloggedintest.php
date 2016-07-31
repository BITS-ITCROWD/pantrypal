<!DOCTYPE html>

<html lang="en">
   

<?php
     
   include("config.php");
   
   //Add header
   include_once "header.php";
   

?>

<head>
   <link href="css/mark.css" rel="stylesheet">
   <title>Welcome To PantryPal</title>
</head>

<body>
   <?php include_once "sidebar.php"; ?>
   
   <div class="container">  <!-- Container for the whole content section -->
      <div id="main-content" class="col-sm-9" >
         <h2>Hi Quinto(set up function to call name later)</h2>
         <h1>Welcome to PantryPal</h1>
         <h3>It's as easy as...</h3>
         
         <div id="stepsContent">  <!-- This div contains the steps -->
            <div id="stepOne" class="steps">
               <div id="stepNumber">
                  <img src="/images/numberOne.png">
               </div>
               <div id="stepInstructions">
                  
               </div>
            </div>
            <div id="stepTwo" class="steps">
               <div id="stepNumber">
                  
               </div>
               <div id="stepInstructions">
                  
               </div>
            </div>
            <div id="stepThree" class="steps">
               <div id="stepNumber">
                  
               </div>
               <div id="stepInstructions">
                  
               </div>
            </div>
         </div>
      </div>
   </div>
   
   <?php include_once "footer.php"; ?>
</body>

</html>