<?php
/**
 * Server-side login service
 */
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Check if trying to log in as Anonymous
if($name == "Anonymous") {
	echo "<login><reply>false</reply></login>";
	return;
}

include("../config.php");
// Open connection
require_once("../lib/Database.php");
$conn = Database::getInstance()->getConnection();

$result = mysql_query("SELECT id, password, is_editor, is_admin FROM ".$tableprefix."authors WHERE name='".$name."' LIMIT 1");
if($result === false) {
	echo "<login><reply>false</reply></login>";
}
else {
	$row = mysql_fetch_assoc($result);
	if($password == $row['password']) {
		mysql_query("UPDATE ".$tableprefix."sessions SET user_id='".$row['id']."',
										logged_in='1',
										is_editor='".$row['is_editor']."',
										is_admin='".$row['is_admin']."'
									WHERE session_id='".$_COOKIE['sid']."'");
		header('Content-type: text/xml');
		echo "<login><reply>true</reply></login>";
	}
	else {
		header('Content-type: text/xml');
		echo "<login><reply>false</reply></login>";
	}
}
?>