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

    // Get ID
    $id = isset($_GET['id']) ? $_GET['id'] : die();
    
    if ($customer->isExist($id)) {
      
      $customer->userid = (int) $id;

      // Get customer
      $customer->read_single();

      // Create array
      $customer_arr = array(
        'userid' => $customer->userid,
        'customer_name' => $customer->customer_name,
        'address' => $customer->address,
        'contact' => $customer->contact
      );

      // Make JSON
      print_r(json_encode($customer_arr));

    } else {
      echo json_encode(
        array('message' => 'Object Not Found')
      );
    }
    
  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }