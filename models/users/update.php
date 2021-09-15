<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // TODO dodati za izmenu passworda
    $errors = [];
    $reName  = "/^[A-Z][a-z]{3,15}$/";
    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
    if (!preg_match($reName, $_POST['firstName'])) {
        array_push($errors, "First name of user isn't ok");
    }
    if (!preg_match($reName, $lastName)) {
        array_push($errors, "Last name of user isn't ok");
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Your email isn't ok");
    }
    // if (!preg_match($rePassword, $_POST['password'])) {
    //     array_push($errors, "Your password isn't ok");
    // }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $check = getOneFetchAndCheckData("users", "email", $_POST['email'], "check");
        if ($check > 0) {
            $getData = getOneFetchAndCheckData('users', 'email', $_POST['email'], "fetch");
            if ($getData->email == $_POST['email'] && $getData->id != $_POST['id']) {
                echo json_encode("Email is already in use");
                http_response_code(409);
            } else {
                try {
                    updateUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['role_id'], $date);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        } else {
            try {
                updateUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['role_id'], $date);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
