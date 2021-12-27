<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $userData = '';
    if (isset($_SESSION['user'])) {
        $userData = $_SESSION['user'];
    }
    $reFirstLastName = '/^[A-Z][a-z]{3,15}$/';


    $errors = [];
    if (!preg_match($reFirstLastName, $first_name)) {
        array_push($errors, "First name isn't ok!");
    }
    if (!preg_match($reFirstLastName, $last_name)) {
        array_push($errors, "Last name isn't ok!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't ok!");
    }
    if (!is_string($message)) {
        array_push($errors, "Message isn't valid");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        $from = $email;
        $usernameFrom = $first_name . " " . $last_name;
        $to = "masternews247@gmail.com";
        $usernameTo = "E-news Admin";
        $messageHTML = "<div><h1>From:" . $email . ", " . $usernameFrom . "</h1> <br/><p>" . $message . "</p></div>";
        $subject = "Contact";
        include "sendEmail.php";
        echo json_encode(['user' => $userData]);
        http_response_code(201);
    }
} else {
    http_response_code(404);
}
