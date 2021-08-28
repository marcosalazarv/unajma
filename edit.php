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

	}else{

		$ERROR = "No such post was found!";
	}

	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")){

		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
	}

	//if something was posted
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$Post->edit_post($_POST,$_FILES);


		header("Location: ".$_SESSION['return_to']);
		die;
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Delete | Mybook</title>
	</head>

	<style type="text/css">
		
		#blue_bar{

			height: 50px;
			background-color: #405d9b;
			color: #d9dfeb;

		}

		#search_box{

			width: 400px;
			height: 20px;
			border-radius: 5px;
			border:none;
			padding: 4px;
			font-size: 14px;
			background-image: url(search.png);
			background-repeat: no-repeat;
			background-position: right;

		}

		#profile_pic{

			width: 150px;
			border-radius: 50%;
			border:solid 2px white;
		}

		#menu_buttons{

			width: 100px;
			display: inline-block;
			margin:2px;
		}

		#friends_img{

			width: 75px;
			float: left;
			margin:8px;

		}

		#friends_bar{

			min-height: 400px;
			margin-top: 20px;
			padding: 8px;
			text-align: center;
			font-size: 20px;
			color: #405d9b;
		}

		#friends{

		 	clear: both;
		 	font-size: 12px;
		 	font-weight: bold;
		 	color: #405d9b;
		}

		textarea{

			width: 100%;
			border:none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;

		}

		#post_button{

			float: right;
			background-color: #405d9b;
			border:none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px;
		}
 
 		#post_bar{

 			margin-top: 20px;
 			background-color: white;
 			padding: 10px;
 		}

 		#post{

 			padding: 4px;
 			font-size: 13px;
 			display: flex;
 			margin-bottom: 20px;
 		}
 	
