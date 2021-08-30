<?php
session_start();
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../functions.php';
    $post_id = $_GET['id'];
    $comments = getComments($post_id);
    echo json_encode($comments);
} else {
    http_response_code(404);
}
