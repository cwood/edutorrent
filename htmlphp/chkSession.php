<?php
session_start();
if($_SESSION['login']!='true'){

	echo $_SESSION['login'];
	echo $_SESSION['uid'];
	echo $_SESSION['main_group'];
	die("Failed to login");
}

?>