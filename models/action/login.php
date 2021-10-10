<?php
session_start();

if (isset($_POST['btnSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $rePassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Your email isn't ok");
    }
    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Your password isn't ok");
    }
    if (count($errors) > 0) {

        $_SESSION['errors'] = $errors;
        header("Location:../../index.php?page=login");
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        try {
            $user = loginUser($email, $password);
            if ($user) {
                $userRole = $user->roleName;
                $_SESSION['user'] = $user;
                if ($userRole == "User") {
                    header("Location: ../../index.php?page=home");
                } else if ($userRole == "Urednik") {
                    header("Location:../../index.php?page=admin_home");
                } else {
                    header("Location:../../index.php?page=admin_home");
                }
            } else {
                $_SESSION['errors'] = "Credentials aren't ok!";
                header("Location:../../index.php?page=login");
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
}
