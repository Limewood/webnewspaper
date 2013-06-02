<?php
require_once("lib/Page.php");
require_once("modules/classes/LatestNews.php");
require_once("modules/classes/InterestingNews.php");
require_once("modules/classes/BigForm.php");
require_once("modules/classes/MediumForm.php");

$page = new Page("templates/main_news_template.html");

$excludes = array(3,6,7,11,13,15);

$big_news = new LatestNews(1, new BigForm(), NULL, $excludes, true);
$medium_news_left = new InterestingNews(1, new MediumForm(), NULL, $excludes, true);
$medium_news_right = new LatestNews(2, new MediumForm(), NULL, $excludes, true);

$page->replace_tags(array(
	"big_news" => $big_news->getOutput(),
	"medium_news_left" => $medium_news_left->getOutput(),
	"medium_news_right" => $medium_news_right->getOutput(),
	"side_news" => "modules/congress_news.php"
));

$page->output();
?>
