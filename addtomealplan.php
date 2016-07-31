<?php

include("config.php");

session_start();

$userID = $_SESSION["login_userid"];
$rid = $_SESSION["rid"];

$meal = $_POST["meal"];
$date = $_POST["datepicker"];
$usernote = 'NULL';

/*      Luke - I would test one variable at a time in the hard code.   
$sql = $db->prepare("INSERT INTO meal_planner (userID, mealDate, mealTime, recipeNumber, userNote) VALUES(:userid, :mealDate, :mealTime, :rid, :userNote)");
$sql->bindParam(':userid', $userID);
$sql->bindParam(':mealDate', $meal);
$sql->bindParam(':mealTime', $meal);
$sql->bindParam(':rid', $rid);
$sql->bindParam(':userNote', $usernote);
*/
$sql = $db->prepare("INSERT INTO meal_planner (entryID, userID, mealDate, mealTime, recipeNumber, userNote) VALUES (NULL, :userid, :mealDate, :mealTime, :rid, :userNote)");
$sql->bindParam(':userid', $userID);
$sql->bindParam(':rid', $rid);
$sql->bindParam(':mealDate', $date);
$sql->bindParam(':mealTime', $meal);
$sql->bindParam(':userNote', $usernote);

$sql->execute();

?>