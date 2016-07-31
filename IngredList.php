<!DOCTYPE html>
<?php session_start?>
<head>
   <title> Add ingredients </title>
</head>

<body>

<?php 
   include_once("header.php");
   include_once("sidebar.php");
   include("config.php"); 
   include("recursiveIterator.php");

// Displaying POST results for selected ingredients   
echo "<div class = 'col-sm-8'>";
   if (isset($_POST['addIngredients'])){
      if (!empty ($_POST['list']))
      {
         $checked_count = count($_POST['list']);
         echo "<br/><h4><b>You have selected following ".$checked_count." option(s): 
                           </b></h4><br/><br/>";
         
         foreach($_POST['list'] as $selected) 
         {
            echo "<p>".$selected ."</p>";
         }

      }
   }

?>
<!-- Buttons for Print and Email -->
   <input type='submit' value='Print'></input>
   <input type='submit' value='Email'></input>

  </div>
</body>

<?php include_once("footer.php"); ?>

</html>