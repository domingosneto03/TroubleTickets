<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    $db = getDatabaseConnection();

    $user = User::getUser($db, $username);

    try {
        if ($user) {
            $session->addMessage('error', 'username already exists!');
        } else {
            User::register($db, $username, $email, $password, $bio);
            $session->addMessage('success', 'Successfully registered!');
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>