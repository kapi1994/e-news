<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once '../../config/connection.php';
    require_once '../function.php';

    $action = $_POST['action'];
    // $post = $_POST['post'];
    $comment = $_POST['comment'];
    $user_id  = isset($_SESSION['user'])  ? $_SESSION['user']->id : '';

    if ($action == 'like') {
        $query = $conn->query("SELECT * FROM reactions WHERE user_id = '$user_id'  AND comment_id = '$comment'");
        if ($query->rowCount() == 0) {
        } else {
        }
    } else {
    }
} else {
    http_response_code(404);
}
