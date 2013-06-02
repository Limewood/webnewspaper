<?php
class VoteCounter {
	private $output = "";
	private $id;
	private $allow_voting;
	
	public function VoteCounter($id, $allow_voting) {
		$this->id = $id;
		$this->allow_voting = $allow_voting;
		
		$this->buildCounter();
	}
	
	private function buildCounter() {
		$root = realpath($_SERVER["DOCUMENT_ROOT"]."/newspaper");
		require_once($root."/lib/Database.php");
		include($root.'/config.php');
		// Get accumulated votes
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT interesting FROM ".$tableprefix."news WHERE id='".$this->id."'");
		$row = mysql_fetch_assoc($result);
		
		$this->output .= "<div id=\"vote".$this->id."\" class=\"vote clearfix\"><img src=\"images/interesting.png\" alt=\"i\" title=\"The number of readers who found this article interesting.\"/><span class=\"vote_count\">".$row{'interesting'}."</span></div>";
		
		// Check if this IP address already voted
		$result = mysql_query("SELECT voted FROM ".$tableprefix."news WHERE id=".$this->id);
		$row = mysql_fetch_assoc($result);
		$ips = $row['voted'];
		
		if($this->allow_voting && strstr($ips, $_SERVER['REMOTE_ADDR']) == false) {
		$this->output .= "<script type=\"text/javascript\">
			$(document).ready(function() {
		   	// generate markup
			   $(\"#vote".$this->id." > .vote_count\").append(\"<a href='#'><img src=\\\"images/vote.png\\\" class=\\\"cast_vote\\\" alt=\\\"+\\\" /></a> \");
			   
			   // add markup to container and apply click handler to anchor
			   $(\"#vote".$this->id." a\").click(function(e){
			     // stop normal link click
			     e.preventDefault();
			     
			     // send request
			     $.post(\"ajax/vote.php?r=".rand(0, 54321)."\", {id: ".$this->id."}, function(xml) {
			       // format and output result
			       $(\"#vote".$this->id." > .vote_count\").html(
			         $(\"votes\", xml).text()
			       );
			     });
			   });
			});</script>";
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}