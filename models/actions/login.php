<?php
session_start();
if (isset($_POST['btnSubmitLogin'])) {
    $email  = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $errors = [];
    $rePassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Password isn't ok");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email of user isn't ok!");
    }
    if (count($errors) == 0) {
        try {
            require_once '../../config/connection.php';
            require_once '../functions.php';
            $queryCheck = $conn->prepare("SELECT u.*, r.id as roleId, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE email=? AND password=?");
            $queryCheck->execute([$email, md5($password)]);
            if ($queryCheck->rowCount() > 0) {
                $user = $queryCheck->fetch();

                $_SESSION['users'] = $user;
                insertUserActivity($email, "Login");
                if ($user->roleName == "Admin") {
                    header("Location: ../../index.php?page=admin_home");
                } else if ($user->roleName == "User") {
                    header("Location:../../index.php?page=home");
                }
            } else {
                $_SESSION['errors'] = "Your credentials is not ok!";
                header("Location:../../index.php?page=login");
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    } else {
        $_SESSION['errors'] = "Your credentials isn't ok";
        header("Location:../../index.php?page=login");
    }
}
