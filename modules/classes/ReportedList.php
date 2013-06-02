<?php
require_once 'lib/Database.php';
require_once 'modules/classes/LineForm.php';

class ReportedList {
	private $output = "";
	
	public function ReportedList() {
		include('config.php');
		$this->output = "<h2 class=\"editor_section_heading\">Reported articles</h2>";
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT headline, intro, author, accepted_by, uploaded, category, id FROM ".$tableprefix."news WHERE reported_by>-1");
		if(!$result || mysql_num_rows($result) < 1) {
			$this->output .= "<h3>- No reported articles -</h3>";
		}
		else {
			while($row = mysql_fetch_row($result)) {
				list($headline, $intro, $author, $accepted_by, $uploaded, $category, $id) = $row;
				// Get author
				$authorRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$author."' LIMIT 1");
				$authorRow = mysql_fetch_assoc($authorRes);
				$anon = false;
				$accepted = null;
				if($author == 0) {
					$author = $authorRow{'name'};
					$anon = true;
					$accRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$accepted_by."' LIMIT 1");
					$accRow = mysql_fetch_assoc($accRes);
					$accepted = "<a href=\"http://www.nationstates.net/nation=".$accRow{'name'}."\" target=\"blank\">".$accRow{'name'}."</a>";
				}
				else {
					$author = "<a href=\"http://www.nationstates.net/nation=".$authorRow{'name'}."\" target=\"blank\">".$authorRow{'name'}."</a>";
				}
				
				// Get category
				$catRes = mysql_query("SELECT name FROM ".$tableprefix."category WHERE id='".$category."'");
				$catRow = mysql_fetch_assoc($catRes);
				$category = $catRow{'name'};
				
				// Form
				$form = new LineForm();
				
				// Create output
				$this->output .= "<article class=\"".$form->getCSSClass()." divide_below\">\n";
				$this->output .= $form->getHeadline("<a href=\"article.php?art=".$id."\">"
					.$headline
					."</a>\n")
					."<p class=\"published\">\n";
				$this->output .= "<span class=\"category\">".$category."</span> ";
				$this->output .= $form->getPublishInfo($author, $anon, $accepted, $uploaded)
					."\n</p>\n"
					."<p class=\"intro\">\n"
					.$form->getIntro($intro, null)
					."</p>\n";
				global $user_id;
				$this->output .= "<br /><button type=\"button\" onclick=\"accept(".$id.",".$user_id.")\">Accept</button>";
				$this->output .= " <button type=\"button\" onclick=\"deleteArticle(".$id.",".$user_id.")\">Delete</button>";
				$this->output .= "</article>\n";
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
?>
