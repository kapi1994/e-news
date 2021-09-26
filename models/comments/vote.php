<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once '../../config/connection.php';
    require_once '../function.php';

    $action = $_POST['action'];

    $comment = $_POST['comment'];
    $user_id  = isset($_SESSION['user'])  ? $_SESSION['user']->id : '';
    // echo json_encode($action);

    define("REACT_ON", 1);
    define("REACT_OFF", 0);
    // $query = getReactions($user_id, $comment, 'rowCount');
    // echo json_encode(getReactions($user_id, $comment, 'rowCount'));
    if (getReactions($user_id, $comment, 'rowCount') == 0) {
        // echo json_encode('insert');
        try {
            insertVote($action, $comment, $user_id, REACT_ON);
            echo json_encode("reaction inserted");
            http_response_code(201);
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    } else {
        try {
            updateStatusVote($user_id, $comment, $action, REACT_ON, REACT_OFF);
            http_response_code(204);
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
} else {
    http_response_code(404);
}
