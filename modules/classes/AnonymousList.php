<?php
require_once 'lib/Database.php';
require_once 'modules/classes/LineForm.php';

class AnonymousList {
	private $output = "";
	
	public function AnonymousList() {
		include('config.php');
		$this->output = "<h2 class=\"editor_section_heading\">Anonymous articles</h2>";
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT headline, intro, uploaded, category, id FROM ".$tableprefix."news WHERE author=0 && accepted_by=-1 && reported_by=-1 ORDER BY uploaded ASC");
		if(!$result || mysql_num_rows($result) < 1) {
			$this->output .= "<h3>No submitted articles</h3>";
		}
		else {
			while($row = mysql_fetch_row($result)) {
				list($headline, $intro, $uploaded, $category, $id) = $row;
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
				$this->output .= $form->getPublishInfo("Anonymous (Not accepted)", false, null, $uploaded)
					."\n</p>\n"
					."<p class=\"intro\">\n"
					.$form->getIntro($intro, null)
					."</p>\n";
				global $user_id;
				$this->output .= "<br /><button type=\"button\" onclick=\"accept(".$id.",".$user_id.")\">Accept</button>";
				$this->output .= " <button type=\"button\" onclick=\"reportArticle(".$id.",".$user_id.")\">Report</button>";
				$this->output .= "</article>\n";
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
?>
