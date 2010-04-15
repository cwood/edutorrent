<?php
//Session Start and make sure user is logged in//
session_start();

	include ("../htmlphp/chkSession");
	
	if($_SESSION['main_group']==students){
		Die("You are not allowed on this page.");
	}

//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
include ("db.php");
$nClass = ($_POST['class_name']);
$userID = $_SESSION['uid'];
//##############################################################################//
//							Start Main PHP Code									//
 if (chkClassMade()==1){
 		if (rmClass()==1){
 				rmUsersClass();
 				rmFiles($nClass);
 				rmFileR($nClass);
 		}
 	 }

//*******************************************************************************//
//							Functions start										 //

//_______________________________________________________________________chkTable
//cheaks to see if a table is all rady made with that class system.
function chkClassMade(){
		
		global $dbLink, $nClass, $userID;
		
		$chkSQL= "SELECT `c_id`, `t_uid` FROM classes WHERE c_id='$nClass' && t_uid='$userID'";
		$cur = mysqli_num_rows($dbLink->query($chkSQL));	

					if($cur==1){
							return 1;
					}
					elseif($cur==0) {
							$_SESSION['error_message'] = 'Your class is not in the system.';
							header("Location: ../teach_panel.php");
					}
					else{
							$_SESSION['error_message'] = 'Something went wrong.';
							header("Location: ../teach_panel.php");
					}

}
//_______________________________________________________________________rmClass();
//This will remove the class from the system.
function rmClass(){

	global $nClass, $dbLink, $userID;
	
	$rmClass = "DELETE FROM classes WHERE c_id='$nClass'";
	
	if(!$dbLink->query($rmClass)){
			$_SESSION['error_message'] = 'Could not remove the class';
			header("Location: ../teach_panel.php");
	}
	else{
			return 1;
	}
}
//_______________________________________________________________________rmUsersClass();
//removes users from the class
function rmUsersClass(){
	global $nClass, $dbLink, $userID;
	
	$rmStudents = "DELETE FROM registrar WHERE c_id='$nClass'";
		
	if(!$dbLink->query($rmStudents)){
			$_SESSION['error_message'] = 'Could not students';
			header("Location: ../teach_panel.php");
			
	}
}
//_______________________________________________________________________rmUsersClass();
//removes users from the class
function rmFiles($class){
	global $dbLink;
	
	$rmClass = "SELECT fid FROM file_registrar WHERE c_id='$class'";
	
	if($getfid = $dbLink->query($rmClass)){
		while($getfidA = $getfid->fetch_assoc()){
			foreach($getfidA as $fid){
					$rmFiles = "DELETE FROM edu_files WHERE fid='$fid'";
						if(!$rmFID = $dbLink->query($rmFiles)){
										$_SESSION['error_message'] = sprintf('Could not delete %s from %s', $fid, $class);
										header("Location: ../teach_panel.php");						
				}
			}
		}
	}
}
//_______________________________________________________________________rmUsersClass();
//removes users from the class
function rmFileR($class){

	global $dbLink;

	$rmClass = "DELETE FROM file_registrar WHERE c_id='$class'";
	
	if(!$dbLink->query($rmClass)){
			$_SESSION['error_message'] = 'Could not remove the class from the file registrar';
			header("Location: ../teach_panel.php");
			
	}
	else{
			$_SESSION['error_message'] = 'Your class as been removed successfully.';
			header("Location : ../teach_panel.php");
	}
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();