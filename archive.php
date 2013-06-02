<?php
require_once("lib/Page.php");
include_once("config.php");
require_once("modules/classes/NewslistModule.php");

include("include/login_sessions.php");

$page = new Page("templates/main_template.html");

$orderby = "uploaded";
if(isset($_GET['orderby'])) {
	$orderby = filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_STRING);
}
$num = 10;
if(isset($_GET['num'])) {
	$num = filter_input(INPUT_GET, 'num', FILTER_VALIDATE_INT);
}
$search = null;
if(isset($_GET['search'])) {
	$search = str_replace ("&quot;", "\"", filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));
}

$controls = "<br /><form action=\"\" onsubmit=\"return false\">".
	"Search <input type=\"text\" name=\"search_articles\" id=\"search_articles\" value=\"\" /> ".
	"<button type=\"submit\" onclick=\"searchArticles($('#search_articles').val())\">Search</button> ";
$controls .= '<script type="text/javascript">'.
	'setSearchString("'.$search.'")'.
	'</script>';
$controls .= "Number of articles to show: <select name=\"num_articles\" id=\"num_articles\" onchange=\"setNumArticles(this.options[this.selectedIndex].value)\">";
for($i=10; $i<100; $i+=10) {
	$controls .= "<option value=\"".$i."\">".$i."</option>";
}
$controls .= "<option value=\"99999\">All</option></select>";
$controls .= '<script type="text/javascript">'.
	'selectNum("'.$num.'")'.
	'</script>';
$controls .= "<br /><br />Order by <select name=\"order_by\" id=\"order_by\" onchange=\"orderBy(this.options[this.selectedIndex].value)\">".
	"<option value=\"uploaded\">Latest</option>".
	"<option value=\"interesting\">Interest</option>".
	"<option value=\"category\">Category</option>".
	"</select>";
	if(isset($_GET['orderby'])) {
		$controls .= '<script type="text/javascript">'.
		'selectOrderBy("'.$orderby.'")'.
		'</script>';
	}
$filter = new NewsFilter("category", "cat");
		
$controls .= ' Category <select id="filter_select" onchange="setCategory(this.options[this.selectedIndex].value)">'.
		$filter->getOutput().
	'</select>';
	if(isset($_GET['cat']) && $_GET['cat'] != 0) {
		$selected_category = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT);
		$controls .= '<script type="text/javascript">'.
			'document.getElementById("filter_select").options['.$selected_category.'].selected = true;'.
			'</script>';
	}
$controls .= "</form>";

$module = new NewslistModule("Archive", $num, $orderby, $controls, $search);

$page->replace_tags(array(
	"head" => "<script type=\"text/javascript\" src=\"js/newslist.js\"></script>".
		"<script type=\"text/javascript\" src=\"js/archive.js\"></script>",
	"page_title" => $page_title,
	"header" => "header.php",
	"login_link" => $login_link,
	"main_content" => $module->getOutput(),
	"footer" => "footer.php"
));

$page->output();
?>