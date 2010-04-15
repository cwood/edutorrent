 <?php
//*******************Database Information
include ("db.php");
//*******************Session Start
session_start();

	if($_SESSION['main_group']==students){
		Die("You are not allowed on this page.");
	}//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
$studentID = $_POST['StudentID'];
$class_ID   = $_POST['class_name'];
$teachID = $_SESSION['uid'];
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
	
	if($cur==0){
			return 0;
	}
	else{
			$_SESSION['error_message'] = 'This user has all ready been added.';
			header("Location: ../teach_panel.php");
	}
}
//_______________________________________________________________________addToClass();
//Now that the user has a free class available we will add that user to the class.
function addToClass($student){
	global $dbLink, $class_ID;
	
	$addStudent = "INSERT INTO registrar (`uid`, `c_id`) VALUES ('$student', '$class_ID')";
	
	if(!$dbLink->query($addStudent)){
			$_SESSION['error_message'] = 'Could Not Add User to the system.';
			header("Location: ../teach_panel.php");	}
	else{
			$_SESSION['error_message'] = 'Added user succsefully.';
			header("Location: ../teach_panel.php");	}	
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>