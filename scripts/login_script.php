<?php
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
include("db.php");
session_start();
$uName  = mysql_real_escape_string($_POST["username"]);
$pWord  = md5($_POST["password"]);
$ok==0;
//##############################################################################//
//							Start Main PHP Code									//

$ok = chUsername($uName, $pWord);

if ($ok==1){
		$main_group==SessionSt();
		header("Location: ../index.php");
}
else{
							$_SESSION['error_message'] = 'Your username and password is incorrect';
							header("Location: ../login.php");
}
//*******************************************************************************//
//							Functions start										 //


//_______________________________________________________________________chUserName
//Grab username and password and verify from the database
function chUsername($user, $pass){
	
	global $dbLink;
	
	$uNameCh = "SELECT `username`, `password` FROM users WHERE username='$user' AND password='$pass'";

	if($res = $dbLink->query($uNameCh)){
		$row_count = $res->num_rows;
		
					if($row_count==1){
							return 1;
					}
					else{
							$_SESSION['error_message'] = 'Your username and password is incorrect';
							header("Location: ../login.php");
					}
			$res->close();	
	}
	else{
							$_SESSION['error_message'] = 'Your username and password is incorrect';
							header("Location: ../login.php");
	}
}

//_______________________________________________________________________SessionSt
//Start session if verify is ok
function SessionSt(){

	global $dbLink, $uName, $pWord;
	
	$TemPuid = ("SELECT * FROM users WHERE username='$uName'");
	
	if ($tUid = $dbLink->query($TemPuid)){
			while ($Tuid = $tUid->fetch_row()){
				$uid          = $Tuid[0];
				$userName     = $Tuid[1];
				$name 	  	  = $Tuid[2];
				$main_group	  = $Tuid[5];		
			}
			
		$tUid->close();
	}
	
	$_SESSION['uid']=$uid;
	$_SESSION['username']=$userName;
	$_SESSION['main_group']=$main_group;
	$_SESSION['name']=$name;
	$_SESSION['login']=TRUE;
	$_SESSION['error_message']="";


	return $main_group;
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>
