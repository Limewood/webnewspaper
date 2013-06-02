<?php
require_once("lib/Page.php");
include_once("config.php");

include("include/login_sessions.php");

$page = new Page("templates/main_template.html");

$page->replace_tags(array(
	"head" => "<script type=\"text/javascript\" src=\"js/admin.js\"></script>",
	"page_title" => $page_title,
	"header" => "header.php",
	"login_link" => $login_link,
	"main_content" => "modules/admin_settings.php",
	"footer" => "footer.php"
));

$page->output();
?>