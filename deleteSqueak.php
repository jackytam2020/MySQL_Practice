<?php

require_once('./data.php');

if (!isset($_POST['id'])) {
  http_response_code(400);
  echo json_encode(["error" => "Must post an id"]);
  exit();
}

$id = $_POST['id'];
deleteSqueak($id);

header("Content-type: application/json");
echo json_encode(["data" => ["id" => $id]]);
