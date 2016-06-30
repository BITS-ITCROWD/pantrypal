<!DOCTYPE html>

<html lang="en">


	<?php
	
	   include("config.php");
      //adds the header
      include_once "header.php";
		
		session_start();
		$_SESSION["rid"] = $rid;
				
	?>

<body>
	
	<!-- Header -->
	

	
	<!-- End Header -->
	
	<!-- Side Bar -->
			

	
	<!-- SINGLERECIPE TESTER GO HERE -------------------------------------------------------------------------------------- -->

		<form method="get" action="singlerecipe.php">
		    <input type="text" name="rid" value="">
		    <input type="submit">
		</form>
	
	<!-- SINGLERECIPE TESTER END HERE -------------------------------------------------------------------------------------- -->
		
	<!-- End Side Bar -->


			
	<!-- Footer -->
			
		
	<!-- End Footer -->

	</body>
</html>