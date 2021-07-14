<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Product.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'PUT') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate product object
    $product = new Product($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if ($product->dataValidator($data) && $product->isExist($data->productid)) {

      // Set ID to update
      $product->productid = (int) $data->productid;

      $product->categoryid = $data->categoryid;
      $product->product_name = $data->product_name;
      $product->product_price = $data->product_price;
      $product->product_qty = $data->product_qty;
      $product->photo = $data->photo;
      $product->supplierid = $data->supplierid;

      // Update product
      if($product->update()) {
        echo json_encode(
          array('message' => 'Product Updated')
        );
      } else {
        echo json_encode(
          array('message' => 'Product Not Updated')
        );
      }

    } else {
      echo json_encode(
        array('message' => 'Posted Data Invalid OR Product Not Found')
      );
    }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }