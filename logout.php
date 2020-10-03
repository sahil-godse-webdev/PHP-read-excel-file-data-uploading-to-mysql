<?php
	header('Access-Control-Allow-Origin:*');

	session_start();
	session_destroy();
	header('location: http://localhost/test_session/index.php?activity=logged_out');
?>