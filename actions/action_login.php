<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

    if ($user) {
        $session->setId($user->id);
        $session->setUsername($user->username);
        $session->setProfilePic($user->userImage);
        if ($user->isAgent($db)) {
            $session->setAgent();
        }
        if ($user->isAdmin($db)) {
            $session->setAdmin();
        }
        $session->addMessage('success', 'Login successful');
        header('Location: /ticket_list.php' );
    } else {
        $session->addMessage('error', 'Wrong password!');
        header('Location: /login.php' );
    }
    
?>