<?php
include 'config.php';
// Settings

$garbage_collection = 12; // Time before garbage collection (hours); How long should a session be inactive before it's removed?

$gc_probability = 10; // Probability that gc will be performed (%)

require_once("lib/Database.php");
$conn = Database::getInstance()->getConnection();

/* If the session doesn't exist, add new session in db */

if(!isset($_COOKIE["sid"])){
	$session_id = md5(rand());
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$user_id = 0;
	mysql_query("INSERT INTO ".$tableprefix."sessions (session_id, session_start, ip_address, user_id, last_activity)
			VALUES ('".$session_id."', NOW(), '".$ip_address."', '".$user_id."', NOW())");
	setcookie("sid",$session_id,0,"/");
}

/* If the session exists, update last_activity & run gc check */
else{
	if(rand(0,100)<=$gc_probability){ // Run gc
		$result = mysql_query("SELECT last_activity, session_id FROM ".$tableprefix."sessions");
		while($row = mysql_fetch_array($result)){
			$darray = explode(" ",$row['last_activity']);
			$d = explode("-",$darray[0]);
			$t = explode(":",$darray[1]);
			if(mktime($t[0],$t[1],$t[2],$d[1],$d[2],$d[0]) + $garbage_collection*360 < time()){
				mysql_query("DELETE FROM ".$tableprefix."sessions WHERE session_id = '".$row['session_id']."'");
			}
		}
	}
	$result = mysql_query("SELECT last_activity, session_id FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."'");
	$num_rows = mysql_num_rows($result);
	if($num_rows < 1) { // The session row has been deleted
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$user_id = 0;
		mysql_query("INSERT INTO ".$tableprefix."sessions (session_id, session_start, ip_address, user_id, last_activity)
				VALUES ('".$_COOKIE['sid']."', NOW(), '".$ip_address."', '".$user_id."', NOW())");
	}
	else {
		mysql_query("UPDATE ".$tableprefix."sessions SET last_activity=NOW() WHERE session_id = '".$_COOKIE['sid']."'");
	}
}
?>
