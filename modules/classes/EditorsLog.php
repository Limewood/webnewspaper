<?php
require_once 'lib/Database.php';

class EditorsLog {
	private $output = "";
	
	public function EditorsLog() {
		include('config.php');
		$conn = Database::getInstance()->getConnection();
		$result = mysql_query("SELECT user_id, logged_in FROM ".$tableprefix."sessions WHERE session_id='".$_COOKIE['sid']."' LIMIT 1");
		$row = mysql_fetch_assoc($result);
		if(!$row['logged_in']) {
			$this->output = "<h2>Please log in to use this page</h2>";
		}
		else {
			$this->output = "<h2>Editors' Log</h2>";
			$conn = Database::getInstance()->getConnection();
			$result = mysql_query("SELECT a.name AS name, e.action AS action, e.time AS time, e.description AS description FROM ".$tableprefix."editors_log e LEFT JOIN ".$tableprefix."authors a ON e.editor=a.id ORDER BY time DESC");
			$this->output .= "<a href='editor.php'>Back to Editor's Desk</a><br /><br />";
			if(!$result || mysql_num_rows($result) < 1) {
				$this->output .= "<h3>No log available</h3>";
			}
			else {
				$this->output .= "<table class='editors_log'><tr><th>Time</th><th>Editor</th><th>Action</th><th>Description</th></tr>";
				while($row = mysql_fetch_row($result)) {
					list($name, $action, $time, $description) = $row;
				
					// Create output
					$this->output .= "<tr class=\"divide_below\">\n";
					$this->output .= "<td>".$time."</td><td>".$name."</td><td>".$action."</td><td>".$description."</td>";
					$this->output .= "</tr>\n";
				}
				$this->output .= "</table>";
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}
?>
