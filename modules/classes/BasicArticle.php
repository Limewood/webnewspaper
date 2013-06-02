<?php
class BasicArticle {
	private $output = "";
	private $headline;
	private $intro;
	private $body_text;
	private $image;
	private $author_name;
	private $anon;
	private $accepted_name;
	private $uploaded;
	private $interesting;
	private $category;
	
	public function BasicArticle($id, $headline = "", $intro = "", $body_text = "",
						$image = "", $author_name = "", $anon = false,
						$accepted_name = "", $uploaded = 0,
						$interesting = 0, $category = "") {
		if($id > 0) {
			$this->fetchArticle($id);
		}
		else {
			$this->headline = $headline;
			$this->intro = $intro;
			$this->body_text = $body_text;
			$this->image = $image;
			$this->author_name = $author_name;
			$this->anon = $anon;
			$this->accepted_name = $accepted_name;
			$this->uploaded = $uploaded;
			$this->interesting = $interesting;
			$this->category = $category;
			$this->createOutput();
		}
	}
	
	private function fetchArticle($id) {
		$root = realpath($_SERVER["DOCUMENT_ROOT"]."/newspaper");
		require_once($root."/lib/Database.php");
		require_once($root.'/modules/classes/VoteCounter.php');
		include($root.'/config.php');
		// Connect to database to get news article
		$conn = Database::getInstance()->getConnection();
		
		$filter = " && (author!=0 || accepted_by!=-1)";
		global $is_editor;
		if($is_editor) {
			$filter = "";
		}
		$result = mysql_query("SELECT headline, intro, body_text, image,"
			." author, accepted_by, uploaded, interesting, category"
			." FROM ".$tableprefix."news WHERE id='".$id."'".$filter." LIMIT 1");
		if(!$result || mysql_num_rows($result) == 0) {
			$this->output = "<h3>No article with that id!</h3>";
			return;
		}
		$row = mysql_fetch_row($result);
		list($this->headline, $this->intro, $this->body_text, $this->image, $author, $accepted_by, $this->uploaded, $this->interesting, $category) = $row;
		
		$editor_info = "";
		if($is_editor && $author == 0 && $accepted_by == -1) {
			$editor_info = "<br /><span class=\"editor_info\">This article has not yet been accepted. You can accept it at the <a href=\"editor.php\">Editor's desk</a>.</span>";
		}
		$this->headline .= $editor_info;
		
		// Get category
		$catRes = mysql_query("SELECT name FROM ".$tableprefix."category WHERE id='".$category."'");
		$catRow = mysql_fetch_assoc($catRes);
		$this->category = $catRow{'name'};
		
		// Get author
		$authorRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$author."' LIMIT 1");
		$authorRow = mysql_fetch_assoc($authorRes);
		$this->anon = false;
		if($author == 0) {
			$this->author_name = $authorRow['name'];
			$this->anon = true;
			$accRes = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$accepted_by."' LIMIT 1");
			$accRow = mysql_fetch_assoc($accRes);
			$this->accepted_name = $accRow['name'];
		}
		else {
			$this->author_name = $authorRow['name'];
		}
		
		$this->createOutput();
		
		$vote = new VoteCounter($id, true);
		$this->output .= $vote->getOutput();
	}
	
	private function createOutput() {
		$quote = new Quote($this->body_text);
		
		$accepted_link = "";
		$author_link = "";
		if($this->anon) {
			$author_link = $this->author_name;
			if($this->accepted_name != "") {
				$accepted_link = "accepted by <a href=\"http://www.nationstates.net/nation=".$this->accepted_name."\" target=\"blank\">".$this->accepted_name."</a>";
			}
			else {
				$accepted_link = "NOT ACCEPTED";
			}
		}
		else {
			$author_link = "<a href=\"http://www.nationstates.net/nation=".$this->author_name."\" target=\"blank\">".$this->author_name."</a>";
		}
		
		$this->output = "<h1>\n"
			.$this->headline
			."</h1>\n"
			."<p class=\"published\">\n"
			."<span class=\"category\">".$this->category."</span> "
			.$author_link.($this->anon ? " (".$accepted_link.") " : " ")
			.$this->uploaded
			."\n</p>\n"
			."<p class=\"article_intro\">\n";
		if($this->image != "") {
			$this->output .= "<img src=\"images/".$this->image."\" />\n";
		}
		$this->output .= $this->intro."<br />\n"
			."</p>\n"
			."<span class=\"body_text\">\n";
		if($quote != "") {
			$this->output .= "<aside class=\"quote\">".$quote->getQuote()."</aside>";
		}
		$this->output .= $this->body_text."\n"
			."</span>\n";
	}
	
	public function getOutput() {
		return $this->output;
	}
}

class Quote {
	private $str;
	private $quote = "";
	private $marks = array('.', '?', '!');
	
	public function Quote($str) {
		$this->str = $str;
		$this->pullQuote();
	}
	
	private function pullQuote() {
		if($this->str == "") return;
		// Get a random punctuation mark that exists in the text
		$mark = null;
		$len = count($this->marks);
		$oldrand = -1;
		$count = 0;
		while($mark == null && $count < 9) {
			$count++;
			do {
				$random = rand(0, $len-1);
			} while($oldrand == $random);
			for($i=$random; $i<$len; $i++) {
				if(substr_count($this->str, $this->marks[$i]) > 0) {
					$mark = $this->marks[$i];
					break;
				}
			}
		}
		
		if($mark != null) {
			// How many of this punctuation mark are there in the text?
			$num = substr_count($this->str, $mark);
			
			$random = mt_rand(0,$num-1);
			$arr = explode($mark, $this->str, $random+2);
			$this->str = $arr[$random];
			// Remove other sentences ending in other punctuation marks
			foreach($this->marks as $val) {
				if($val == $mark) continue;
				if(substr_count($this->str, $val) > 0) {
					$this->str = substr($this->str, strrpos($this->str, $val)+1);
				}
			}
			$this->quote = "\"".trim(str_replace("<br />","",$this->str)).$mark."\"";
		}
		else {
			$this->quote = $this->str;
		}
	}
	
	public function getQuote() {
		return $this->quote;
	}
}
