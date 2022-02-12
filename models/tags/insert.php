<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $reName = '/^([A-Z]{1,}|[A-Z][a-z]{2,15}|[\w\d]{1,})([\.\:])?(\s[A-Z]{1,}|\s[A-Z][a-z]{2,15}|\s[a-z]{2,}|\s[\d]{1,}| \')*/';
    $errors = [];
    $headings_arr = $_POST['headings'];

    if (!preg_match($reName, $name)) {
        array_push($errors, "Name of the tag isn't ok");
    }
    if (count($headings_arr) == 0) {
        array_push($errors, "You must choose at least one heading");
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
                $conn->beginTransaction();
                insertTag($name, $headings_arr);
                $conn->commit();
                echo json_encode("Tag is successfully created");
                http_response_code(201);
            } catch (PDOException $th) {
                $conn->rollBack();
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(500);
}
