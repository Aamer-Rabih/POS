<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Category.php';

  // Get type of request method
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Check type of request method
  if ($requestMethod == 'DELETE') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->categoryid) && $category->isExist($data->categoryid)) {

      // Set ID to delete
      $category->categoryid = (int) $data->categoryid;

      // Delete category
      if($category->delete()) {
        echo json_encode(
          array('message' => 'Category Deleted')
        );
      } else {
        echo json_encode(
          array('message' => 'Category Not Deleted')
        );
      }

    } else {
      echo json_encode(
        array('message' => 'You Do Not Enter ID OR Category Not Found')
      );
    }

  } else {
    echo json_encode(
      array('message' => 'Incorrect Request Method')
    );
  }