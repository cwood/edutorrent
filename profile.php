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
					<p>
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
					</p>
			<h1><a href="#">EduTorrent</a></h1>
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
			<div class="content">
				<!-- CONTENT -->
				<?php
						if($_SESSION['error_message']!=""){
							printf("%s", $_SESSION['error_message']);
							$_SESSION['error_message']="";
						}
				?>
				<div id="pass_form">
					<dl>	
						<form method="post" action="scripts/profile_update.php?func_id=Password">
						<dt><label for="Password Update" >Password Update</label></dt>
						<dd><input class="text" type="password" name="Password1" value="" id="password1" /></dd>
						<dd><input class="text" type="password" name="Password2" value="" id="password2" /></dd>
						<dd><input type="submit" value="Submit"/></p></dd>
						</form>
					</dl>
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
