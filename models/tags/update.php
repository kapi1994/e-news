<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reName = '/^[A-Z]{0,}[a-z]{1,15}(\s[A-Z][a-z]{3,15})?$/';
    $errors = [];
    if (!preg_match($reName, $_POST['id'])) {
        array_push($errors, "Tag name isn't ok");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $checkData = getOneFetchAndCheckData('tags', 'name', $_POST['name'], "check");
        $date = date("Y-m-d H:i:s");
        if ($checkData > 0) {
            $tagData = getOneFetchAndCheckData('tags', 'name', $_POST['name'], "fetch");
            if ($tagData->id != $_POST['id'] && $tagData->name == $_POST['name']) {
                echo json_encode("Tag name is already taken");
                http_response_code(409);
            } else {
                try {
                    updateTag($_POST['name'], $date, $_POST['id']);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        } else {
            try {
                updateTag($_POST['name'], $date, $_POST['id']);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
