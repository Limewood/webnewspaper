<?php
require_once("lib/Page.php");
include_once("config.php");
require_once("modules/classes/NewslistModule.php");

include("include/login_sessions.php");

$page = new Page("templates/main_template.html");

$orderby = "uploaded";
$heading = "Latest news";
if(isset($_GET['orderby'])) {
	$orderby = $_GET['orderby'];
	if($orderby == "interesting") {
		$heading = "Most interesting";
	}
	else {
		$order = filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_STRING);
		$heading = "News sorted by ".$order;
	}
}

$filter = new NewsFilter("category", "cat");
		
$controls = 'Category <select id="filter_select" onchange="setCategory(this.options[this.selectedIndex].value)">'.
		$filter->getOutput().
	'</select>';
	if(isset($_GET['cat']) && $_GET['cat'] != 0) {
		$selected_category = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT);
		$controls .= '<script type="text/javascript">'.
			'document.getElementById("filter_select").options['.$selected_category.'].selected = true;'.
			'</script>';
	}

$module = new NewslistModule($heading, 10, $orderby, $controls, null);

$page->replace_tags(array(
	"head" => "<script type=\"text/javascript\" src=\"js/newslist.js\"></script>",
	"page_title" => $page_title,
	"header" => "header.php",
	"login_link" => $login_link,
	"main_content" => $module->getOutput(),
	"footer" => "footer.php"
));

$page->output();
?>