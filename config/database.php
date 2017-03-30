<?php 
class Database{
	private $host = "localhost";
	private $databaseName = "codeofaninja_api_db";
	private $username = "root";
	private $password = "";
	public $conn;

	public function getConnection(){
		$this->conn = null;
		try{
			$this->conn =  new PDO("mysql:host=".$this->host.";dbname=".$this->databaseName,$this->username, $this->password);
    // set the PDO error mode to exception
    		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    		
		}
		catch(PDOException $exception){
			echo "Connection Error: " .$exception->getMessage();
		}
		return $this->conn;
	}
}