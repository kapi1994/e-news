<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $reName = '/^[A-Z]{0,}[a-z]{1,15}(\s[A-Z][a-z]{3,15})?$/';
    $errors = [];
    if (!preg_match($reName, $name)) {
        array_push($errors, "Name of the tag isn't ok");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $checkData = getOneFetchAndCheckData("tags", 'name', $name, "check");
        if ($checkData > 0) {
            http_response_code(409);
            echo json_encode("Name of the tag is already taken");
        } else {
            try {
                insertTag($name);
                echo json_encode("Tag is successfully created");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(500);
}
