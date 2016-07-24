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
  <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
	 
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $( "#anim" ).change(function() {
      $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  });
  </script>
  
  <?php
		
		include("config.php");
      
      //adds the iterator to build the ingredient and recipe table
      include_once("recursiveIterator.php");
		
		//declare the recipeID number from the search results
		$rid = $_GET['rid'];
		
	?>
	
</head>


	

<body>


<form action="singlerecipe.php" method="get">
Recipe number: <input type="text" name="rid"><br>
<input type="submit">
</form>

</body>
</html>

	<!-- SINGLERECIPE CONTENTS END HERE -------------------------------------------------------------------------------------- -->
		
			
	<!-- Footer -->
			
		
	<!-- End Footer -->
	
	</body>
	
</html>