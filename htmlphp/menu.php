<?php
	session_start();
	if ($_SESSION['main_group']==admin){
		printf("<li><a href=index.php><span>Home</span></a></li>");
		printf("<li><a href=browse.php><span>Browse</span></a></li>");
		printf("<li><a href=admin.php><span>Admin Panel</span></a></li>");	
		printf("<li><a href=teach_panel.php><span>Teacher Panel</span></a></li>");	
		printf("<li><a href=profile.php><span>Profile</span></a></li>");	
		printf("<li><a href=scripts/logout.php><span>Logout</span></a></li>");		
	}
	elseif($_SESSION['main_group']==teachers){
		printf("<li><a href=index.php><span>Home</span></a></li>");
		printf("<li><a href=browse.php><span>Browse</span></a></li>");
		printf("<li><a href=teach_panel.php><span>Teacher Panel</span></a></li>");	
		printf("<li><a href=profile.php><span>Profile</span></a></li>");	
		printf("<li><a href=scripts/logout.php><span>Logout</span></a></li>");	
	
	}
	elseif($_SESSION['main_group']==students){
		printf("<li><a href=index.php><span>Home</span></a></li>");
		printf("<li><a href=browse.php><span>Browse</span></a></li>");
		printf("<li><a href=profile.php><span>Profile</span></a></li>");	
		printf("<li><a href=scripts/logout.php><span>Logout</span></a></li>");	
	
	}
	else{
		printf("<li><a href=login.php><span>Login</span></a></li>");	
		die();
	}
	
?>