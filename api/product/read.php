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

    // Blog product query
    $result = $product->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any products
    if($num > 0) {
      // Product array
      $products_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $product_item = array(
            'productid' => $productid,
            'categoryid' => $categoryid,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_qty' => $product_qty,
            'photo' => $photo,
            'supplierid' => $supplierid
          );

          // Push to "data"
          array_push($products_arr, $product_item);
        }

        // Turn to JSON & output
        echo json_encode($products_arr);

      } else {
        // No Products
        echo json_encode(
          array('message' => 'No Products Found')
        );
      }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }