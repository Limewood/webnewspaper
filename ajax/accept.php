<?php
require_once '../lib/Database.php';
include '../config.php';
$conn = Database::getInstance()->getConnection();

$result = mysql_query("SELECT is_editor FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."'");
$row = mysql_fetch_assoc($result);

if($row['is_editor']) {
	$article = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	$editor = filter_input(INPUT_POST, 'editor', FILTER_VALIDATE_INT);
	
	if(mysql_query("UPDATE ".$tableprefix."news SET accepted_by='".$editor."', reported_by='-1' WHERE id='".$article."'")) {
		$result = mysql_query("SELECT headline FROM ".$tableprefix."news WHERE id='".$article."'");
		$row = mysql_fetch_array($result);
		$headline = $row['headline'];
		mysql_query("INSERT INTO ".$tableprefix."editors_log (editor, action, time, description) VALUES('".$editor."','accepted an article',NOW(),'".$headline." with id ".$article."')");
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
