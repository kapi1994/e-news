<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $reName = '/^[A-Z][a-z]{1,15}(\s[A-Z][a-z]{3,15})?$/';
    $errors = [];
    if (!preg_match($reName, $_POST['name'])) {
        array_push($errors, "Name of the tag isn't ok!");
    }
    if (count($errors) == 0) {
        require_once '../../config/connection.php';
        require_once '../functions.php';

        $checkName = getOneWithoutFetch('tags', 'name', $_POST['name']);
        if ($checkName->rowCount() > 0) {
            echo json_encode("Name of tag is already  taken!");
            http_response_code(409);
        } else {
            try {
                insertNewTag('tags', $_POST['name']);
                echo json_encode("Tag is successfull created!");
                http_response_code(201);
            } catch (PDOException  $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    } else {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(500);
        }
    }
} else {
    http_response_code(404);
}
