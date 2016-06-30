<!DOCTYPE html>
<html lang="en">

<head>
   <title> Add ingredients </title>
</head>

<body>
 
<?php 

// Connection to DB and iterating through to get ingredient items

include("config.php"); 
include("recursiveIterator.php")

$query = $db->prepare("SELECT mainIngredients FROM Ingredient WHERE recipeNumber = 1)
               VALUES (:mainIngredients)");

//$ingredients ->bindParam('mainIngredients', $ingredient);

$query->execute();

$result = $query->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
    }


echo "<table>";
echo "<tr>
         <th>Ingredient</th><th></th>
      </tr>";




?>
   
</body>

</html>