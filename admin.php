<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	if ($_SESSION['main_group']!=admin){
			die("You are not allowed on this page.");		}
?>
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
<div class="header clear"><!-- START SUBSCRIPTION OPTIONS -->
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
<h1><a href="#">EduTorrent</a></h1>
<h2>Bittorrent for Education.</h2>
<!-- END HEADER --></div>

<div class="menu">
<ul class="clear">

	<!-- MENU -->
	<li class="current"><?php include("htmlphp/menu.php");?> <!-- END MENU -->

	</li>
</ul>
</div>

<div class="body clear">
<div class="content"><!-- CONTENT -->
					<div id="System_messages">
								<?php
										if($_SESSION['error_message']!=""){
											printf("%s", $_SESSION['error_message']);
											$_SESSION['error_message']="";
										}
								?>
					</div>
<div id="add_user">
<h4>Add User</h4>
<form action="/scripts/add_user.php" method="post" name="add_user"
	id="add_user">
<p align="left">Username:</p>
<input name="username" type="text" />
<p align="left">Name:</p>
<input name="name" type="text" />
<p align="left">Password:</p>
<input type="password" name="password" />
<p align="left">Group:</p>
<select name="group">
	<option value="teachers">Teachers</option>
	<option value="students">Student</option>
	<option value="admin">Administrator</option>
</select>
<p align="right"><input type="submit" value="Submit" /></p>
</form>
</div>
<div id="add_user">
<h4>Remove User</h4>
<form action="/scripts/rm_user.php" method="post" name="rm_user"
	id="rm_user">
<p align="left">Username:</p>
	<select name="uid">
	 						    <?php
						    	include ("./scripts/db.php");
						    	$uid = ($_SESSION['uid']);
						    	$class = "ID_\$uid\CL_%";
						    	$sqlGetUsers = "SELECT uid, name FROM users";
						    	
							    	if($listQ = $dbLink->query($sqlGetUsers)){
							    		while($listR = $listQ->fetch_assoc()){
							    					printf("<option value=%s>%s</option>", $listR['uid'], $listR['name']);
						    				}
						    			}
						    			
						    	
							?>
	</select>
<p align="right"><input type="submit" value="Submit" /></p>
</form>
</div>
<!-- END CONTENT --> <!-- FOOTER AND COPYRIGHT --> <!-- link to spyka.net must remain unless unbranded license brought! -->
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


