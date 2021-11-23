<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reName  =  "/^([A-Z]{1,}|[A-Z][a-z]{2,15})(\s[A-Z]{1,}|\s[A-Z][a-z]{2,15}|\s[a-z]{2,}|\s[\d]{0,2})*$/";
    $errors = [];
    if (!preg_match($reName, $_POST['name'])) {
        array_push($errors, "Name of the headings isn't ok");
    }
    if ($_POST['categoryId'] == 0) {
        array_push($errors, "You must choose category");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $date = date("Y-m-d H:i:s");
        $check = getOneFetchAndCheckData('headings', 'name', $_POST['name'], 'check');
        if ($check > 0) {
            $date = date("Y-m-d H:i:s");
            $heading_data =  getOneFetchAndCheckData('headings', 'name', $_POST['name'], 'fetch');
            if ($heading_data->id == $_POST['id'] && $heading_data->name == $_POST['name']) {
                try {
                    updateHeading($_POST['name'], $_POST['categoryId'], $date, $_POST['id']);
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            } else {
                echo json_encode("That name is already taken");
                http_response_code(409);
            }
        } else {
            try {
                updateHeading($_POST['name'], $_POST['categoryId'], $date, $_POST['id']);
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
