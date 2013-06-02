<?php
class Database {
	private static $instance;
	
	public static function getInstance() {
	    if (!self::$instance) {
	        self::$instance = new Database();
	    }
	    return self::$instance;
	}
	
	private function Database() {}
	
	public function getConnection() {
		$root = realpath($_SERVER["DOCUMENT_ROOT"]."/newspaper");
		include($root.'/config.php');
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to database');

		mysql_select_db($dbname);
		
		return $conn;
	}
}
?>