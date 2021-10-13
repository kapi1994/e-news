<?php
header("Content-type:application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $user = $_POST['user'];
    $errors = [];
    if ($description == "") {
        array_push($errors, "Description can't be empty");
    }
    if ($user == 0) {
        array_push($errors, "User filed can't be empty");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        try {
            $queryInsert = "INSERT INTO tasks (description,user_id) VALUES(?, ?)";
            $query = $conn->prepare($queryInsert);
            $query->execute([$description, $user]);
            echo json_encode("Task is successfully created");
            http_response_code(201);
        } catch (PDOException $ex) {
            echo json_encode($ex->getMessage());
            http_response_code(500);
        }
    }
} else {
    http_response_code(404);
}
