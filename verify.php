<?php
require_once("lib/Database.php");
include_once 'config.php';

$conn = Database::getInstance()->getConnection();
$result = mysql_query("SELECT email_verification FROM ".$tableprefix."authors WHERE id='".$_GET['id']."'");
$row = mysql_fetch_assoc($result);
echo "<!DOCTYPE html>".
"<html>".
	"<head>".
		'<meta charset="ISO-8859-1" />'.
		'<title>'.$newspaper_name.' - Email verification</title>'.
		'<script src="js/html5enable.js" type="text/javascript"></script>'.
	'</head>'.
	'<body>';
if($row['email_verification'] == $_GET['code']) {
	mysql_query("UPDATE ".$tableprefix."authors SET email=new_email, new_email='', email_verification='' WHERE id='".$_GET['id']."'");
	echo "<h2>Your email is now verified!</h2>\n";
	echo "<br /><a href='index.php'>Back to front page</a>";
}
else {
	echo "<h2>Verification error!</h2>\n";
	echo "<br /><a href='index.php'>Back to front page</a>";
}
echo "</body></html>";
?>