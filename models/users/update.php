<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];
    $reName  = "/^[A-ZŠĐČĆŽ][a-zšđžčć]{3,15}(\s[A-ZČŠĐĆŽ][a-zčćšđž]{3,15})?$/";
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

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $date = date("Y-m-d H:i:s");
        $check = getOneFetchAndCheckData("users", "email", $_POST['email'], "check");
        if ($check > 0) {
            $getData = getOneFetchAndCheckData('users', 'email', $_POST['email'], "fetch");
            if ($getData->email == $_POST['email'] && $getData->id == $_POST['id']) {
                try {
                    updateUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['role_id'], $date, $_POST['id']);
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_decode($th->getMessage());
                }
            }
        } else {
            try {
                updateUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['role_id'], $date, $_POST['id']);
                http_response_code(204);
            } catch (PDOException $th) {
                echo json_decode($th->getMessage());
            }
        }
    }
} else {
    http_response_code(404);
}
