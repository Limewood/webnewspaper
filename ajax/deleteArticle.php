<?php
require_once '../lib/Database.php';
include '../config.php';
$conn = Database::getInstance()->getConnection();

$result = mysql_query("SELECT is_editor FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."'");
$row = mysql_fetch_assoc($result);

if($row['is_editor']) {
	$article = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	$editor = filter_input(INPUT_POST, 'editor', FILTER_VALIDATE_INT);
	
	if(mysql_query("DELETE FROM ".$tableprefix."news WHERE id='".$article."'")) {
		$result = mysql_query("SELECT n.headline AS headline, a.name AS name FROM ".$tableprefix."news n LEFT JOIN ".$tableprefix."authors a ON n.author=a.id WHERE n.id='".$article."'");
		$row = mysql_fetch_array($result);
		$headline = $row['headline'];
		$author = $row['name'];
		mysql_query("INSERT INTO ".$tableprefix."editors_log (editor, action, time, description) VALUES('".$editor."','deleted an article',NOW(),'".$headline." by ".$author."')");
		echo "<reply><success>true</success></reply>";
	}
	else {
		echo "<reply><success>false</success><error>SQL fail</error></reply>";
	}
}
else {
	echo "<reply><success>false</success><error>not editor</error></reply>";
}
?>
