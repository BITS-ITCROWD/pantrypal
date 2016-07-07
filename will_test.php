<!DOCTYPE html>
<?php session_start?>
<head>
   <title> Add ingredients </title>
</head>

<body>

<?php 
   include_once("header.php");
   include("config.php"); 
   include("recursiveIterator.php");
?>

<h3>Ingridents Shopping List</h3>
<p></p


<form action="submit_list.php" method="post">

<table style="width:30%">
   <tr>
      <th>Ingredient</th>
      <th>Add to List</th>
   </tr>

<?php 

foreach ($db->query("SELECT mainIngredients FROM ingredient WHERE recipeNumber IN 
                        (SELECT recipeNumber FROM meal_planner WHERE mealDate = '2016-06-29')") as $row)
                     {
                        echo '<tr>';
                           $ingredient = $row ['mainIngredients'];
                           echo "<td>$ingredient</td>";
                           echo "<td><input type='checkbox' value = $ingredient></input></td>";
                        echo '</tr>';
                     }

?>

</table>

</form>   
</body>

</html>