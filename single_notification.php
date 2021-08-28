<?php 

	$actor = $User->get_user($notif_row['userid']);
	$owner = $User->get_user($notif_row['content_owner']);
	$id = esc($_SESSION['mybook_userid']);

	$link = "";

	if($notif_row['content_type'] == "post"){

		$link = "single_post.php?id=" . $notif_row['contentid'] . "&notif=" . $notif_row['id'];
	}else
	if($notif_row['content_type'] == "profile"){

		$link = "profile.php?id=" . $notif_row['userid'] . "&notif=" . $notif_row['id'];
	}if($notif_row['content_type'] == "comment"){

		$link = "single_post.php?id=" . $notif_row['contentid'] . "&notif=" . $notif_row['id'];
	}

	//check if the notification was seen
	$query = "select * from notification_seen where userid = '$id' && notification_id = '$notif_row[id]' limit 1";
	$seen = $DB->read($query);

	if(is_array($seen)){
		$color = "#eee";
	}else{
		$color = "#dfcccc";
	}
?>

<a href="<?php echo $link ?>" style="text-decoration: none;">
	<div id="notification" style="background-color: <?= $color ?>">

		<?php
			if(is_array($actor) && is_array($owner)){

				$image = "images/user_male.jpg";
				if($actor['gender'] == "Female")
				{
					$image = "images/user_female.jpg";
				}

				if(file_exists($actor['profile_image']))
				{
					$image = $image_class->get_thumb_profile($actor['profile_image']);
				}

				echo "<img src='$image' style='width:36px;margin:4px;float:left;' />";

				if($actor['userid'] != $id){
					echo $actor['first_name'] . " " . $actor['last_name'];
				}else{
 					echo "You ";
				}

 				if($notif_row['activity'] == "like"){
					echo " liked ";
				}else
				if($notif_row['activity'] == "follow"){
					echo " followed ";
				}else
				if($notif_row['activity'] == "comment"){
					echo " commented ";
				}else
				if($notif_row['activity'] == "tag"){
					echo " tagged ";
				}


				if($owner['userid'] != $id && $notif_row['activity'] != "tag"){
					echo $owner['first_name'] . " " . $owner['last_name'] . "'s ";

				}elseif($notif_row['activity'] == "tag"){
					echo " you in a ";
				}else{
 					echo " your ";
				}
				
 				$content_row = $Post->get_one_post($notif_row['contentid']);
				
				if($notif_row['content_type'] == "post"){

					if($content_row['has_image']){
						echo "image";

						if(file_exists($content_row['image']))
						{

							$post_image = $image_class->get_thumb_post($content_row['image']);

							echo "<img src='$post_image' style='width:40px;float:right;' />";
						}
 					}else{

						echo $notif_row['content_type'];
						echo "
 								<span style='float:right;font-size:11px;color:#888;display:inline-block;margin-right:10px;'>'".htmlspecialchars(substr($content_row['post'],0,50))."'</span>
							";
					}
				}else{

					echo $notif_row['content_type'];
					echo "
						<span style='float:right;font-size:11px;color:#888;display:inline-block;margin-right:10px;'>'".htmlspecialchars(substr($content_row['post'],0,50))."'</span>
					";
				}

				$date = date("jS M Y H:i:s a",strtotime($notif_row['date']));
				echo "<br>

					<span style='font-size:11px;color:#888;display:inline-block;margin-right:10px;'>$date</span>
				";
			}
		?>
	</div>
</a>