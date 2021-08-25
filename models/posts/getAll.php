<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    $getAllPosts = $conn->query("SELECT p.*, c.name as categoryName FROM posts p JOIN categories c ON p.category_id = c.id")->fetchAll();
    echo json_encode($getAllPosts);
} else {
    http_response_code(404);
}
