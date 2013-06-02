<?php
require_once("lib/Page.php");
require_once("modules/classes/LatestNews.php");
require_once("modules/classes/InterestingNews.php");
require_once("modules/classes/SmallForm.php");

$page = new Page("templates/congress_news_template.html");

$includes = array(3,6,7,11,13,15);

$top_news = new LatestNews(1, new SmallForm(), $includes, NULL, false);
$middle_news = new InterestingNews(1, new SmallForm(), $includes, NULL, false);
$bottom_news = new LatestNews(2, new SmallForm(), $includes, NULL, false);

$page->replace_tags(array(
	"top_news" => $top_news->getOutput(),
	"middle_news" => $middle_news->getOutput(),
	"bottom_news" => $bottom_news->getOutput()
));

$page->output();
?>
