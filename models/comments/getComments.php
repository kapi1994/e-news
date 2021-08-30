<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../functions.php';
    $post_id = $_GET['id'];
    $getAllComents = getComments($post_id);
    if (isset($_SESSION['users'])) {
    }
    var_dump($countLikes);
    echo json_encode($getAllComents);
} else {
    http_response_code(404);
}
