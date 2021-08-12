<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// init DB and connect

$database = new Database();
$db       = $database->connect();

//inti Blog posts

$post = new Post($db);

// blog post querry

$result = $post->read();
$num    = $result->rowCount();

//check post

if ($num > 0) {

  $posts_arr         = array();
  $posts_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    # code...
    extract($row);

    $post_items = array(
      'id'          => $id,
      'title'       => $title,
      'body'        => html_entity_decode($body),
      'author'      => $author,
      'category_id' => $category_id,
      'created_at'  => $created_at,
    );

    // push to data
    array_push($posts_arr['data'], $post_items);
  }

  // to JSON
  echo json_encode($posts_arr);
} else {
  # code...
  echo json_encode(
    array('message' => 'No posts found')
  );
}