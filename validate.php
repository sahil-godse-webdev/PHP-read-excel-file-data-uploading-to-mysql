<?php
	$name= $_REQUEST['fname'];
	$pwd= $_REQUEST['pswd'];

		$con= mysqli_connect('localhost','root','','test');
		$q= "select * from my_users where full_name= '$name' and password= '$pwd'";
		$res=mysqli_query($con,$q);

	    if(mysqli_num_rows($res)>0){
	    	session_start();
	    	$_SESSION['name']= $name;
	        header('location: http://localhost/test_session/dashboard.php');
	    }
	    else{
	    	header("location: http://localhost/test_session/index.php?activity=invalid");
	    }
	

?>