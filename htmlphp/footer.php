<?php
	if ($_SESSION['main_group']==admin){
		printf('<a href="browse.php" title="Browse">Browse</a><a href="admin.php" title="Admin Panel">Admin Panel</a><a href="teach_panel.php" title="Teachers Panel">Teachers Panel</a><a href="profile.php" title="Profile">Profile</a><a href="logout.php" title="Logout">Logout</a>');	
	}
	elseif($_SESSION['main_group']==teachers){
printf('<a href="browse.php" title="Browse">Browse</a><a href="teach_panel.php" title="Teachers Panel">Teachers Panel</a><a href="profile.php" title="Profile">Profile</a><a href="logout.php" title="Logout">Logout</a>');	
	
	}
	elseif($_SESSION['main_group']==students){
printf('<a href="browse.php" title="Browse">Browse</a><a href="profile.php" title="Profile">Profile</a><a href="logout.php" title="Logout">Logout</a>');	
	
	}
	else{
		die('You are not logged in');
	}
?>