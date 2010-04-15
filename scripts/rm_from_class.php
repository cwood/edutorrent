 <?php
//*******************Database Information
include ("db.php");
//*******************Session Start
session_start();

	if($_SESSION['main_group']==students){
		Die("You are not allowed on this page.");
	}//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
$explode = explode('_', $_POST['StudentID']);
$studentID = $explode[0];
$teachID = $_SESSION['uid'];
$class_ID  = sprintf("ID_%s_CL_%s", $teachID, $explode[4]);

//##############################################################################//
//							Start Main PHP Code									//

if(chkCurrentClass($studentID)==0){
			addToClass($studentID);
}

//*******************************************************************************//
//							Functions start										 //

//_______________________________________________________________________chkCurrentClass();
//Sees what classes the user is currently in.
function chkCurrentClass($student){
	global $dbLink, $class_ID;
	
	$chkStuSQL = "SELECT `uid`, `c_id` FROM registrar WHERE uid='$student' && c_id='$class_ID'";
	$cur = mysqli_num_rows($dbLink->query($chkStuSQL));
	
	if($cur==1){
			return 0;
	}
	else{
			$_SESSION['error_message'] = 'This user has not been added..';
			header("Location: ../teach_panel.php");
	}
}
//_______________________________________________________________________addToClass();
//Now that the user has a free class available we will add that user to the class.
function addToClass($student){
	global $dbLink, $class_ID;
	
	$rmStudent = "DELETE FROM registrar WHERE uid='$student' && c_id='$class_ID'";

	if(!$dbLink->query($rmStudent)){
			$_SESSION['error_message'] = 'Could Not remove user from the system.';
			header("Location: ../teach_panel.php");	}
	else{
			$_SESSION['error_message'] = sprintf('Removed %s from %s successfully.',$student, $class_ID);
			header("Location: ../teach_panel.php");	}	
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>