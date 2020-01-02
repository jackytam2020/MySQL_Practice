<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'Jacky_user');
define('DB_PASS', 'password');
define('DB_NAME', 'squeaker');

function runQuery($sql) {
  // Connect to the database
  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($connection, 'utf8mb4');
  if(mysqli_connect_errno()) {
    exit("Database connection failed: (" . mysqli_connect_errno() . ")");
  }

  // Run the query
  $results = mysqli_query($connection, $sql);
  if (!$results) {
    exit("Database query failed. ". mysqli_errno ($connection));
  }

  // Handle the results
  if (gettype($results) === 'boolean') {
    return $results; 
  }
  
  $count = mysqli_num_rows($results);
  $data = [];
  for ($i = 0; $i < $count; $i++) {
    $row = mysqli_fetch_assoc($results);
    $data[] = $row;
  }

  mysqli_free_result($results);
  mysqli_close($connection);

  return $data;
}

function getSqueak($squeakId) {
  $sql = "
  SELECT id, message, username, like_count as likeCount FROM squeaker
  WHERE deleted = false
  WHERE id = $squeakId";
  $squeaks = runQuery($sql);

  return $squeaks[0];
}

function getAllSqueaks(){
  

  $squeaks = runQuery("
  SELECT id, message, username, like_count as likeCount FROM squeaker
  WHERE deleted = false
  ORDER BY created desc;
  ");
  

  return $squeaks;
}

function saveNewSqueak($message, $username){
  $sql = "
  INSERT INTO squeaker (message, username, like_count, created, deleted)
  VALUES ('$message', '$username', 0, now(), false);
  ";
  runQuery($sql);

}

function deleteSqueak($id){
  $sql = "
  UPDATE squeaker
  SET deleted = false

  WHERE 
  id = $id
  ";
  runQuery($sql);
}

function incrementLikeCount($id, $increment){
  $sql = "
  UPDATE squeaker
  SET like_count = like_count + $increment

  WHERE 
  id = $id
  ";
  runQuery($sql);
}
