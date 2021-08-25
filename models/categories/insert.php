<?php

header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $rename  = '/^[A-Z][a-z]{3,15}$/';
    $name = $_POST['name'];
    $errors = [];
    if (!preg_match($rename, $name)) {
        array_push($errors, "Category name isn't ok!");
    }
    if (count($errors) == 0) {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $nameCheck = getOneWithoutFetch('categories', 'name', $name);
        if ($nameCheck->rowCount() == 0) {
            try {
                insertNewCategory('categories', $name);
                echo json_encode("Category is successfull created");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        } else {
            http_response_code(409);
            echo json_encode('That name is already taken!');
        }
    } else {
        foreach ($errors as $error) {
            echo json_encode('Error: ' . $error);
            http_response_code(422);
        }
    }
} else {
    http_response_code(404);
}
