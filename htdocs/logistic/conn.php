<?php

class conn {
	// basic parameter
	private $SERVERNAME = 'localhost';
	private $USERNAME = 'root';
	private $PASSWORD = 'liaozhou1998';
	private $DBNAME = 'coldplay';

	function __construct() {
		$num = func_num_args();
		$args = func_get_args();

		if ($num == 4) {
			$this->SERVERNAME = $args[0];
			$this->USERNAME = $args[1];
			$this->PASSWORD = $args[2];
			$this->DBNAME = $args[3];
		}
		elseif ($num == 0) {
			// do nothing
		}
	}

	public function getConn() {
		try {
			$conn = new PDO("mysql:host=$this->SERVERNAME;dbname=$this->DBNAME", $this->USERNAME, $this->PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return null;
		}
		return $conn;
	}
}
?>