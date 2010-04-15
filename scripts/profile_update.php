<?php
//*******************Database Information
include ("db.php");
//*******************Session Start
session_start();
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //

$password1 = ($_POST["Password1"]);
$password2 = ($_POST["Password2"]);
$uid = ($_SESSION['uid']);
$func = ($_GET['func_id']);
//##############################################################################//
//							Start Main PHP Code									//
switch($func){
	case "Password":
						if (chkPassword()==1){
								updatePassword($password1);
						}
				break;
	case "update_avatar":
						
				break;
}//end of switch
//*******************************************************************************//
//							Functions start										 //

//_______________________________________________________________________chkPassword()
//Checks user passwords in the form.
function chkPassword(){
	
	global $password1, $password2;
	
	if(!isset($password1) OR !isset($password2)){
		$_SESSION['error_message'] = "Passwords were left blank.";
		header("Location: ../profile.php");
		
	}
		else{
				if ($password1 == $password2){
						return 1;
				}
				
				else {
						$_SESSION['error_message'] = "Your passwords dont match";
						header("Location: ../profile.php");
					}
	}
}
//_______________________________________________________________________updatePassword()
//Updates password in the database
function updatePassword($password){
	global $dbLink, $uid;
	
	$EncPass = md5($password);

	$updateQ = "UPDATE users SET password='$EncPass' WHERE uid='$uid'";
	
	if(!$dbLink->query($updateQ)){
			$_SESSION['error_message'] = "Your password could not be updated";
						header("Location: ../profile.php");
	}
	else {
			$_SESSION['error_message'] = "Your password was updated succesfully.";
						header("Location: ../profile.php");

	}
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>