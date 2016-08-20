<?php

//by Luke - all of my own code

include("config.php");

session_start();

$userID = $_SESSION['login_userid'];
$rid = $_SESSION['rid'];

$date = $_POST['datepicker'];
$time = $_POST['meal'];

$usernote = 'NULL';


$sql = $db->prepare("INSERT INTO meal_planner (entryID, userID, mealDate, mealTime, recipeNumber, userNote) VALUES (NULL, :userid, :mealDate, :time, :rid, :userNote)");
$sql->bindParam(':userid', $userID);
$sql->bindParam(':rid', $rid);
$sql->bindParam(':mealDate', $date);
$sql->bindParam(':time', $time);
$sql->bindParam(':userNote', $usernote);

$sql->execute();

?>