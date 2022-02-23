<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $journalistRole = isset($_POST['journalistRole']) ? $_POST['journalistRole'] : NULL;
    $errors = [];
    $reName  = "/[A-ZŠĐČĆŽ][a-zšđžčć]{3,15}(\s[A-ZČŠĐĆŽ][a-zčćšđž]{3,15})?$/";
    $rePassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
    if (!preg_match($reName, $_POST['first_name'])) {
        array_push($errors, "First name of user isn't ok");
    }
    if (!preg_match($reName, $_POST['last_name'])) {
        array_push($errors, "Last name of user isn't ok");
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Your email isn't ok");
    }
    if (!preg_match($rePassword, $_POST['password'])) {
        array_push($errors, "Your password isn't ok");
    }
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

            echo json_encode("Your email is already in use");
            http_response_code(409);
        } else {
            try {
                insertUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['role'], $journalistRole);
                echo json_encode("User is successfully created");
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
