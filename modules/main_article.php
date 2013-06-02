<?php
require_once("lib/Page.php");
require_once("modules/classes/BasicArticle.php");

$page = new Page("templates/main_article_template.html");

$article = new BasicArticle($_GET['art']);

$page->replace_tags(array(
	"article" => $article->getOutput(),
	"side_news" => "modules/congress_news.php"
));

$page->output();
?>