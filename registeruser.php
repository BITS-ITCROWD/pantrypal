<!--
Version Control:
Jane Geard 19/07/2016: Created basic sign up page
Jane Geard 20/07/2016: Insert details to users table 
Included check on that confirm password matches password and form does
not lose previously entered details.
Added a check that the username does not already exist in the database

-->

<!DOCTYPE html>
<?php
   include("config.php");
   //adds the header
   include_once "header.php";
   
   session_start();



if(isset($_POST['submit']))
{
   $errMsg = "";
   
   $username = trim($_POST['username']);
   $password = trim($_POST['password']);
   $firstname = trim($_POST['firstname']);
   $lastname = trim($_POST['lastname']);
   $confirmpassword = trim($_POST['confirmpassword']);
   
   
   //check if password and confirm password match
   if ($password !== $confirmpassword) {
      $errMsg .= "Passwords do not match";
      }
      
      //check username does not already exist
         
      else {
   
         $records = $db->prepare('SELECT * FROM users WHERE username = :username');
			$records->bindParam(':username', $username);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			if($results > 0){
				$errMsg .= "User already exists";
				
			}
      
            else 
         
            {
            //add user to users table
            
            $sql = $db->prepare('INSERT INTO users(username, password, firstname, lastname) VALUES(:username,:password,:firstname, :lastname)');
            $sql->bindParam(':username', $username);
            $sql->bindParam(':password', $password);
            $sql->bindParam(':firstname', $firstname);
            $sql->bindParam(':lastname', $lastname);
            $sql->execute();
            
            $_SESSION['login_success'] = $username;
            $_SESSION['firstname'] = $firstname;
				header('location:dashboard.php');
				exit;
            
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
	  		<h2>Register New User</h2>
      
      
      <div class="col-md-4 col-md-offset-4">
	
		      	<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
						}
					?>
					<!--form to register sign up details-->
				<form action = "" method="post">
		    	  <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $firstname;?>" required></br>
		    	  <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lastname;?>"  required></br>
		    	  <input type="email" class="form-control" placeholder="Email Address" name="username" value="<?php echo $username;?>" required></br>
		    	  <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password;?>"  required></br>
		    	  <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpassword" required></br>
		        <button type="submit" class="btn btn-primary" name='submit'>Register</button>
				</form>
      </div>
   </div>
   </div>
 </body>
<?php
include_once "footer.php";
?>
</html>

