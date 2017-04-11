<?php 
class Product{
	private $conn;
	private $tableName = "products";

	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $category_name;
	public $created;

	public function __construct($db){
		$this->conn = $db;
	}
	
	public function read(){
		$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM ". $this->tableName ." p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function create(){
		// query to insert record
		$query = "INSERT into " . $this->tableName . " SET name = :name,price = :price,description = :description, category_id = :category_id, created = :created";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->created = htmlspecialchars(strip_tags($this->created));

		// bind values
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category_id", $this->category_id);
		$stmt->bindParam(":created", $this->created);

		// execute query	
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function readSingleRecord(){
		$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM "  . $this->tableName . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1" ;
    	 
//die($query);
		$stmt = $this->conn->prepare($query);
		
		$stmt->bindParam(1, $this->id);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->price = $row['price'];
		$this->category_id = $row['category_id'];
		$this->category_name = $row['category_name'];
	}

	public function updateProduct(){
		$query = "UPDATE " .$this->tableName . " SET name = :name, price = :price, description = :description, category_id = :category_id WHERE id = :id";

		$stmt = $this->conn->prepare($query);

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->id = htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->bindParam(':id', $this->id);

		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteProduct(){
		$query = "DELETE FROM " . $this->tableName ." WHERE id = ?";		
		$stmt = $this->conn->prepare($query);
		$this->id = htmlspecialchars(strip_tags($this->id));
		$stmt->bindParam(1,$this->id);
		if($stmt->execute()){
			return true;
		}
		return false;
	}
}
?>