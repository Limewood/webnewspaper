/**
 * Client-side login functionality
 */

function show_login() {
	var sid=getCookie("sid");
	if(sid!=null) {
		document.getElementById("login_window").style.opacity = 1;
		document.getElementById("login_window").style.height = "120px";
		document.getElementById("login_window_name").focus();
		document.getElementById("login_window_name").select();
	}
	else {
		alert("Cookies need to be allowed for login to work!");
	}
}

function hide_login() {
	document.getElementById("login_window").style.opacity = 0;
	document.getElementById("login_window").style.height = 0;
}

function login(name, password) {
	// Request login
	$.post("ajax/login.php", {name: name, password: hex_md5(password)}, function(xml) {
		// Process outcome
		if($("reply", xml).text() == "true") {
			// Success
			window.location.reload();
		}
		else {
			// Failure
			alert("You have entered an incorrect username or password. Please try again.");
		}
	});
}

function logout() {
	if(confirm("Are you sure you want to log out?")) {
		// Request logout
		$.post("ajax/logout.php", {}, function(xml) {
			// Process outcome
			if($("reply", xml).text() == "true") {
				// Success
				window.location.reload();
			}
			else {
				// Failure
				alert("An error occurred and you might not be logged out. Please try again.");
			}
		});
	}
}

function getCookie(c_name) {
	var i,x,y,cookies=document.cookie.split(";");
	for(i=0;i<cookies.length;i++) {
		x=cookies[i].substr(0,cookies[i].indexOf("="));
		y=cookies[i].substr(cookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) {
			return unescape(y);
		}
	}
}

function show_privacy() {
	document.getElementById("privacy").style.opacity = 1;
	document.getElementById("privacy").style.height = "210px";
	document.getElementById("privacy").scrollIntoView();
}

function hide_privacy() {
	document.getElementById("privacy").style.opacity = 0;
	document.getElementById("privacy").style.height = 0;
}