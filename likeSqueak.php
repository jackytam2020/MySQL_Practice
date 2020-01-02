<?php

require_once('./data.php');

if (!isset($_POST['id']) || !isset($_POST['value'])) {
  http_response_code(400);
  echo json_encode(["error" => "Must post an id and a value"]);
  exit();
}

$id = $_POST['id'];
$incrementValue = $_POST['value'];

incrementLikeCount($id, $incrementValue);

header("Content-type: application/json");
echo json_encode(["data" => ["id" => $id]]);
