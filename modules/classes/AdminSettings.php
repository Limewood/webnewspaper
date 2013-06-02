<?php
require_once("lib/Database.php");

class AdminSettings {
	private $output;
	
	public function AdminSettings() {
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
			if(!$row['is_admin']) {
				$this->output = "<h2>Only admins can access this page</h2>";
			}
			else {
				$this->output = "<h1>Admin page</h1>";
				$this->output .= "<p><a href=\"settings.php\">Back to settings</a></p>";
				$this->output .= "<br /><button type=\"button\" onclick=\"createAuthor()\">Create Author</button>";
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}