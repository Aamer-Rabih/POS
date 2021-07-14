<?php
class Product {
	// DB stuff
	private $conn;
	private $table = 'product';

	// Product Properties
	public $productid;
	public $categoryid;
	public $product_name;
	public $product_price;
	public $product_qty;
	public $photo;
	public $supplierid;

	// Constructor with DB
	public function __construct($db) {
	  $this->conn = $db;
	}

	// Get All Products
	public function read() {
	  // Create query
	  $query = '
	  	SELECT
	  		productid, categoryid, product_name, product_price, product_qty, photo, supplierid
	  	FROM 
	  		product;
	  ';
	  
	  // Prepare statement
	  $stmt = $this->conn->prepare($query);

	  // Execute query
	  $stmt->execute();

	  return $stmt;
	}

	// Get Single Product
	public function read_single() {
	      // Create query
	      $query = '
	      	SELECT
	      		productid, categoryid, product_name, product_price, product_qty, photo, supplierid
	      	FROM 
	      		product
	      	WHERE productid = :productid ;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->productid = htmlspecialchars(strip_tags($this->productid));

	      // Bind ID
	      $stmt->bindParam(':productid', $this->productid);

	      // Execute query
	      $stmt->execute();

	      $row = $stmt->fetch(PDO::FETCH_ASSOC);

	      // Set properties
	      $this->categoryid = $row['categoryid'];
	      $this->product_name = $row['product_name'];
	      $this->product_price = $row['product_price'];
	      $this->product_qty = $row['product_qty'];
	      $this->photo = $row['photo'];
	      $this->supplierid = $row['supplierid'];
	}

	// Create Product
	public function create() {
	      // Create query
	      $query = '
	      	INSERT INTO product
	      	SET productid = :productid,
	      		categoryid = :categoryid,
	      		product_name = :product_name,
	      		product_price = :product_price,
	      		product_qty = :product_qty,
	      		photo = :photo,
	      		supplierid = :supplierid;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->productid = htmlspecialchars(strip_tags($this->productid));
	      $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
	      $this->product_name = htmlspecialchars(strip_tags($this->product_name));
	      $this->product_price = htmlspecialchars(strip_tags($this->product_price));
	      $this->product_qty = htmlspecialchars(strip_tags($this->product_qty));
	      $this->photo = htmlspecialchars(strip_tags($this->photo));
	      $this->supplierid = htmlspecialchars(strip_tags($this->supplierid));

	      // Bind data
	      $stmt->bindParam(':productid', $this->productid);
	      $stmt->bindParam(':categoryid', $this->categoryid);
	      $stmt->bindParam(':product_name', $this->product_name);
	      $stmt->bindParam(':product_price', $this->product_price);
	      $stmt->bindParam(':product_qty', $this->product_qty);
	      $stmt->bindParam(':photo', $this->photo);
	      $stmt->bindParam(':supplierid', $this->supplierid);

	      // Execute query
	      if($stmt->execute()) {
	        return true;
	  }

	  // Print error if something goes wrong
	  printf("Error: %s.\n", $stmt->error);

	  return false;
	}

	// Update Product
	 public function update() {
	       // Create query
	       $query = '
	       		UPDATE product
	       		SET categoryid = :categoryid,
	       			product_name = :product_name,
	       			product_price = :product_price,
	       			product_qty = :product_qty,
	       			photo = :photo,
	       			supplierid = :supplierid
	       		WHERE productid = :productid;
	       ';

	       // Prepare statement
	       $stmt = $this->conn->prepare($query);

	       // Clean data
	       $this->productid = htmlspecialchars(strip_tags($this->productid));
	       $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
	       $this->product_name = htmlspecialchars(strip_tags($this->product_name));
	       $this->product_price = htmlspecialchars(strip_tags($this->product_price));
	       $this->product_qty = htmlspecialchars(strip_tags($this->product_qty));
	       $this->photo = htmlspecialchars(strip_tags($this->photo));
	       $this->supplierid = htmlspecialchars(strip_tags($this->supplierid));

	       // Bind data
	       $stmt->bindParam(':productid', $this->productid);
	       $stmt->bindParam(':categoryid', $this->categoryid);
	       $stmt->bindParam(':product_name', $this->product_name);
	       $stmt->bindParam(':product_price', $this->product_price);
	       $stmt->bindParam(':product_qty', $this->product_qty);
	       $stmt->bindParam(':photo', $this->photo);
	       $stmt->bindParam(':supplierid', $this->supplierid);

	       // Execute query
	       if($stmt->execute()) {
	         return true;
	       }

	       // Print error if something goes wrong
	       printf("Error: %s.\n", $stmt->error);

	       return false;
	 }

	// Delete Product
	public function delete() {
	      // Create query
	      $query = '
	      	DELETE FROM product
	      	WHERE productid = :productid;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->id = htmlspecialchars(strip_tags($this->productid));

	      // Bind data
	      $stmt->bindParam(':productid', $this->productid);

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
				product
			WHERE productid = ? ;
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
		if (isset($data->productid)
				&& isset($data->categoryid)
				&& isset($data->product_name)
				&& isset($data->product_price)
				&& isset($data->product_qty)
				&& isset($data->photo)
				&& isset($data->supplierid)) {
			return true;
		} else {
			return false;
		}
	}

}