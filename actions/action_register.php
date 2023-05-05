<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $db = getDatabaseConnection();

    $user = User::getUser($db, $username);

    if ($user) {
        $session->addMessage('error', 'username already exists!');
    } else {
        User::register($db, $username, $email, $password);
        $session->addMessage('success', 'Successfully registered!');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>