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
  
<!--header.php-->
<head>
    
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    
    <!--link to Bootstrap css stylesheets-->
  <link href="css/bootstrap.min.css" rel="stylesheet">; 
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">;
  
  <?php
		
		include("config.php");
      
      //adds the iterator to build the ingredient and recipe table
      include_once("recursiveIterator.php");
		
	?>
	
</head>

<body>
 

<?php

$sth = $db->prepare("SELECT ingredient from ingredient where recipeNumber = 2");
$sth->execute();

/* Fetch all of the remaining rows in the result set */
print("Fetch all of the remaining rows in the result set:\n");
$res = $sth->fetchAll();

//create an array
$shoppingList = array();

$_SESSION['ingredient'] = $shoppinglist;

$ingredientsDisplay = "";
$i = 0;

foreach ($_SESSION['ingredient'] as $each_item)
{
   $item = $each_item['ingredient'];
   
   $ingredientsDisplay .= '<tr>';
   $ingredientsDisplay .= '<td>' . $item . '</td>';
   $ingredientsDisplay .= '</tr>';

   $i++;
   
}

echo '<table width="100%" border="1" cellspacing="0" cellpadding="10">';
echo '<tr>';
echo '<td width="30%" bgcolor="#dde0e4"><strong>Ingredient</strong></td>';
echo '</tr> '; 

echo '$ingredientsDisplay';

?>
   
</body>

</html>