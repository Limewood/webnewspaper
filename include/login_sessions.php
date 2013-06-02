<?php 
// Handle cookies and sessions
include_once("process/cookietest.php");
require_once("lib/Database.php");
include("config.php");
$conn = Database::getInstance()->getConnection();
$result = mysql_query("SELECT user_id, logged_in, is_editor, is_admin FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."'");
$row = mysql_fetch_row($result);
global $user_id, $logged_in, $is_editor, $is_admin;
list($user_id, $logged_in, $is_editor, $is_admin) = $row;
?>
