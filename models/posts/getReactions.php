<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';

    $comment_id = $_GET['comment_id'];

    $reactions = getReactionBySingleComment($comment_id);
    echo json_encode($reactions);
} else {
    http_response_code(404);
}
