/**
 * Functions for the archive
 */

$(document).ready(function() {
	$("#search_articles").select();
});

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

function selectNum(value) {
	var options = document.getElementById("num_articles").options;
	for(var i=0; i<options.length; i++) {
		if(options[i].value == value) {
			options[i].selected = true;
			return;
		}
	}
}

function setNumArticles(num) {
	var params = getUrlVars();
	if(params == null) {
		window.location.href += "?num="+num;
	}
	else if(params['num'] == null){
		window.location.href += "&num="+num;
	}
	else {
		window.location.href = window.location.href.replace(/num\=[0-9]+/,"num="+num);
	}
}

function selectOrderBy(value) {
	var options = document.getElementById("order_by").options;
	for(var i=0; i<options.length; i++) {
		if(options[i].value == value) {
			options[i].selected = true;
			return;
		}
	}
}

function orderBy(column) {
	var params = getUrlVars();
	if(params == null) {
		window.location.href += "?orderby="+column;
	}
	else if(params['orderby'] == null){
		window.location.href += "&orderby="+column;
	}
	else {
		window.location.href = window.location.href.replace(/orderby\=[^\&]+/,"orderby="+column);
	}
}

function searchArticles(string) {
	//TODO More advanced search?
//	var words = string.split(" ");
//	var search = words[0];
//	for(var i=1; i<words.length; i++) {
//		search += "+"+words[i];
//	}
	var search = encodeURIComponent(string);
	search.replace("&","");
	var params = getUrlVars();
	if(params == null) {
		window.location.href += "?search="+search;
	}
	else if(params['search'] == null){
		window.location.href += "&search="+search;
	}
	else {
		params['search'] = search;
		var i=0;
		var url = "";
		for(var key in params) {
			if(isUnsignedInteger(key)) continue;
			if(i==0) {
				url += "?"+key+"="+params[key];
			}
			else {
				url += "&"+key+"="+params[key];
			}
			i++;
		}
		window.location.href = window.location.pathname + url;
	}
}

function setSearchString(string) {
	$("#search_articles").val(decodeURIComponent(string).replace(/&#3(4|9);/g,"\""));
}

function isUnsignedInteger(s) {
	return (s.toString().search(/^[0-9]+$/) == 0);
}