<?php
//*******************Database Information
include ("db.php");
//*******************Session Start
session_start();
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
$uid = $_POST["uid"];
$ok == 1;
//##############################################################################//
//							Start Main PHP Code									//
chkExist($uid);
if($ok==0){
	rmUser($uid);
}
//*******************************************************************************//
//							Functions start										 //

//_______________________________________________________________________chExist()
//Checks to make sure that the username exists and that it is valid in the database.
function chkExist($user){
	global $dbLink;
	
	$sqlChkExist = "SELECT uid FROM users WHERE uid='$user'";
	
	$dbLink->query($sqlChkExist);
	$rows = $dbLink->affected_rows;
	
	if($rows == 1){
		$ok==0;
	}
	else{
							$_SESSION['error_message'] = "The user does not exist";
							header("Location: ../admin.php");
							die();
	}
}
//_______________________________________________________________________chExist()
//Checks to make sure that the username exists and that it is valid in the database.
function rmUser($user){
	global $dbLink;
	
	$sqlgetInfo = "SELECT main_group FROM users WHERE uid='$user'";
	
	if($getInfo = $dbLink->query($sqlgetInfo)){
		while($getResult = $getInfo->fetch_assoc()){
		if($getResult['main_group'] != 'student'){
		
			$sqlSelectClass = "SELECT c_id FROM classes WHERE t_uid='$user'";
			if($SelectClass = $dbLink->query($sqlSelectClass)){
				while($ArrayClass = $SelectClass->fetch_assoc()){
					foreach($ArrayClass as $class){
						$sqlDeleteReg = "DELETE FROM registrar WHERE c_id='$class'";
						
						if(!$dbLink->query($sqlDeleteReg)){
							$_SESSION['error_message'] = "Could not delete the class";
							header("Location: ../admin.php");
							die();
						}
						$sqlSelectFiles = "SELECT fid FROM file_registrar WHERE c_id='$class'";
						
						if($getFid = $dbLink->query($sqlSelectFiles)){
							while($ArrFid = $getFid->fetch_assoc()){
								foreach($ArrFid as $fid){
									$sqlDeleteFiles = "DELETE FROM edu_files WHERE fid='$fid'";
									if(!$dbLink->query($sqlDeleteFiles)){
																$_SESSION['error_message'] = "Could not delete files";
																header("Location: ../admin.php");
																die();
									}//delete files where the fid is stated
								}//end of foreach($ArrFid
							}//end of while loop to get FID's
						}//end of if statement to select file ID's
						$sqlDeleteFReg = "DELETE FROM file_registrar WHERE c_id='$class'";
						
						if(!$dbLink->query($sqlDeleteFReg)){
																$_SESSION['error_message'] = "Could not delete from File Registrar";
																header("Location: ../admin.php");
																die();
						}
					}//end of foreach($Array
				}//end of while
			}//end of if to remove class data
			$sqlDeleteClass = "DELETE FROM classes WHERE t_uid='$user'";
			if(!$dbLink->query($sqlDeleteClass)){
																$_SESSION['error_message'] = "Could not delete from the classes table";
																header("Location: ../admin.php");
																die();
			}//end of if to remove class from the classes table	
			
			$sqlrmStudent = "DELETE FROM users WHERE uid='$user'";
			$sqlrmTorrent = "DELETE FROM `xbt_users` WHERE uid='$user'";
			if(!$dbLink->query($sqlrmStudent)){
							
			}//end of remove student if statement

			if(!$dbLink->query($sqlrmTorrent)){
							$_SESSION['error_message'] = "The user has not been deleted";
							header("Location: ../admin.php");
							die();
			}//end of remove student if statement
			else{
							$_SESSION['error_message'] = "The user has been deleted";
							header("Location: ../admin.php");
							die();
			}
			
		}
		if($getResult['main_group'] == 'student'){
			$sqlrmStudent = "DELETE FROM users WHERE uid='$user'";
			$sqlrmTorrent = "DELETE FROM `xbt_users` WHERE uid='$user'";
			if(!$dbLink->query($sqlrmStudent)){
							
			}//end of remove student if statement
			
			if(!$dbLink->query($sqlrmTorrent)){
							$_SESSION['error_message'] = "The user has not been deleted";
							header("Location: ../admin.php");
							die();
			}//end of remove student if statement
			else{
							$_SESSION['error_message'] = "The user has been deleted";
							header("Location: ../admin.php");
							die();
			}
		}
		
		}//end of while getInfo Array
	}//end of if(sqlgetInfo
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>