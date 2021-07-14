<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Category.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'GET') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Blog category query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any category
    if($num > 0) {
      // Category array
      $categories_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $category_item = array(
            'categoryid' => $categoryid,
            'category_name' => $category_name
          );

          // Push to "data"
          array_push($categories_arr, $category_item);
        }

        // Turn to JSON & output
        echo json_encode($categories_arr);

      } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Categories Found')
        );
      }
    
  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }
