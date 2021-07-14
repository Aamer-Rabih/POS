<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Category.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'POST') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if ($category->dataValidator($data)) {
      
      $category->categoryid = (int) $data->categoryid;
      $category->category_name = $data->category_name;

      // Create category
      if($category->create()) {
        echo json_encode(
          array('message' => 'Category Created')
        );
      } else {
        echo json_encode(
          array('message' => 'Category Not Created')
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