<?php
require_once("lib/Database.php");

class NewsFilter {
	private $output = "";
	
	public function NewsFilter($column, $parameter_name) {
		$this->createOutput($column, $parameter_name);
	}
	
	private function createOutput($column, $parameter_name) {
		include 'config.php';
		// Connect to database to get category names
		$conn = Database::getInstance()->getConnection();
		
		$this->output .= "<option value=''>All</option>";
		
		$res = mysql_query("SELECT id, name FROM ".$tableprefix.$column);
		while($row = mysql_fetch_assoc($res)) {
			$this->output .= "<option value='".$row{'id'}."'>".$row{'name'}."</option>";
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}