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
        $date = date("Y-m-d H:i:s");
        echo json_encode($date);
        $check = getOneWithoutFetch('headings', 'name', $_POST['name'], $_POST['id']);
        if ($check->rowCount() > 0) {
            echo json_encode("Koristimp postojeci naziv");
        } else {
            try {
                updateHeading('headings', $_POST['name'], $_POST['categoryId'], $date, $_POST['id']);
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
