<?php
class DB {
	private $db;

	public function __construct($hostname, $username, $password, $database, $port = NULL) {
        $this->db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	}

	public function query($sql) {
		return $this->db->query($sql);
	}
	
	public function prepare($sql) {
		return $this->db->prepare($sql);
	}

	public function execute($sql) {
		return $this->db->exec($sql);
	}
}