<?php
require_once("lib/Page.php");
include_once("config.php");

$page = new Page("templates/main_template.html");

$page->replace_tags(array(
	"head" => "",
	"page_title" => $page_title,
	"header" => "header.php",
	"main_content" => "modules/main_news.php",
	"footer" => "footer.php"
));

$page->output();
?>
