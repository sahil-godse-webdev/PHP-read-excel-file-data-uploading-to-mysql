<?php
	$name= $_REQUEST['fname'];
	$pwd= $_REQUEST['pswd'];

	if (strlen($name)<2 or strlen($pwd)<6) {
		header('location: http://localhost/test_session/register.php?activity=validate');
	}
	else{
		$con= mysqli_connect('localhost','root','','test');
		$q= "select * from my_users where full_name= '$name'";
		$res=mysqli_query($con,$q);

	    if(mysqli_num_rows($res)>0){
	        header('location: http://localhost/test_session/register.php?activity=already_present');
	    }
	    else{
	    	$q1="insert into my_users(full_name,password,created_by,is_admin)values('$name','$pwd','1','true')";
		    mysqli_query($con,$q1);
		    header("location: http://localhost/test_session/register.php?activity=redirect");
	    }
	}

?>