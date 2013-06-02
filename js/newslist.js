/**
 * Functions for news lists
 */

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    if(vars[0] == window.location.href) return null;
    return vars;
}

function setCategory(cat) {
	var params = getUrlVars();
	if(params == null) {
		if(cat!='') {
			window.location.href += "?cat="+cat;
		}
	}
	else if(params['cat'] == null){
		if(cat!='') {
			window.location.href += "&cat="+cat;
		}
	}
	else {
		if(cat!='') {
			window.location.href = window.location.href.replace(/cat\=[0-9]+/,"cat="+cat);
		}
		else {
			window.location.href = window.location.href.replace(/[\?\&]{1}cat\=[0-9]+/,"");
		}
	}
}