<!DOCTYPE html>
<?php session_start?>
<head>
   <title> Add ingredients </title>
   <style type="text/css">
      #button1{
         display: inline-block;
         font-weight: bold;
      }
      #button2{
         display: inline-block;
         font-weight: bold;
      }
   </style>
   
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript">
      function printAlert(){
         alert("Your shopping list has been printed");
      }
      
      function emailAlert(){
         alert("Your shopping list has been emailed");
      }
   </script>

</head>

<body>
<div>
<?php 
   include_once("header.php");
   
   include("config.php"); 
   include("recursiveIterator.php");

// Displaying POST results for selected ingredients   
echo "<div class = 'container'>"; //added by Jane to fix the footer issue

   include_once("sidebar.php"); //Jane moving sidebar within main content container

echo "<div class = 'col-sm-9'>";
   if (isset($_POST['addIngredients'])){
      if (!empty ($_POST['list']))
      {
         $checked_count = count($_POST['list']);
         echo "<br/><h4><b>You have selected following ".$checked_count." Ingredient(s): 
                           </b></h4><br/><br/>";
         // Buttons for Print and Email
   echo "<input class= 'button1' type='submit' value='Print' onclick='printAlert()'>      
         </input>  ";
   echo "<input class= 'button2' type='submit' value='Email' onclick='emailAlert()'>
         </input>";
         
         foreach($_POST['list'] as $selected) 
         {
            echo "<p>".$selected ."</p>";
         }

      }
   }
   echo "</div>";
   echo "</div>"; // close container (added by Jane to fix footer)
?>
      
  </div>
  <div>
     <?php include_once("footer.php"); ?>
  </div>
</body>


</html>