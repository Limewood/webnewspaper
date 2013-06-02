<?php
require_once("lib/Page.php");
require_once("modules/classes/EditorsLog.php");

$page = new Page("templates/main_settings_template.html");
$settings = new EditorsLog();

$page->replace_tags(array(
	"settings" => $settings->getOutput(),
	"side_news" => "modules/congress_news.php"
));

$page->output();
?>
