<?php

if(Session::exists("user_id") && !empty($_POST)){
	if($_POST["content"]!=""){
	$h = new CommentData();
	$h->ref_id = $_POST["r"];
	$h->user_id = $_SESSION["user_id"];
	$h->type_id = $_POST["t"];
	$h->content = $_POST["content"];
	$h->add();

	$user_id = null;
	$author_id = null;
	if($_POST["t"]==1){
	$post = PostData::getReceptorId($_POST["r"]);
		$user_id = $post->receptor_ref_id;
		$author_id = $post->author_ref_id;
	}
	else if($_POST["t"]==2){
	$post = ImageData::getUserId($_POST["r"]);
		$user_id = $post->user_id;
		$author_id = $post->user_id;
	}

	if($author_id!=$_SESSION["user_id"] && $user_id!=$_SESSION["user_id"]){ 
		$notification = new NotificationData();
		$notification->not_type_id=2; 
		$notification->type_id = $_POST["t"]; 
		$notification->ref_id = $_POST["r"]; 
		$notification->receptor_id = $user_id;
		$notification->sender_id = $_SESSION["user_id"]; 
		$notification->add();
	}


	}
}

?>
