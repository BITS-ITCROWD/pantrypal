<!DOCTYPE html>
<html lang="en">
<?php session_start?>;
<head>
   <title> Add ingredients </title>
</head>

<body>
 
<?php 

// Connection to DB and iterating through to get ingredient items

include("config.php"); 
include("recursiveIterator.php");

$query = $db->prepare("SELECT mainIngredients FROM Ingredient WHERE recipeNumber IN (SELECT recipeNumber 
                     FROM meal_planner WHERE mealDate == '2016-06-29' )
                     VALUES (:mainIngredients)");

// $ingredients ->bindParam('mainIngredients', $ingredient);

$query->execute();

$result = mysql_query($query);
$row = mysql_fetch_array($result);
$shoppingList = array();

while ($row = mysql_fetch_array($res)) 
{
   $row->qty=1;
   $shoppinglist[] = $row['ingredient'];
}

$_SESSION['ingredient'] = $shoppinglist;

$ingredientsDisplay = "";
$i = 0;

foreach ($_SESSION['ingredient'] as $each_item)
{
   $item = $each_item['ingredient'];
   $quantity = $each_item["qty"];
   
   $ingredientsDisplay .= '<tr>';
   $ingredientsDisplay .= '<td>' . $item . '</td>';
   $ingredientsDisplay .= '<td>' . $quantity . '</td>';
   $ingredientsDisplay .= '</tr>';

   $i++;
   
}

echo '<table width="100%" border="1" cellspacing="0" cellpadding="10">';
echo '<tr>';
echo '<td width="30%" bgcolor="#dde0e4"><strong>Ingredient</strong></td>';
echo '<td width="15%" bgcolor="#dde0e4"><strong>Quantity</strong></td>';
echo '</tr> '; 

echo '$ingredientsDisplay';


// $result = $query->setFetchMode(PDO::FETCH_ASSOC); 
//     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
//     }


// echo "<table>";
// echo "<tr>
//          <th>Ingredient</th><th></th>
//       </tr>";




?>
   
</body>

</html>