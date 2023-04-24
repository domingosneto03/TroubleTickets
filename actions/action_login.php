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
    $session->addMessage('success', 'Login successful');
} else {
    $session->addMessage('error', 'Wrong password!');
}

header('Location: /home.php' );
?>