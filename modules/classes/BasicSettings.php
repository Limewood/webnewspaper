<?php
require_once("lib/Database.php");

class BasicSettings {
	private $output;
	
	public function BasicSettings() {
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
			$this->output = "<h1>Settings for ".$row['name']."</h1>";
			if($row['is_editor'] || $row['is_admin']) {
				$this->output .= "<p>";
			}
			if($row['is_editor']) {
				$this->output .= "<a href=\"editor.php\">Editor's Desk</a>\n";
			}
			if($row['is_admin']) {
				$this->output .= " | <a href=\"admin.php\">Admin page</a>\n";
			}
			if($row['is_editor'] || $row['is_admin']) {
				$this->output .= "</p>";
			}
			$this->output .= "<br /><br /><form name=\"settings_form\" action=\"process/changeSettings.php\" method=\"post\" onsubmit=\"return checkPasswords(this)\">".
				"<h3>Email".(isset($_GET['email_sent']) ? " <span style=\"font-size: smaller; color: red\">- verification email sent!</span>" : "")."</h3>".
				"<input type=\"text\" id=\"settings_email\" name=\"settings_email\" onchange=\"validate(this.id, this.value)\" onblur=\"validate(this.id, this.value)\" size=\"40\" value=\"".$row['email']."\" /> ".
				"<span id=\"settings_email_status\"></span><br />\n";
			if($row['new_email'] != "") {
				$this->output .= "Email awaiting verification: ".$row['new_email']."<br />";
			}
			$this->output .= "<br /><h3>Password".(isset($_GET['password_changed']) ? " <span style=\"font-size: smaller; color: red\">- password changed!</span>" : "")."</h3>".
				"<input type=\"password\" id=\"settings_password\" name=\"settings_password\" onchange=\"validate(this.id, this.value)\" onblur=\"validate(this.id, this.value)\" size=\"40\" /> ".
				"<span id=\"settings_password_status\">New</span><br /><br />\n".
				"<input type=\"password\" id=\"settings_password_repeat\" name=\"settings_password_repeat\" onchange=\"validate(this.id, this.value)\" onblur=\"validate(this.id, this.value)\" size=\"40\" /> ".
				"<span id=\"settings_password_repeat_status\">Again</span><br /><br />\n".
				"<button type=\"submit\">Submit changes</button>".
				"</form>";
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
