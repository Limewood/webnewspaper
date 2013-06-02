<?php
require_once '../lib/Database.php';
include '../config.php';

$name = $_POST['name'];
$editor = $_POST['editor'];
$pass = $_POST['password'];

Database::getInstance()->getConnection();
$result = mysql_query("SELECT id FROM ".$tableprefix."authors WHERE name='".$name."'");
if(mysql_num_rows($result) > 0) {
	echo "<author><reply>false</reply></author>";
}
else {
	$result = mysql_query("INSERT INTO ".$tableprefix."authors (name, password, is_editor) ".
		"VALUES ('".$name."','".$pass."',".($editor ? 1 : 0).")");
	if($result == false) {
		echo "<author><reply>false</reply></author>";
	}
	else {
		echo "<author><reply>true</reply></author>";
	}
}
?>