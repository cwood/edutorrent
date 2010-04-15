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
$class_desc = mysqli_real_escape_string($dbLink, $_POST['class_desc']);
$nTable=sprintf("ID_%s_CL_%s", $userID, $nClass);
//##############################################################################//
//							Start Main PHP Code									//
 if (chkClassMade()==0){
 		if (crtClass()==0){
 				addTeachtoClass();
 		}
 	 }
 	 else {
 	 	echo "There was an error when adding  %s", $nTable;
 	 }
//*******************************************************************************//
//							Functions start										 //

//_______________________________________________________________________chkTable
//cheaks to see if a table is all rady made with that class system.
function chkClassMade(){
		
		global $dbLink, $nTable, $userID;
		
		$chkSQL= "SELECT `c_id`, `t_uid` FROM classes WHERE c_id='$nTable' && t_uid='$userID'";
		$cur = mysqli_num_rows($dbLink->query($chkSQL));	
			
				echo $cur, $chkSQL;
					if($cur==1){
							$_SESSION['error_message'] = 'Your class is currently in the system.';
							header("Location: ../teach_panel.php");
							die();
					}
					elseif($cur==0) {
							return 0;
					}
					else{
							$_SESSION['error_message'] = 'Something went wrong.';
							header("Location: ../teach_panel.php");
							die();
					}
					$_SESSION['error_message'] = 'Your class was added. Please add students.';
			header("Location: ../teach_panel.php");
}
//_______________________________________________________________________crtTable();
//Creates a table to the system, used for files, descriptions and fids.
function crtClass(){

	global $nTable, $dbLink, $userID, $class_desc;
	
			$addClass="INSERT INTO classes (`c_id`, `t_uid`, `class_name`) VALUES ('$nTable', '$userID', '$class_desc')";
	
	if(!$dbLink->query($addClass)){
			$_SESSION['error_message'] = 'Your class could not be added';
			header("Location: ../teach_panel.php");
	}
	else{

			return 0;
	}	
}
//_______________________________________________________________________addTeachtoClass();
//Creates a table to the system, used for files, descriptions and fids.
function addTeachtoClass(){
	global $nTable, $dbLink, $userID;
		
		$regTeacher = "INSERT INTO registrar (`uid`, `c_id`) VALUES ('$userID','$nTable')";
		
		if(!$dbLink->query($regTeacher)){
				$_SESSION['error_message'] = 'You can not be added to the database';
				header("Location: ../teach_panel.php");
				die();
		}
		else{
				$_SESSION['error_message'] = 'Your class has been added and you have been added as a user.';
				header("Location: ../teach_panel.php");
		}
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>