<?php
class Post {
  // DB stuff
  private $conn;
  private $table = 'posts';

  // Post Properties
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  // Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  // Get Blog Posts
  public function read() {
    //Create Query
    $query = 'SELECT * FROM ' . $this->table;

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get single post

  public function readSingle() {
    // Create query
    $query = "SELECT * FROM  $this->table  WHERE id = ? ASC";

    // prepare statement

    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //set properties
    $this->title         = $row['title'];
    $this->body          = $row['body'];
    $this->author        = $row['author'];
    $this->category_id   = $row['category_id'];
    $this->category_name = $row['category_name'];
  }

  // create Post
  public function create() {
    // Create query

    $query = "INSERT INTO $$this->table
        SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
    ";

    //prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->title       = htmlspecialchars(strip_tags($this->title));
    $this->body        = htmlspecialchars(strip_tags($this->body));
    $this->author      = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->title));
    // $this->category_name = htmlspecialchars(strip_tags($this->category_name));

    //bind data

    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    // $stmt->bindParam(':category_name', $this->category_name);

    // execute data

    if ($stmt->execute()) {
      return true;
    }

    // error
    echo "ERROR $stmt->error";

    return false;
  }

  // update Post
  public function update() {
    // Create query

    $query = "UPDATE $$this->table
          SET
              title = :title,
              body = :body,
              author = :author,
              category_id = :category_id
          WHERE
              id = :id
      ";

    //prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id          = htmlspecialchars(strip_tags($this->id));
    $this->title       = htmlspecialchars(strip_tags($this->title));
    $this->body        = htmlspecialchars(strip_tags($this->body));
    $this->author      = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->title));
    // $this->category_name = htmlspecialchars(strip_tags($this->category_name));

    //bind data

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    // $stmt->bindParam(':category_name', $this->category_name);

    // execute data

    if ($stmt->execute()) {
      return true;
    }

    // error
    echo "ERROR $stmt->error";

    return false;
  }

  //delete Post

  public function delete() {
    // Create query
    $query = "DELETE FROM $this->table WHERE id = :id";

    //prepare statement

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam('id', $this->id);

    if ($stmt->execute()) {
      return true;
    }

    // error
    echo "ERROR $stmt->error";

    return false;

  }
}