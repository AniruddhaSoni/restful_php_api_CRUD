<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// init DB and connect

$database = new Database();
$db       = $database->connect();

//inti Blog posts

$post = new Post($db);

// Get the raw posted data

$data = json_decode(file_get_contents("php://input"));

// Set ID to update

$post->id = $data->id;

// Update Post

if ($post->delete()) {
  echo json_encode(
    array('message' => 'Post deleted')
  );
} else {
  echo json_encode(
    array('message' => 'Post Not deleted')
  );
}