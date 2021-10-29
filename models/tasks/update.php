<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $desc = $_POST['description'];

    $errors = [];
    if ($desc == '') {
        array_push($errors, "Descritpion must't be empty");
    }
    if ($desc == 0) {
        array_push($errors, "User must be chossen");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($err);
            http_response_code(422);
        }
    } else {
        try {
            require_once '../../config/connection.php';
            require_once '../function.php';
            updateTask($desc, $user_id, $id);
            http_response_code(204);
        } catch (PDOException $th) {
            echo json_encode($th->getMessage());
            http_response_code(500);
        }
    }
} else {
    http_response_code(404);
}
