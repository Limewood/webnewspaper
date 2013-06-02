/**
 * Javascript for the article submission page
 */
$(document).ready(function() {
	$("#submit_headline").select();
	$("#preview_div").hide();
});

function preview() {
	var acceptedBy = "";
	var anonymous = 0;
	if($("#submit_author").text() == "Anonymous") {
		acceptedBy = "Unknown";
		anonymous = 1;
	}
	$.post("ajax/preview.php?r="+Math.random()*5439, {
		headline: $("#submit_headline").val(),
		intro: $("#submit_intro").val(),
		body_text: $("#submit_text").val(),
		image: $("#submit_image_path").val(),
		category: $("#submit_category_select option:selected").text(),
		author: $("#submit_author").text(),
		anonymous: anonymous,
		accepted_by: acceptedBy}, function(html) {
			// format and output result
			$("#preview_div").show();
			$("#preview_div").html(
				html
			);
			document.getElementById("preview_div").scrollIntoView();
		}
	);
}

function clearImage() {
	$("#submit_image_upload").val("");
	uploadedImage("");
}

function uploadImage() {
	document.getElementById("submit_form").submit();
}

function uploadedImage(path) {
	$("#submit_image_path").val(path);
}

function submitArticle() {
	document.getElementById("submit_form").action = "process/process_article.php";
	document.getElementById("submit_form").target = "";
}

function validate() {
	if($("#submit_headline").val() == "" || $("#submit_intro").val() == "" || $("#submit_text").val() == "") {
		alert("Some information is missing!\nYou must fill out the following fields:\n\n*Headline\n*Introduction\n*Article text");
		return false;
	}
	if(confirm("Are you sure you want to submit this article now?")) {
		submitArticle();
		return true;
	}
	return false;
}

function show_guidelines() {
	document.getElementById("guidelines").style.opacity = 1;
	document.getElementById("guidelines").style.height = "310px";
	document.getElementById("guidelines").scrollIntoView();
}

function hide_guidelines() {
	document.getElementById("guidelines").style.opacity = 0;
	document.getElementById("guidelines").style.height = 0;
}
