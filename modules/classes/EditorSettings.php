<?php
require_once("lib/Database.php");
require_once("AnonymousList.php");
require_once("ReportedList.php");

class EditorSettings {
	private $output;
	
	public function EditorSettings() {
		include("config.php");
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT user_id, logged_in FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."' LIMIT 1");
		$row = mysql_fetch_assoc($result);
		if(!$row['logged_in']) {
			$this->output = "<h2>Please log in to use this page</h2>";
		}
		else {
			$result = mysql_query("SELECT name, email, new_email, is_editor, is_admin FROM ".$tableprefix."authors WHERE id='".$row['user_id']."' LIMIT 1");
			$row = mysql_fetch_assoc($result);
			if(!$row['is_editor']) {
				$this->output = "<h2>Only editors can access this page</h2>";
				$this->output .= "<p><a href=\"settings.php\">Back to settings</a></p><br />";
			}
			else {
				$this->output = "<h1>Editor's Desk</h1>";
				$this->output .= "<p><a href=\"settings.php\">Back to settings</a>";
				$this->output .= "&nbsp;&nbsp;&nbsp;<a href=\"editors_log.php\">Editors' Log</a></p><br />";
				// Show anonymous articles not yet accepted
				$anon = new AnonymousList();
				$this->output .= "<section id=\"editor_left\" class=\"divide_right\">".$anon->getOutput()."</section>";
				// Show reported articles
				$report = new ReportedList();
				$this->output .= "<section id=\"editor_right\">".$report->getOutput()."</section>";
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
