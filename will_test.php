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
?>

<h3>My List</h3>
<p></p


<form action="submit_list.php" method="post">

<table style="width:30%">
   <tr>
      <th>Ingredient</th>
      <th>Add to List</th>
      <th>Amount</th>
   </tr>

<?php 
$i = 0;
               // have hard coded date selection in, need to get this to accept a parameter from SESSION
foreach ($db->query("SELECT mainIngredients FROM ingredient WHERE recipeNumber IN 
                        (SELECT recipeNumber FROM meal_planner WHERE mealDate = '2016-06-29')") as $row)
                     {
                        echo '<tr>';
                           $ingredient = $row ['mainIngredients'];
                           echo "<td>$ingredient</td>";
                           echo "<td><input type='checkbox' name = 'list[]'value = $i></input></td>";
                           echo "<td><input type ='text' value=0 size =4></input></td>";
                        echo '</tr>';
                        $i++;
                     }
                     
                     

?>
                     <tr>
                        <td> </td>
                        <td> </td>
                        <td>-</td>
                     </tr>
                     <tr>
                        <td></td>
                        <td></td>
                        <td><input type = "submit" name = "addIngredients" id = "add" value = "Add to list">
                        </input></td>
                     </tr>

</table>

</form>   
</body>

</html>