<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Customer.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'GET') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate customer object
    $customer = new Customer($db);

    // Blog Customer query
    $result = $customer->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any customers
    if($num > 0) {

      // Customer array
      $customers_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $customer_item = array(
            'userid' => $userid,
            'customer_name' => $customer_name,
            'address' => $address,
            'contact' => $contact
          );

          // Push to "data"
          array_push($customers_arr, $customer_item);
        }

        // Turn to JSON & output
        echo json_encode($customers_arr);

      } else {
        // No Customers
        echo json_encode(
          array('message' => 'No Customers Found')
        );
      }
      
  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }