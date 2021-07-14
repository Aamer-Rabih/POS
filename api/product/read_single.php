<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Product.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'GET') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate product object
    $product = new Product($db);

    // Get ID
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    if ($product->isExist($id)) {
      
      $product->productid = (int) $id;

      // Get product
      $product->read_single();

      // Create array
      $product_arr = array(
        'productid' => $product->productid,
        'categoryid' => $product->categoryid,
        'product_name' => $product->product_name,
        'product_price' => $product->product_price,
        'product_qty' => $product->product_qty,
        'photo' => $product->photo,
        'supplierid' => $product->supplierid
      );

      // Make JSON
      print_r(json_encode($product_arr));

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