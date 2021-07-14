<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Product.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'POST') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate product object
    $product = new Product($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if ($product->dataValidator($data)) {
      
      $product->productid = (int) $data->productid;
      $product->categoryid = $data->categoryid;
      $product->product_name = $data->product_name;
      $product->product_price = $data->product_price;
      $product->product_qty = $data->product_qty;
      $product->photo = $data->photo;
      $product->supplierid = $data->supplierid;

      // Create product
      if($product->create()) {
        echo json_encode(
          array('message' => 'Product Created')
        );
      } else {
        echo json_encode(
          array('message' => 'Product Not Created')
        );
      }

    } else {
      echo json_encode(
        array('message' => 'Posted Data Invalid')
      );
    }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }