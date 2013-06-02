/**
 * Javascript for the Settings page
 */
function validate(field_id, field_value) {
	switch (field_id) {
    
	case "settings_email":
		var email_empty = "Please fill in an email address!";
		var email_not_valid = "Not a valid email address!";
	
		if(field_value == null || field_value == "") {
			document.getElementById(field_id).style.backgroundColor = "#f32";
			document.getElementById(field_id+"_status").innerHTML = email_empty;
			return false;
	    }
	    else {
	        if(!regExpEmail(field_value)) {
	        	document.getElementById(field_id).style.backgroundColor = "#f32";
				document.getElementById(field_id+"_status").innerHTML = email_not_valid;
				return false;
	        }
		    else {
		    	document.getElementById(field_id).style.backgroundColor = "#9f5";
				document.getElementById(field_id+"_status").innerHTML = '';
			}
	    }
	    break;
	
	case "settings_password":
	case "settings_password_repeat":
		var password_too_short = "The password needs to be at least 5 characters!";
		
		if(field_value.length < 5 && field_value.length > 0) {
			document.getElementById(field_id).style.backgroundColor = "#f32";
			document.getElementById(field_id+"_status").innerHTML = password_too_short;
			return false;
		}
		else {
			document.getElementById(field_id).style.backgroundColor = "inherit";
			document.getElementById(field_id+"_status").innerHTML = '';
		}
	}

	return true;
}

function regExpEmail(field_value) {
	var reg = new RegExp("^[0-9a-zA-Z]+@[0-9a-zA-Z]+[\.]{1}[0-9a-zA-Z]+[\.]?[0-9a-zA-Z]+$");
	return reg.test(field_value);
}

function checkPasswords(form) {
	if(form.settings_password.value == form.settings_password_repeat.value) {
		return true;
	}
	else {
		alert("The passwords don't match!");
		form.settings_password.focus();
		form.settings_password.select();
		return false;
	}
}