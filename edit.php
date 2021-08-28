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

	$ERROR = "";
	if(isset($_GET['id'])){

		 $ROW = $Post->get_one_post($_GET['id']);

		 if(!$ROW){

		 	$ERROR = "No such post was found!";
		 }else{

		 	if($ROW['userid'] != $_SESSION['mybook_userid']){

		 		$ERROR = "Accesss denied! you cant delete this file!";
		 	}
		 }

	}
?>