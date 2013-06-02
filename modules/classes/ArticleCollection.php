<?php
require_once("lib/Database.php");
require_once('modules/classes/VoteCounter.php');

class ArticleCollection {
	private $output = "";
	private $conn;
	private $form;
	private $show_category;
	
	public function ArticleCollection($nr_articles, $form_class, $orderby, $include, $exclude, $show_category, $search) {
		// Connect to database
		$this->conn = Database::getInstance()->getConnection();
		require_once("modules/classes/".$form_class.".php");
		$this->form = new $form_class;
		$this->show_category = $show_category;
		
		$cat = null;
		if(isset($_GET['cat'])) {
			$cat = filter_input(INPUT_GET, "cat", FILTER_VALIDATE_INT);
		}
		
		$where = "";
		if($include != null && count($include) > 0) {
			if(is_array($include)) {
				$where = " WHERE (category='".$include[0]."'";
				$count = count($include);
				if($count > 1) {
					for($i=1; $i<$count; $i++) {
						$where .= " || category='".$include[$i]."'";
					}
				}
				$where .= ")";
			}
			else {
				$where = " WHERE category='".$include."'";
			}
		}
		else if($cat != null) {
			$where = " WHERE category='".$_GET['cat']."'";
		}
		if($exclude != null && count($exclude) > 0) {
			if(is_array($exclude)) {
				$where = " WHERE (category!='".$exclude[0]."'";
				$count = count($exclude);
				if($count > 1) {
					for($i=1; $i<$count; $i++) {
						$where .= " && category!='".$exclude[$i]."'";
					}
				}
				$where .= ")";
			}
			else {
				$where = " WHERE category!='".$exclude."'";
			}
		}
		// Filter for search string
		if($search != null && $search != "") {
			if($where != "") {
				$where .= " && MATCH(headline, intro, body_text) AGAINST('".$search."' IN BOOLEAN MODE)";
			}
			else {
				$where = " WHERE MATCH(headline, intro, body_text) AGAINST('".$search."' IN BOOLEAN MODE)";
			}
		}
		
		// Exclude not-accepted news submitted by an anonymous source
		if($where != "") {
			$where .= " && (author!=0 || accepted_by!=-1)";
		}
		else {
			$where = " WHERE author!=0 || accepted_by!=-1";
		}
		
		$this->addArticles($nr_articles, $orderby, $where, $show_category);
	}
	
	private function addArticles($nr_articles, $orderby, $where) {
		include 'config.php';
		// Check that $orderby is a valid column
		// Too slow in MySQL
//		if($orderby != null) {
//			$result = mysql_query("SELECT column_name FROM information_schema.columns WHERE table_name='".$tableprefix."news'");
//			$found = false;
//			while($row = mysql_fetch_assoc($result)) {
//				if($row['column_name'] == $orderby) {
//					$found = true;
//					break;
//				}
//			}
//			if(!$found) {
//				$this->output = "You have chosen an invalid ordering column!";
//				return;
//			}
//		}
	
		if($orderby == null) {
			$orderby = " ORDER BY uploaded DESC";
		}
		else if ($orderby == "uploaded") {
			$orderby = " ORDER BY ".$orderby." DESC";
		}
		else {
			$orderby = " ORDER BY ".$orderby." DESC, uploaded DESC";
		}
		
		$result = mysql_query("SELECT id, headline, intro, body_text, image,"
			." author, accepted_by, uploaded, interesting, category"
			." FROM ".$tableprefix."news".$where.$orderby." LIMIT ".$nr_articles);
		if(!$result || mysql_num_rows($result) == 0) {
			$this->output = "<h2>There's been a lack of news lately...</h2>";
			return;
		}
		while($row = mysql_fetch_assoc($result)) {
			// Add an article to the output
			$this->output .= "<article class=\"".$this->form->getCSSClass()." divide_below\">\n";
			
			$this->output .= $this->formatArticle($row);
			
			$this->output .= "</article>\n";
		}
	}
	
	private function formatArticle($row) {
		include 'config.php';
		// Get author
		$authorRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$row{'author'}."' LIMIT 1");
		$authorRow = mysql_fetch_assoc($authorRes);
		$anon = false;
		$accepted = null;
		if($row{'author'} == 0) {
			$author = $authorRow{'name'};
			$anon = true;
			$accRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$row{'accepted_by'}."' LIMIT 1");
			$accRow = mysql_fetch_assoc($accRes);
			$accepted = "<a href=\"http://www.nationstates.net/nation=".$accRow{'name'}."\" target=\"blank\">".$accRow{'name'}."</a>";
		}
		else {
			$author = "<a href=\"http://www.nationstates.net/nation=".$authorRow{'name'}."\" target=\"blank\">".$authorRow{'name'}."</a>";
		}
		// Get uploaded date
		$date = $row{'uploaded'};
		
		// Get category
		$catRes = mysql_query("SELECT name FROM ".$tableprefix."category WHERE id='".$row{'category'}."'");
		$catRow = mysql_fetch_assoc($catRes);
		$category = $catRow{'name'};
		
		// Create output
		$str = $this->form->getHeadline("<a href=\"article.php?art=".$row{'id'}."\">"
			.$row{'headline'}
			."</a>\n")
			."<p class=\"published\">\n";
		if($this->show_category) {
			$str .= "<span class=\"category\">".$category."</span> ";
		}
		$str .= $this->form->getPublishInfo($author, $anon, $accepted, $date)
			."\n</p>\n"
			."<p class=\"intro\">\n"
			.$this->form->getIntro($row{'intro'}, $row{'image'})
			."</p>\n";
			$vote = new VoteCounter($row{'id'}, false);
			$this->output .= $vote->getOutput();
		return $str;
	}
	
	public function getOutput() {
		return $this->output;
	}
}
