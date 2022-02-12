<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reName = '/^([A-Z]{1,}|[A-Z][a-z]{2,15}|[\w\d]{1,})([\.\:])?(\s[A-Z]{1,}|\s[A-Z][a-z]{2,15}|\s[a-z]{2,}|\s[\d]{1,}| \')*/';
    $headings_arr = $_POST['headings'];
    // echo json_encode($headings_arr);
    $errors = [];
    if (!preg_match($reName, $_POST['id'])) {
        array_push($errors, "Tag name isn't ok");
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
        $checkData = getOneFetchAndCheckData('tags', 'name', $_POST['name'], "check");
        $date = date("Y-m-d H:i:s");
        if ($checkData > 0) {
            $tagData = getOneFetchAndCheckData('tags', 'name', $_POST['name'], "fetch");
            if ($tagData->id != $_POST['id'] && $tagData->name == $_POST['name']) {
                echo json_encode("Tag name is already taken");
                http_response_code(409);
            } else {
                try {
                    $conn->beginTransaction();
                    updateTag($_POST['name'], $date, $headings_arr, $_POST['id']);
                    $conn->commit();
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        } else {
            try {
                $conn->beginTransaction();
                updateTag($_POST['name'], $date, $headings_arr, $_POST['id']);
                $conn->commit();
                http_response_code(204);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
