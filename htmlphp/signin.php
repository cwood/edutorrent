<?php 
		session_start();
		if ($_SESSION['login']==TRUE){
				printf("Hello %s, You are logged in", $_SESSION['name']);
		}
		else{
				printf('Sign In');
		}
?>