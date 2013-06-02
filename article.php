<?php
require_once("lib/Page.php");

include("include/login_sessions.php");

$page = new Page("templates/main_template.html");

$page->replace_tags(array(
	"head" => "<script type=\"text/javascript\" src=\"js/article.js\"></script>",
	"page_title" => "Solidarity",
	"header" => "header.php",
	"login_link" => $login_link,
	"main_content" => "modules/main_article.php",
	"footer" => "footer.php"
));

$page->output();
?>