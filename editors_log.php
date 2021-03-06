<?php
require_once("lib/Page.php");
include_once("config.php");

include("include/login_sessions.php");

$page = new Page("templates/main_template.html");

$page->replace_tags(array(
	"head" => "<script type=\"text/javascript\" src=\"js/editor.js\"></script>".
				"<script type=\"text/javascript\" src=\"js/article.js\"></script>",
	"page_title" => $page_title." - Editors' Log",
	"header" => "header.php",
	"login_link" => $login_link,
	"main_content" => "modules/editors_log.php",
	"footer" => "footer.php"
));

$page->output();
?>
