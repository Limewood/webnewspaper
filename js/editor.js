/**
 * Editor functions
 */

function accept(id, editor) {
	if(confirm("Do you want to accept this article?")) {
		$.post("ajax/accept.php?r="+Math.random()*5439, {
			id: id,
			editor: editor}, function(xml) {
				if($("success", xml).text() == "true") {
					alert("Article accepted!");
					window.location.reload();
				}
				else {
					alert("An error occurred! Please inform an admin or try again.\n"+$("error", xml).text());
				}
			}
		);
	}
}

function reportArticle(id, editor) {
	if(confirm("Do you want to report this article?")) {
		$.post("ajax/report.php?r="+Math.random()*5439, {
			id: id,
			editor: editor}, function(xml) {
				if($("success", xml).text() == "true") {
					alert("Article reported!");
					window.location.reload();
				}
				else {
					alert("An error occurred! Please inform an admin or try again.\n"+$("error", xml).text());
				}
			}
		);
	}
}

function deleteArticle(id, editor) {
	if(confirm("Do you want to delete this article?")) {
		$.post("ajax/deleteArticle.php?r="+Math.random()*5439, {
			id: id,
			editor: editor}, function(xml) {
				if($("success", xml).text() == "true") {
					alert("Article deleted!");
					window.location.reload();
				}
				else {
					alert("An error occurred! Please inform an admin or try again.\n"+$("error", xml).text());
				}
			}
		);
	}
}
