<!--
Version Control:
Jane Geard 30/06/2016: Added a welcome section with text. 
Amended the format of the login and added register button. Still more work to
do on layout.
Jane Geard 20/07/2016: Modified to store firstname variable and changed :demo
-->

<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   
   session_start();
   
 if(isset($_POST['submit'])){
		$errMsg = '';
		//username and password sent from Form
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($username == '')
			$errMsg .= 'You must enter your Username<br>';
		
		if($password == '')
			$errMsg .= 'You must enter your Password<br>';
		
		
		if($errMsg == ''){
			$records = $db->prepare('SELECT * FROM users WHERE username = :username AND password =:password');
			$records->bindParam(':username', $username);
			$records->bindParam(':password', $password);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			if($results > 0){
				$_SESSION['login_success'] = $results['username'];
				$_SESSION['login_userid'] = $results['ID'];
				$_SESSION['firstname'] = $results['firstname'];
				header('location:dashboard.php');
				exit;
			}else{
				$errMsg .= 'Username and Password are not found<br>';
			}
		}
	}
?>
<html>
<head><title>Welcome Page - Logged Out</title>

</head>

<body>
	<!-- Welcome message-->
	<div class="jumbotron">
		<div class="container text-center">
	  		<h1>Welcome to PantryPal</h1>
  			<p>PantryPal allows you to select from a wide range of recipes to build 
  			a meal plan for your weekly shop. It adds the ingredients required to a
  			shopping list that can be viewed online, printed or emailed. The list is 
  			updated each time a recipe is added to your meal plan so that the final
  			list shows the ingredients required. You can amend or delete ingredients
  			that may already exist in your pantry, simplifying your weekly shop.
  			You can also add favourites so that you do not have to search for the
  			same recipes each week.</p>
  			<h2>Why not give it a go?</h2>
  		</div>
  	</div>

	<div class="container">
		    <!--Row with two equal columns-->
     <div class="row">
        <div class="col-xs-6 form-group"><!--Column left-->
		      	
		      	<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
						}
					?>
					
   			<form action ="" method ="post">
		    	  <input type="email" class="form-control" placeholder="Email" name="username" required></br>
		        <input type="password" class="form-control" placeholder="Password" name="password" required></br>
		        <button type="submit" class="btn btn-primary" name='submit'>Sign In</button>
				</form>
    		</div>
 
   	<div class="col-xs-6 form-group"><!--Column right-->
 	   	<h2>Don't have a PantryPal Account?
  			<a class="btn btn-primary" href="registeruser.php" role="button">Register here</a>
  			</h2>
  		</div>
    </div>
	</div>
</body>
<?php
include_once "footer.php";
?>
</html>