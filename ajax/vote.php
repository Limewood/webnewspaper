<?php
require_once("../lib/Database.php");
$conn = Database::getInstance()->getConnection();
include("../config.php");

//TODO Write info about saving IP addresses

if(isset($_POST['id'])) {
	// Check if this IP address already voted
	$result = mysql_query("SELECT voted FROM ".$tableprefix."news WHERE id=".$_POST['id']);
	$row = mysql_fetch_assoc($result);
	$ips = $row['voted'];
	if(strstr($ips, $_SERVER['REMOTE_ADDR']) == false) {
		// Add vote
		$ip = ",".$_SERVER['REMOTE_ADDR'];
		mysql_query("UPDATE ".$tableprefix."news SET interesting=interesting+1, voted=concat(voted,'".$ip."') WHERE id=".$_POST['id']);
		$result = mysql_query("SELECT interesting FROM ".$tableprefix."news WHERE id=".$_POST['id']);
		$row = mysql_fetch_assoc($result);
		$votes = $row['interesting'];
	}
}
else $votes = "?";
// echo votes
header('Content-type: text/xml');
echo "<voting><votes>".$votes."</votes></voting>";
?>