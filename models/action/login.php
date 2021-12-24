<?php
session_start();

if (isset($_POST['btnSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Your email isn't ok");
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location:../../index.php?page=login");
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        try {
            if (accountIsDisabled($email)) {
                header("Location: ../../index.php?page=login");
                $_SESSION['errors'] = "Your account is dissabled, please check your email!";
            } else {
                $userQuery = "SELECT u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE email=? AND password=?";
                $userData = $conn->prepare($userQuery);
                $passwordMD = md5($password);
                $userData->execute([$email, $passwordMD]);
                if ($userData->rowCount() == 0) {
                    insertActivity("Invalid password", $email);
                    if (!insertThreeTimesInFive($email)) {
                        $_SESSION['errors'] = "Incorect password";
                    } else {
                        insertActivity('Dissabled account', $email);
                        $_SESSION['errors'] = "You have been locket out of account, an email has been sent
                        to your email to reset your password";
                    }
                    header("Location: ../../index.php?page=login");
                } else {
                    $user = $userData->fetch();
                    // var_dump($user);
                    $_SESSION['user'] = $user;
                    if ($user->roleName == "User") {
                        header("Location:../../index.php");
                    } else {
                        header("Location:../../admin.php");
                    }
                }
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
}
