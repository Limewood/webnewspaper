<?php
require_once("../lib/Database.php");
include("../config.php");

$headline = filter_input(INPUT_POST, "submit_headline", FILTER_SANITIZE_STRING);
$intro = filter_input(INPUT_POST, "submit_intro", FILTER_SANITIZE_STRING);
$body_text = filter_input(INPUT_POST, "submit_text", FILTER_SANITIZE_STRING);
$category = filter_input(INPUT_POST, "submit_category_select", FILTER_SANITIZE_STRING);

$conn = Database::getInstance()->getConnection();
$result = mysql_query("SELECT user_id, logged_in FROM sessions WHERE session_id='".$_COOKIE['sid']."'");
$row = mysql_fetch_row($result);
list($user_id, $logged_inS) = $row;

$author = 0;
global $logged_in, $user_id;
if($logged_in) {
	$author = $user_id;
}

$image = "";
if($_FILES['submit_image_upload']['name'] != null) {
	$image = $uploaddir . basename($_FILES['submit_image_upload']['name']);
	
	if(move_uploaded_file($_FILES['submit_image_upload']['tmp_name'], $image)) {
		$image = basename($image);
	} else {
		die("Possible file upload attack!\n");
	}
}

mysql_query("INSERT INTO news (headline, intro, body_text, image, author, accepted_by, uploaded, category) ".
	"VALUES ('".$headline."','".$intro."','".$body_text."','".$image."','".
	$author."',-1,NOW(),'".$category."')");

if($author > 0) {
	header("Location: ../article.php?art=".mysql_insert_id());
}
else {
	header("Location: ../index.php");
}
?>
