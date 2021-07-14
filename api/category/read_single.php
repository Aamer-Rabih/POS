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

    // Get ID
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    if ($category->isExist($id)) {

      $category->categoryid = (int) $id;

      // Get category
      $category->read_single();

      // Create array
      $category_arr = array(
        'categoryid' => $category->categoryid,
        'category_name' => $category->category_name
      );

      // Make JSON
      print_r(json_encode($category_arr));

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