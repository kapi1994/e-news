<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $reName = "/^[A-Z][a-z]{3,15}$/";
    $errors = [];

    if (!preg_match($reName, $name)) {
        array_push($errors,  "Category name isn't ok!");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $check = getOneFetchAndCheckData("categories", "name", $_POST['name'], "check");
        if ($check > 0) {
            echo json_encode("That name is already taken!");
            http_response_code(409);
        } else {
            try {
                insertCategory($_POST['name']);
                echo json_encode("Category is successfully created");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
