<?php
//Varable Headings

	if($_SESSION['main_group']==students OR $_SESSION['main_group']==teachers){
		Die("You are not allowed on this page.");
	}
//_______________________________________Globals
$uName = addslashes($_POST["username"]);
$pWord = md5($_POST["password"]);
$name	= ($_POST["name"]);
$main_group = addslashes($_POST["group"]);
//MYSQL Information
include ("db.php");
//____________________Querys to insert the users into the database
$addUser = ("INSERT into users (`username`,`name`, `password`, `main_group`) VALUES ('$uName', '$name', '$pWord', '$main_group')");
$chUser = ("SELECT username FROM users WHERE username='$uName'");

//Checks to see if another user is in the system all ready.
$chkUser = mysqli_num_rows($dbLink->query($chUser));

		$TorQueR=$dbLink->query("SHOW TABLE STATUS LIKE 'users'");
		$row=$TorQueR->fetch_array();
		$n_Incrment = $row['Auto_increment'];
		
if($chkUser !=0){
			$_SESSION['error_message'] = sprintf('Failed to add:%s for web site use.The user all ready exists ', $name);
			header("Location: ../admin.php");	}

else{
		if($dbLink->query($addUser) == TRUE){
			if ($dbLink->query("INSERT INTO xbt_users (uid) VALUES ('$n_Incrment')") == TRUE){
			$_SESSION['error_message'] = sprintf('Added:%s for web site use.', $name);
			header("Location: ../admin.php");	
		}
			
	}
}

$dbLink->close();
?>
