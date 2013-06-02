<?php
require_once('lib/Database.php');
require_once('modules/classes/VoteCounter.php');

class BasicNews {
	private static $shown_news = "";
	
	private $nr;
	private $where = "";
	private $orderby = null;
	private $output = "";
	private $show_category = true;
	private $form;
	
	public function BasicNews($nr, $form, $include, $exclude, $orderby, $show_category) {
		$this->nr = $nr-1;
		$this->form = $form;
		if($include != null && count($include) > 0) {
			if(is_array($include)) {
				$this->where = " WHERE (category='".$include[0]."'";
				$count = count($include);
				if($count > 1) {
					for($i=1; $i<$count; $i++) {
						$this->where .= " || category='".$include[$i]."'";
					}
				}
				$this->where .= ")";
			}
			else {
				$this->where = " WHERE category='".$include."'";
			}
		}
		if($exclude != null && count($exclude) > 0) {
			if(is_array($exclude)) {
				$this->where = " WHERE (category<>'".$exclude[0]."'";
				$count = count($exclude);
				if($count > 1) {
					for($i=1; $i<$count; $i++) {
						$this->where .= " && category<>'".$exclude[$i]."'";
					}
				}
				$this->where .= ")";
			}
			else {
				$this->where = " WHERE category<>'".$exclude."'";
			}
		}
		// Exclude not-accepted news submitted by an anonymous source
		if($this->where != "") {
			$this->where .= " && (author<>0 || accepted_by<>-1)";
		}
		else {
			$this->where = " WHERE author<>0 || accepted_by<>-1";
		}
		if($orderby == null) {
			$this->orderby = " ORDER BY uploaded DESC";
		}
		else if ($orderby == "uploaded") {
			$this->orderby = " ORDER BY ".$orderby." DESC";
		}
		else {
			$this->orderby = " ORDER BY ".$orderby." DESC, uploaded DESC";
		}
		$this->show_category = $show_category;
		
		$this->queryDatabase();
	}
	
	private function queryDatabase() {
		include("config.php");
		// Connect to database to get news article
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT id, headline, intro, image,"
			." author, accepted_by, uploaded, interesting, category"
			." FROM ".$tableprefix."news".$this->where.$this->orderby." LIMIT ".$this->nr.",250");
		if(!$result) {
			die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result) == 0) {
			$this->output = "No news";
		}
		else {
			$row;
			if(self::$shown_news != "") {
				if(strpos(self::$shown_news, ",") != false) {
					$arr = explode(",", self::$shown_news);
					do {
						$found = false;
						$row = mysql_fetch_assoc($result);
						foreach($arr as $id) {
							if($id == $row{'id'}) {
								$found = true;
								break;
							}
						}
					} while($found == true);
				}
				else {
					$row = mysql_fetch_assoc($result);
					if(self::$shown_news == $row{'id'}) {
						$row = mysql_fetch_assoc($result);
					}
				}
			}
			else {
				$row = mysql_fetch_assoc($result);
			}
			if($row['accepted_by'] == 0) {
				$this->output = "No news";
				return;
			}
			if(self::$shown_news != "") {
				self::$shown_news .= ",".$row{'id'};
			}
			else {
				self::$shown_news = $row{'id'};
			}
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
			$this->output = $this->form->getHeadline("<a href=\"article.php?art=".$row{'id'}."\">"
				.$row{'headline'}
				."</a>\n")
				."<p class=\"published\">\n";
			if($this->show_category) {
				$this->output .= "<span class=\"category\">".$category."</span> ";
			}
			$this->output .= $this->form->getPublishInfo($author, $anon, $accepted, $date)
				."\n</p>\n"
				."<p class=\"intro\">\n"
				.$this->form->getIntro($row{'intro'}, "images/".$row{'image'})
				."</p>\n";
			$vote = new VoteCounter($row{'id'}, false);
			$this->output .= $vote->getOutput();
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
?>
