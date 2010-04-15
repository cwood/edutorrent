<?php
session_start();
if($_SESSION['main_group']=='students'){
		Die("You are not allowed on this page.");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
			<script type="text/javascript" src="../js/colorbox/jquery.colorbox.js"></script>
			<script type="text/javascript">
						$(document).ready(function(){
							$(".sign_in").colorbox({width:"30%", inline:true, href:"#login_box"});
						});
			</script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script src="js/signin.js" type="text/javascript"></script>
<title>Edutorrent - Bittorrent for Educations</title>
</head>
<body>
<!-- wrapper, adds curve background images -->
<div id="wrapper">
	<div class="inner-wrapper">
		<div class="header clear">
			<!-- START SUBSCRIPTION OPTIONS -->
			<div class="subscribe">
						<p><a class='sign_in' href="#">Sign In</a></p>
							<div style="display:none">
								<div id='login_box' style='padding:0px; background:#fff;'>
									<form method="post" action="/scripts/login_script.php">
										<p align="left"><label>UserName
										<input type="text" name="username"/></label></p>
										<p align="left"><label>Password
										<input type='password' name="password"/></label>
										<input type="submit" value=" Sign In "/></p>
									</form>
								</div>
							</div>
			</div>
				
			<!-- START HEADER -->
			<h1><a href="index.php">EduTorrent</a></h1>
			<h2>Bittorrent for Education.</h2>
			<!-- END HEADER -->			
		</div>
		
		<div class="menu">
			<ul class="clear">
			
				<!-- MENU -->
				<li class="current"><?php include("htmlphp/menu.php");?>
				<!-- END MENU -->
				
			</ul>
		</div>
		
		<div class="body clear">
			<div class="content" id="body">
				<!-- CONTENT -->
					<div id="System_messages">
								<?php
										if($_SESSION['error_message']!=""){
											printf("%s", $_SESSION['error_message']);
											$_SESSION['error_message']="";
										}
								?>
					</div>
				      <div id="add_class">
					    <h4>Add a class</h4>
							<form name="Add a Class" method="post" title="Add a Class" action="scripts/add_class.php" >
				  				<p align="left">Class Number: <input name="class_name" type="text"></p>
				  				<p align="left">Class Description: <input name="class_desc" type="text"></p>
											<p align="right"><input type="submit" value="Add Class"></p>
							</form>
					</div>
					<div id="rm_class">
		        <h4>Delete a Class</h4>
							<form name="Delete a Class" method="post" title="Delete a Class" action="scripts/rm_class.php" >
							<select name="class_name">
						    <?php
						    include ("./scripts/db.php");
						    	$uid = ($_SESSION['uid']);
						    	$class = "ID_\$uid\CL_%";
						    	$sqlGetClass = "SELECT c_id FROM classes WHERE t_uid='$uid' ";
						    	
						    	if($listQ = $dbLink->query($sqlGetClass)){
						    		while($listR = $listQ->fetch_assoc()){
						    			foreach($listR as $class){
						    					$exploded = explode('_', $class);
						    					printf("<option value=%s>%s</option>", $class, $exploded[3]);
						    					}
						    				}
						    			
						    	}
							?>
							</select>
							<input type="submit"	value="Delete Class">
							</form>
					</div>
					<div id="add_student">
					  <h4>Add a student </h4>
					  <form name="Add a student" method="post" title="Add student to a class" action="scripts/add_too_class.php">
					  	<p>Students Available</p>
						<select name="StudentID">
						    <?php
						    include ("./scripts/db.php");
						    	$sqlGetUsers = "SELECT uid, name FROM users";
						    	
						    	if($listQ = $dbLink->query($sqlGetUsers)){
						    		while($listR = $listQ->fetch_assoc()){
						    					printf("<option value=%s>%s</option>", $listR['uid'],$listR['name'] );
						    					
						    				}
						    			
						    	}
							?>
							</select>									
							Class Name:<select name="class_name">
 						    <?php
						    include ("./scripts/db.php");
						    	$uid = ($_SESSION['uid']);
						    	$class = "ID_\$uid\CL_%";
						    	$sqlGetClass = "SELECT c_id FROM classes WHERE t_uid='$uid' ";
						    	
							    	if($listQ = $dbLink->query($sqlGetClass)){
							    		while($listR = $listQ->fetch_assoc()){
							    			foreach($listR as $class){
							    					$exploded = explode('_', $class);
							    					printf("<option value=%s>%s</option>", $class, $exploded[3]);
						    					}
						    				}
						    			}
						    			
						    	
							?>
							</select>
									<input type="submit"	value="Add a Student">
					  </form>
			  </div>
			  					<div id="add_student">
					  <h4>Remove a student </h4>
					  <form name="Remove a student" method="post" title="Remove student from a class" action="scripts/rm_from_class.php">
					  	<p>Students Available</p>
						<select name="StudentID">
						    <?php
						    include ("./scripts/db.php");
						    	$uid = ($_SESSION['uid']);
						    	$sqlGetClasses = "SELECT c_id FROM classes WHERE t_uid='$uid'";
						    	
						    	if($getClassQ = $dbLink->query($sqlGetClasses)){
						    		while($getClassR = $getClassQ->fetch_assoc()){
						    			foreach($getClassR as $class){
						    				$exploded = explode('_', $class);
						    						$sqlGetStudents = "SELECT uid FROM registrar WHERE c_id='$class'";
						    							if ($getStudents = $dbLink->query($sqlGetStudents)){
						    								while ($getStudentsR = $getStudents->fetch_assoc()){
						    									foreach($getStudentsR as $student){
						    											$getNames = "SELECT uid, name FROM users WHERE uid='$student'";
						    												if($getNamesQ = $dbLink->query($getNames)){
						    													while ($getNamesR = $getNamesQ->fetch_assoc()){
						    										printf("<option value=%s_%s>%s - %s</option>", $getNamesR['uid'], $class, $getNamesR['name'], $exploded[3]);
						    										}
						    									}
						    								}
						    							}
						    						}
						    					}
						    				}
						    			
						    	}
							?>

									<input type="submit"	value="Delete Student">
					  </form>
			  </div>
					<div id="upload_torrent">
					  <form action="scripts/upload-torrent.php" method="post" enctype="multipart/form-data" name="Upload torrent to class" id="upload torrent">
                        	<h5>Upload Torrent</h5>
							<p>Class:
						    <select name="class_name">
						    <?php
						    include ("./scripts/db.php");
						    	$uid = ($_SESSION['uid']);
						    	$class = "ID_\$uid\CL_%";
						    	$sqlGetClass = "SELECT c_id FROM classes WHERE t_uid='$uid' ";
						    	
						    	if($listQ = $dbLink->query($sqlGetClass)){
						    		while($listR = $listQ->fetch_assoc()){
						    			foreach($listR as $class){
						    					$exploded = explode('_', $class);
						    					printf("<option value=%s>%s</option>", $class, $exploded[3]);
						    					}
						    				}
						    			
						    	}
							?>
							</select>
							  <input type="hidden"	name="MAX_FILE_SIZE"	value="100000"	/>
							  Upload:		<input type="file"		name="torrent" 			id="torrent"	/>
							  Type:		
							  <input name="type" type="text" value="TYPE" size="10" />
							  <input type="submit"	value="Upload"				/>
						  </p>
							<p>
							  Description:
							    <textarea name="torName" cols="50" rows="5" style="">A description about the file.</textarea>
							</p>
                        </form>
					</div>
				<!-- END CONTENT -->
				
				
				<!-- FOOTER AND COPYRIGHT -->
				<!-- link to spyka.net must remain unless unbranded license brought! -->
		  <div class="copyright">
					<p>&copy; 2009 Edutorrent. <?php include ('htmlphp/footer.php') ?></p>
				</div>
		
			</div>
			
			<!-- SIDEBAR -->
			<div class="sidebar">			
				
			</div>
		</div>
	</div>
</div>
</body>
</html>