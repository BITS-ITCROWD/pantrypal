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
   
   $_SESSION['requiredIngredients'] = array();
   
   foreach()
   {
      if checked
      (
          requiredIngrdients => 
         )
   }
?>

<form action="will_test2.php" method="post">

<h3>My List</h3>
<p></p>

<table style="width:30%">
   <tr>
      <th>Add to List</th>
      <th>Ingredient</th>
      <th><input type = "submit" name = "addIngredients" id = "add" value = "Save and Email"></input></th>
   </tr>

<?php 
$i = 0;
               // have hard coded date selection in, need to get this to accept a parameter from SESSION
foreach ($db->query("SELECT ingredient FROM ingredient WHERE recipeNumber IN 
                        (SELECT recipeNumber FROM meal_planner WHERE mealDate = '2016-06-29')") as $row)
                     {
                        echo '<tr>';
                           $ingredient = $row ['ingredient'];
                           echo "<td><input type='checkbox' name = 'list[]'value = $i></input></td>";
                           echo "<td>$ingredient</td>";
                        echo '</tr>';
                        $_SESSION['requiredIngredients'][$i] = ($_POST['ingred'] = $ingredient);
                        $i++;
                     }
                     

?>
                     <tr>
                        <td> </td>
                        <td> </td>
                     </tr>
                     <tr>
                        <td></td>
                        <td></td>
                     </tr>

</table>

</form>   
</body>

</html>