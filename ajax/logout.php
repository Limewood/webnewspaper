<?php
/**
 * Server-side logout service
 */

// Open connection
require_once("../lib/Database.php");
$conn = Database::getInstance()->getConnection();

try {
	include("../config.php");
	mysql_query("UPDATE ".$tableprefix."sessions SET user_id='0',
									logged_in='0',
									is_editor='0',
									is_admin='0'
								WHERE session_id='".$_COOKIE['sid']."'");
	global $logged_in, $user_id, $is_editor, $is_admin;
	$logged_in = false;
	$user_id = 0;
	$is_editor = false;
	$is_admin = false;
	header('Content-type: text/xml');
	echo "<login><reply>true</reply></login>";
} catch(Exception $e) {
	header('Content-type: text/xml');
	echo "<login><reply>false</reply></login>";
}
?>