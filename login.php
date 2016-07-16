<!--
Version Control:
Jane Geard 12/07/2016: Created basic login page
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
			$records = $db->prepare('SELECT * FROM users WHERE username = :demo AND password =:demo');
			$records->bindParam(':demo', $username);
			$records->bindParam(':demo', $password);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			if($results > 0){
				$_SESSION['login_success'] = $results['username'];
				$_SESSION['login_userid'] = $results['ID'];
				header('location:dashboard.php');
				exit;
			}else{
				$errMsg .= 'Username and Password are not found<br>';
			}
		}
	}
?>
<html>
<head><title>Login</title>

</head>

<body>
   <!-- Welcome message-->
	<div class="jumbotron">
		<div class="container text-center">
	  		<h2>Enter your login details</h2>
      
      
      <div class="col-md-4 col-md-offset-4">
	
		      	<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
						}
					?>
					
   			<form action ="" method ="post">
		    	  <input type="text" class="form-control" placeholder="Username" name="username" required></br>
		        <input type="password" class="form-control" placeholder="Password" name="password" required></br>
		        <button type="submit" class="btn btn-primary" name='submit'>Sign In</button>
				</form>
      </div>
   </div>
   </div>
 </body>
<?php
include_once "footer.php";
?>
</html>

