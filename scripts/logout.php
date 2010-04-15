<?php
	session_start();
	echo "You have been logged out.";
	$_SESSION = array();
	session_destroy();
	header("Location: ../index.php")
?>