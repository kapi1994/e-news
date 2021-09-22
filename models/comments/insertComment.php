<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post_id = $_POST['post'];
    $text = $_POST['text'];
    $user_id = $_SESSION['user'] ? $_SESSION['user']->id : '';
    $errors = [];
    if ($text == " ") {
        array_push($errors, "Komentar ne moze ostati prazan");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require "../function.php";
        try {
            insertComment('comments', $user_id, "", $post_id, $text);
            echo json_encode("Comment is successfully added");
            http_response_code(201);
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
} else {
    http_response_code(404);
}
