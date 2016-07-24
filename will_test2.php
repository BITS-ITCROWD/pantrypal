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
   
   print_r ($_SESSION ['requiredIngredients']);



?>

  
</body>

</html>