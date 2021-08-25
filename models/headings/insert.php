<?php
header("content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $reName = "/^[A-Z][a-z]{4,15}$/";
    $errors = [];
    if (!preg_match($reName, $_POST['name'])) {
        array_push($errors, "Name of the headings isn't ok!");
    }
    if ($_POST['categoryId'] == 0) {
        array_push($errors, "You must choose heading");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(500);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $checkName = getOneWithoutFetch('headings', 'name', $_POST['name']);
        if ($checkName->rowCount() > 0) {
            echo json_encode("That name is already taken!");
            http_response_code(409);
        } else {
            try {
                insertNewHeading('headings', $_POST['name'], $_POST['categoryId']);
                echo json_encode("Heading is successfull created");
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
