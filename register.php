<!DOCTYPE html>
<html>
	<head>
		<title>Registration|Login</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="style.css">

		<script type="text/javascript">
			$(document).ready(function(){
			    $("#msg").show();
			});
		</script>
	</head>
	<body>
		<div class="container">
			<form name="myForm" class="text-center p-5" method="POST" action="registerdata.php" autocomplete="off" onsubmit="return validateForm()">

				<h1 class="h1 mb-5 text-black">Sign up</h1>
				<p>
					<input type="text" class="form-control mb-4" name="fname" placeholder="User name" required>
				</p>
				<p>
					<input type="password" name="pswd" class="form-control mb-4" placeholder="Password" required>
				</p>
				<p>
				    <button class="btn btn-info btn-block my-4" type="submit">Sign up</button>
				</p>
					    
				    <!-- login -->

				    <p class="text-black">Already a member?
				        <a href="index.php">Login</a>
				    </p>
					
					<?php
						if(isset($_REQUEST['activity'])){
							if ($_REQUEST['activity']=='already_present') {
								?>
									<p id="msg" style="color: red;">
										Username already present try with other name
									</p>
								<?php
							}
							elseif ($_REQUEST['activity']=='redirect') {
								?>
									<p style="color: green;">User registered successfully</p>
									<p style="color: green;" id="redirect">
										<b>Redirecting to login ...</b>
									</p>
								<?php
								header( "refresh:7; url=http://localhost/test_session/index.php"); 
							}
							elseif ($_REQUEST['activity']=='validate') {
								?>
									<p id="msg" style="color: red;">
										Username must be atleast 2 characters and password must be atleast 6 characters
									</p>
								<?php
							}
						}
					?>

			</form>
				<!-- Default form login -->			
		</div>	
		<script type="text/javascript">
			function validateForm() {
			  var x = document.forms["myForm"]["fname"].value;
			  if (x.length <2) {
			    alert("Name must be atleast 2 characters");
			    return false;
			  }
			  var y = document.forms["myForm"]["pswd"].value;
			  if (y.length <6) {
			    alert("Password must be atleast 6 characters");
			    return false;
			  }
			}
		</script>
	</body>
</html>
