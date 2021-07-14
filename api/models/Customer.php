<?php
class Customer {
	// DB stuff
	private $conn;
	private $table = 'customer';

	// Customer Properties
	public $userid;
	public $customer_name;
	public $address;
	public $contact;

	// Constructor with DB
	public function __construct($db) {
	  $this->conn = $db;
	}

	// Get All Customers
	public function read() {
	  // Create query
	  $query = '
	  	SELECT
	  		userid, customer_name, address, contact
	  	FROM 
	  		customer;
	  ';
	  
	  // Prepare statement
	  $stmt = $this->conn->prepare($query);

	  // Execute query
	  $stmt->execute();

	  return $stmt;
	}

	// Get Single Customer
	public function read_single() {
	      // Create query
	      $query = '
	      	SELECT
	      		userid, customer_name, address, contact
	      	FROM 
	      		customer
	      	WHERE userid = :userid ;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->userid = htmlspecialchars(strip_tags($this->userid));

	      // Bind ID
	      $stmt->bindParam(':userid', $this->userid);

	      // Execute query
	      $stmt->execute();

	      $row = $stmt->fetch(PDO::FETCH_ASSOC);

	      // Set properties
	      $this->customer_name = $row['customer_name'];
	      $this->address = $row['address'];
	      $this->contact = $row['contact'];
	}

	// Create Product
	public function create() {
	      // Create query
	      $query = '
	      	INSERT INTO customer
	      	SET userid = :userid,
	      		customer_name = :customer_name,
	      		address = :address,
	      		contact = :contact;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->userid = htmlspecialchars(strip_tags($this->userid));
	      $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
	      $this->address = htmlspecialchars(strip_tags($this->address));
	      $this->contact = htmlspecialchars(strip_tags($this->contact));

	      // Bind data
	      $stmt->bindParam(':userid', $this->userid);
	      $stmt->bindParam(':customer_name', $this->customer_name);
	      $stmt->bindParam(':address', $this->address);
	      $stmt->bindParam(':contact', $this->contact);

	      // Execute query
	      if($stmt->execute()) {
	        return true;
	  }

	  // Print error if something goes wrong
	  printf("Error: %s.\n", $stmt->error);

	  return false;
	}

	// Update Customer
	 public function update() {
	       // Create query
	       $query = '
	       		UPDATE customer
	       		SET customer_name = :customer_name,
	       			address = :address,
	       			contact = :contact
	       		WHERE userid = :userid;
	       ';

	       // Prepare statement
	       $stmt = $this->conn->prepare($query);

	       // Clean data
	       $this->userid = htmlspecialchars(strip_tags($this->userid));
	       $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
	       $this->address = htmlspecialchars(strip_tags($this->address));
	       $this->contact = htmlspecialchars(strip_tags($this->contact));

	       // Bind data
	       $stmt->bindParam(':userid', $this->userid);
	       $stmt->bindParam(':customer_name', $this->customer_name);
	       $stmt->bindParam(':address', $this->address);
	       $stmt->bindParam(':contact', $this->contact);

	       // Execute query
	       if($stmt->execute()) {
	         return true;
	       }

	       // Print error if something goes wrong
	       printf("Error: %s.\n", $stmt->error);

	       return false;
	 }

	// Delete Customer
	public function delete() {
	      // Create query
	      $query = '
	      	DELETE FROM customer
	      	WHERE userid = :userid;
	      ';

	      // Prepare statement
	      $stmt = $this->conn->prepare($query);

	      // Clean data
	      $this->id = htmlspecialchars(strip_tags($this->userid));

	      // Bind data
	      $stmt->bindParam(':userid', $this->userid);

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
				customer
			WHERE userid = ? ;
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
		if (isset($data->userid)
				&& isset($data->customer_name)
				&& isset($data->address)
				&& isset($data->contact)) {
			return true;
		} else {
			return false;
		}
	}

}