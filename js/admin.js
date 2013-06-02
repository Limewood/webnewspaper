/**
 * Admin functions
 */

function createAuthor() {
	var name = prompt("Name:");
	if(name == null || name == "") return;
	var editor = confirm("Make editor?");
	var pass = getRandomString(25);
	// Ask server to add author to db
	$.post("ajax/createAuthor.php", {name: name, editor: editor, password: hex_md5(pass)}, function(xml) {
		// Process outcome
		if($("reply", xml).text() == "true") {
			// Success
			alert("Author created successfully!\nPassword: "+pass);
		}
		else {
			// Failure
			alert("An error occurred. Please try again.");
		}
	});
}

function getRandomString(length) {
	characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	string = "";    

	for(var i = 0; i < length; i++) {
		string += characters[Math.floor(Math.random()*(characters.length-1))];
	}

	return string;
}