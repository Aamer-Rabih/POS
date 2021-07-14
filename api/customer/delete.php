<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Customer.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'DELETE') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate customer object
    $customer = new Customer($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->userid) && $customer->isExist($data->userid)) {
      
      // Set ID to delete
      $customer->userid = (int) $data->userid;

      // Delete customer
      if($customer->delete()) {
        echo json_encode(
          array('message' => 'Customer Deleted')
        );
      } else {
        echo json_encode(
          array('message' => 'Customer Not Deleted')
        );
      }

    } else {
      echo json_encode(
        array('message' => 'You Do Not Enter ID OR Customer Not Found')
      );
    }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }