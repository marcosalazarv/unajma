<?php 

	include("classes/autoload.php");
 
	$login = new Login();
	$user_data = $login->check_login($_SESSION['mybook_userid']);
 
 	$USER = $user_data;
 	
 	if(isset($_GET['id']) && is_numeric($_GET['id'])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($_GET['id']);

	 	if(is_array($profile_data)){
	 		$user_data = $profile_data[0];
	 	}

 	}
 	
	
	$Post = new Post();
	$likes = false;

	$ERROR = "";
	if(isset($_GET['id']) && isset($_GET['type'])){
 
		$likes = $Post->get_likes($_GET['id'],$_GET['type']);
	}else{

		$ERROR = "No information post was found!";
	}
 
?>