<?php
require_once '../modules/classes/BasicArticle.php';

$headline = filter_input(INPUT_POST, "headline", FILTER_SANITIZE_STRING);
$intro = nl2br(filter_input(INPUT_POST, "intro", FILTER_SANITIZE_STRING));
$body_text = nl2br(filter_input(INPUT_POST, "body_text", FILTER_SANITIZE_STRING));
$author = filter_input(INPUT_POST, "author", FILTER_SANITIZE_STRING);
$anonymous = filter_input(INPUT_POST, "anonymous", FILTER_VALIDATE_INT);
$accepted_by = filter_input(INPUT_POST, "accepted_by", FILTER_SANITIZE_STRING);
$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);
$image = filter_input(INPUT_POST, "image", FILTER_SANITIZE_STRING);

$article = new BasicArticle(0,
							$headline,
							$intro,
							$body_text,
							$image,
							$author,
							$anonymous,
							$accepted_by,
							date('Y-m-d H:i:s'),
							0,
							$category);
header('Content-type: text/html');
echo "<article class=\"main_article clearfix\">".$article->getOutput()."</article>";
?>
