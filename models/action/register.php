<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    define("USER", 3);
    $role = USER;
    $errors = [];
    $reFirstLastName  = '/^[A-ZŠĐČĆŽ][a-zšđžčć]{3,15}(\s[A-ZČŠĐĆŽ][a-zčćšđž]{3,15})?$/';
    $rePassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
    define('USER_CATEGORY', NULL);
    if (!preg_match($reFirstLastName, $firstName)) {
        array_push($errors, "FIrst name isn't ok");
    }
    if (!preg_match($reFirstLastName, $lastName)) {
        array_push($errors, "Last name ins't good");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't good");
    }
    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Password isn't ok");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $check = getOneFetchAndCheckData('users', 'email', $email, 'check');
        if ($check > 0) {
            echo json_encode("That email is already taken!");
            http_response_code(409);
        } else {
            try {
                insertUser($firstName, $lastName, $email, $password, $role, USER_CATEGORY);
                insertActivity("Register", $email);
                echo json_encode("Register success");
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
