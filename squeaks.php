<?php

require_once('./data.php');

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (!isset($_POST['message']) || !isset($_POST['username'])) {
    http_response_code(400);
    echo json_encode(["error" => "Must post a message and username"]);
    exit();
  }

  $message = $_POST["message"];
  $username = $_POST["username"];
  saveNewSqueak($message, $username);

  http_response_code(201);
  echo json_encode(["data" => ["message" => $message, "username" => $username]]);

} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  // New Features Go Here

  if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $squeaks = getAllSqueaks($username);
    echo json_encode(["data" => $squeaks]);
    
  }

  $squeaks = getAllSqueaks();
  echo json_encode(["data" => $squeaks]);
}
