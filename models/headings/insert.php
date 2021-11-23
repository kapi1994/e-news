<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $categoryId = $_POST['categoryId'];
    $reName = '/^([A-Z]{1,}|[A-Z][a-z]{2,15})(\s[A-Z]{1,}|\s[A-Z][a-z]{2,15}|\s[a-z]{2,}|\s[\d]{0,2})*$/';
    $errors = [];

    if (!preg_match($reName, $name)) {
        array_push($errors, "Name of the heading isn't ok!");
    }

    if ($categoryId == 0) {
        array_push($errors, "You must choose category");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once "../../config/connection.php";
        require_once '../function.php';
        $check = getOneFetchAndCheckData("headings", 'name', $_POST['name'], 'check');
        if ($check > 0) {
            echo json_encode("That name is already taken");
            http_response_code(409);
        } else {
            try {
                require_once '../../config/connection.php';
                require_once '../function.php';
                insertHeading($name, $categoryId);
                echo json_encode("Heading is successfully created");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(409);
}
