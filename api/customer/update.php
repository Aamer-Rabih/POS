<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Customer.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'PUT') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate customer object
    $customer = new Customer($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));


    if ($customer->dataValidator($data) && $customer->isExist($data->userid)) {

      // Set ID to update
      $customer->userid = (int) $data->userid;

      $customer->customer_name = $data->customer_name;
      $customer->address = $data->address;
      $customer->contact = $data->contact;

      // Update customer
      if($customer->update()) {
        echo json_encode(
          array('message' => 'Customer Updated')
        );
      } else {
        echo json_encode(
          array('message' => 'Customer Not Updated')
        );
      }
      
    } else {
      echo json_encode(
        array('message' => 'Posted Data Invalid OR Customer Not Found')
      );
    }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }