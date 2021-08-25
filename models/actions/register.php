<?php
header("Content-type:applicaton/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];
    $reFirstLastName = '/^[A-Z][a-z]{3,15}$/';
    $rePassword =  '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';

    if (!preg_match($reFirstLastName, $first_name)) {
        array_push($errors, "First name of user isn't ok");
    }
    if (!preg_match($reFirstLastName, $last_name)) {
        array_push($errors, "Last name of user isn't ok");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email of user isn't ok!");
    }
    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Password of user isn't ok");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $checkEmail =  getOneWithoutFetch('users', 'email', $email);
        if ($checkEmail->rowCount() > 0) {
            http_response_code(409);
            echo json_encode("That email is already taken");
        } else {
            try {
                define("USER_ROLE", 2);
                insertNewUser('users', $first_name, $last_name, $email, $password, USER_ROLE);
                echo json_encode("User is successfull created");
                http_response_code(201);
                insertUserActivity($email, "Register");
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
