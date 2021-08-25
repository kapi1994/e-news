<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $reFirstLastName = '/^[A-Z][a-z]{3,15}$/';
    $rePassword  = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';

    $errors = [];
    if (!preg_match($reFirstLastName, $first_name)) {
        array_push($errors, $first_name);
    }
    if (!preg_match($reFirstLastName, $last_name)) {
        array_push($errors, "Last name of user isn't ok");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't ok");
    }

    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Your password isn't ok");
    }
    if ($role == 0) {
        array_push($errors, "Must choose one role");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $checkEmail = getOneWithoutFetch('users', 'email', $email);
        if ($checkEmail->rowCount() > 0) {
            echo json_encode("This email is already taken!");
            http_response_code(409);
        } else {
            try {
                insertNewUser('users', $first_name, $last_name, $email, $password, $role);
                echo json_encode("User is successfull created!");
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
