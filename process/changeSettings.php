<?php
require_once("../lib/Database.php");
include("../config.php");
include_once("../include/utils.php");

$conn = Database::getInstance()->getConnection();
$result = mysql_query("SELECT user_id FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."' LIMIT 1") or die("SQL error");
$row = mysql_fetch_assoc($result);

$email_sent = false;
$password_changed = false;
if(isset($_POST['settings_email'])) {
	// Save new email and send verification email to address
	$addr = $_POST['settings_email'];
	// Check if the address is not the same as the old saved address
	$author_result = mysql_query("SELECT email FROM ".$tableprefix."authors WHERE id='".$row['user_id']."' LIMIT 1");
	$author_row = mysql_fetch_assoc($author_result);
	if($author_row['email'] != $addr) {
		$verify = getRandomString(25);
		mysql_query("UPDATE ".$tableprefix."authors SET new_email='".$addr."', email_verification='".$verify."' WHERE id='".$row['user_id']."'") or die("SQL error");
		
		// Send verification email
		$to = $addr;
		$subject = $newspaper_name." - email verification";
		$body = "This is an email to verify your address for the online newspaper ".$newspaper_name.".<br />\n".
			"If you believe you have received this email in error, please contact ".$admin_email.".<br />\n".
			"<br />To verify your email, please click the link below or paste it in a web browser.<br />\n".
			"<a href=\"http://".$web_path."/verify.php?id=".$row['user_id']."&code=".$verify."\">http://".$web_path."/verify.php?code=".$verify."</a><br />\n".
			"<br />With regards,<br />The admins of ".$newspaper_name."<br />\n";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		$headers .= "From: ".$admin_email."\r\n" .
			"X-Mailer: php";
		if(@mail($to, $subject, $body, $headers)) {
			$email_sent = true;
		}
	}
}
if(isset($_POST['settings_password']) && $_POST['settings_password'] != "") {
	mysql_query("UPDATE ".$tableprefix."authors SET password='".md5($_POST['settings_password'])."' WHERE id='".$row['user_id']."'");
	$password_changed = true;
}

header("Location: ../settings.php".($email_sent ? "?email_sent" : "").($password_changed ? ($email_sent ? "&" : "?")."password_changed" : ""));
?>