<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id = $_POST['id'];

    $reFirstLastName = '/^[A-Z][a-z]{3,15}$/';
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
        $checkData = getOneWithoutFetch("users", 'email', $email);
        $date = date('Y-m-d H:i:s');
        if ($checkData->rowCount() > 0) {
            echo json_encode('objekat postoji');
            $user = getDataWithFetch('users', 'id', $id);
            if ($user->id == $id && $user->email == $email) {
                updateUser('users', $first_name, $last_name, $email, $role, $date, $id);
                http_response_code(204);
            } elseif ($user->id != $id && $user->email == $email) {
                echo json_encode("We cant use this email beacuse is already taken!");
                http_response_code(409);
            }
        } else {
            try {
                updateUser('users', $first_name, $last_name, $email, $role, $date, $id);
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
