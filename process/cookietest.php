<?php
// Check if already logged in
$cookies_allowed=false;
if(isset($_COOKIE['sid'])) {
	// Session exists - allow login
	$cookies_allowed=true;
	include("process/sessions.php");
}
else {
	// Not logged in - check for 'remember me'-cookie
	if(isset($_COOKIE["memory"])) {
		//TODO Decode - log in - get user id from db and set cid as user id
	}
	else {
		// No 'remember me'-cookie - run cookie test
		if((isset($_GET['cookie']) || $_GET['cookie'] != 'aye') && !isset($_COOKIE['cookietest'])) {
			// Set the cookie
			setcookie("cookietest","what's up?",0,"/");

			//ladda om sidan
			if(strstr($_SERVER['REQUEST_URI'],"?cookie=aye") == false) {
				header("Location: ".$_SERVER['REQUEST_URI']."?cookie=aye");
			}
		}
		else {
			// Check if the cookie exists - e,g. if cookies are allowed
			if(isset($_COOKIE["cookietest"])) {
				// Cookies are allowed - reload page and set cid cookie
				if(!isset($_COOKIE['cid'])) {
					// cid cookie not set - set it
					$id_cookie = md5(uniqid(rand()));
					setcookie("cid",$id_cookie,0,"/");
					header("Location: ".$_SERVER['PHP_SELF']);
				}
				$cookies_allowed=true;
				include("process/sessions.php");
			}
			else {
				// Cookies are not allowed - can't allow login
				$cookies_allowed=false;
			}
		}
	}
}
?>