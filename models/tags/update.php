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
        $date = date("Y-m-d H:i:s");
        // echo json_encode($date);
        $checkName = getOneWithoutFetch('tags', 'name', $_POST['name']);
        if ($checkName->rowCount() > 0) {

            echo json_encode($date);
            $getTag = getDataWithFetch('tags', 'name', $_POST['name']);
            if ($getTag->id == $_POST['id'] && $getTag->name == $_POST['tag']) {
                try {
                    updateTag('tags', $_POST['name'], $date, $_POST['id']);
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            } else {
                echo json_encode("Tag name is already taken! Please choose anotherone!");
                http_response_code(409);
            }
        } else {
            try {
                updateTag('tags', $_POST['name'], $date, $_POST['id']);
                http_response_code(204);
            } catch (PDOException $th) {
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
