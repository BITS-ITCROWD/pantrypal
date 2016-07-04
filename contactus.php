<!DOCTYPE html>

<html lang="en">
   
<?php

   include("config.php");
   
   //Add header
   include_once "header.php";
   
?>

<head>
   <title>Contact Us</title>
</head>

<body>
   <div class="container">
      <div class="col-sm-12" >
         <h1>Contact Us</h1>
      </div>
      <!-- Email - LHS-->
      <div id=""class="col-sm-6">
         <p>Email:</p>
         <p>admin@pantrypal.com.au</p>
         <br>
         <p>Or use our contact form and we will contact you</p>
      </div>
      <!-- Contact Form - RHS-->
      <div class="col-sm-6">
         <!-- Code for contact form adapted from 
         https://bootstrapbay.com/blog/working-bootstrap-contact-form/ -->
         <form class="form-horizontal" role="form" method="post" action="contactus.php">
	         <div class="form-group">
		         <label for="name" class="col-sm-2 control-label">Name</label>
		         <div class="col-sm-10">
			         <input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="">
		         </div>
	         </div>
	         <div class="form-group">
		         <label for="email" class="col-sm-2 control-label">Email</label>
		         <div class="col-sm-10">
         			<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
         		</div>
         	</div>
         	<div class="form-group">
         		<label for="message" class="col-sm-2 control-label">Message</label>
         		<div class="col-sm-10">
         			<textarea class="form-control" rows="4" name="message"></textarea>
         		</div>
         	</div>
         	<div class="form-group">
         		<label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
         		<div class="col-sm-10">
         			<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
         		</div>
         	</div>
         	<div class="form-group">
         		<div class="col-sm-10 col-sm-offset-2">
         			<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
         		</div>
         	</div>
         	<div class="form-group">
         		<div class="col-sm-10 col-sm-offset-2">
         			<! Will be used to display an alert to the user>
         		</div>
         	</div>
         </form>
      </div>
   </div>
   
   <?php 
   // Add footer
   include_once "footer.php";
   ?>
</body>

</html>