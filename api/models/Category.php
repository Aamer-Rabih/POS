<?php
class Category {
	// DB stuff
	private $conn;
	private $table = 'category';

	// Category Properties
	public $categoryid;
	public $category_name;

	// Constructor with DB
	public function __construct($db) {
	  $this->conn = $db;
	}

	// Get All Categories
	public function read() {
	  // Create query
	  $query = '
	  	SELECT
	  		categoryid, category_name
	  	FROM 
	  		category;
	  ';
	  
	  // Prepare statement
	  $stmt = $this->conn->prepare($query);

	  // Execute query
	  $stmt->execute();

	  return $stmt;
	}

	// Get Single Category
	public function read_single() {
	      // Create query
	      $query = '
	      	SELECT
	      		categoryid, category_name
	      	FROM 
	      		category
	      	WHERE categoryid = :categoryid ;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));

	      // Bind ID
	      $stmt->bindParam('categoryid', $this->categoryid);

	      // Execute query
	      $stmt->execute();

	      $row = $stmt->fetch(PDO::FETCH_ASSOC);

	      // Set properties
	      $this->category_name = $row['category_name'];
	}

	// Create Category
	public function create() {
	      // Create query
	      $query = '
	      	INSERT INTO category
	      	SET categoryid = :categoryid,
	      		category_name = :category_name;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
	      $this->category_name = htmlspecialchars(strip_tags($this->category_name));

	      // Bind data
	      $stmt->bindParam(':categoryid', $this->categoryid);
	      $stmt->bindParam(':category_name', $this->category_name);

	      // Execute query
	      if($stmt->execute()) {
	        return true;
	  }

	  // Print error if something goes wrong
	  printf("Error: %s.\n", $stmt->error);

	  return false;
	}

	// Update Category
	 public function update() {
	       // Create query
	       $query = '
	       		UPDATE category
	       		SET category_name = :category_name
	       		WHERE categoryid = :categoryid;
	       ';

	       // Prepare statement
	       $stmt = $this->conn->prepare($query);

	       // Clean data
	       $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
	       $this->category_name = htmlspecialchars(strip_tags($this->category_name));

	       // Bind data
	       $stmt->bindParam(':categoryid', $this->categoryid);
	       $stmt->bindParam(':category_name', $this->category_name);

	       // Execute query
	       if($stmt->execute()) {
	         return true;
	       }

	       // Print error if something goes wrong
	       printf("Error: %s.\n", $stmt->error);

	       return false;
	 }

	// Delete Category
	public function delete() {
	      // Create query
	      $query = '
	      	DELETE FROM category
	      	WHERE categoryid = :categoryid;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->id = htmlspecialchars(strip_tags($this->categoryid));

	      // Bind data
	      $stmt->bindParam(':categoryid', $this->categoryid);

	      // Execute query
	      if($stmt->execute()) {
	        return true;
	      }

	      // Print error if something goes wrong
	      printf("Error: %s.\n", $stmt->error);

	      return false;
	}

	public function isExist($id) {
		// Create query
		$query = '
			SELECT
				*
			FROM 
				category
			WHERE categoryid = ? ;
		';

		// Prepare statement
		$stmt = $this->conn->prepare($query);

		// Clean data
		$id = htmlspecialchars(strip_tags($id));

		// Bind ID
		$stmt->bindParam(1, $id);

		// Execute query
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//
		if ($row) {
			return true;
		} else {
			return false;
		}
	}

	public function dataValidator($data) {
		if (isset($data->categoryid)
				&& isset($data->category_name)) {
			return true;
		} else {
			return false;
		}
	}

}