<!--
Version Control:
Jane Geard 12/07/2016: Created basic login page
Jane Geard 20/07/2016: Enable login with new user
Jane Geard 15/08/2016: Added references / sources for code
-->

<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   
   session_start();
 // this is a copy of the index code - would be better to store separately  
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
				header('location:index.php');
				exit;
			}else{
				$errMsg .= 'Username and Password are not found';
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
      
      <!--http://stackoverflow.com/questions/20853066/how-to-center-form-in-bootstrap-3-->
      <div class="col-md-4 col-md-offset-4">
	
					<!--change of colour and font error message taken from Byron's original login code-->
		      	<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
						}
					?>
					
					<!--http://www.w3schools.com/bootstrap/bootstrap_forms.asp-->
   			<form action ="" method ="post">
		    	  <input type="email" class="form-control" placeholder="Email" name="username" required></br>
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

