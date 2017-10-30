<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
 
    public $id;
    public $name;
    public $description;
    public $created;
	public $modified;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read products
	public function read(){
	 
		// select all query
		$query = "SELECT
					id, name, description, created, modified
				FROM
					" . $this->table_name . "
				ORDER BY
					created DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}