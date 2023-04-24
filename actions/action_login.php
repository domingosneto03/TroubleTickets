<?php
require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ . "/../database/user.class.php");
$session = new Session();

$username = $_POST['username'];
$password = $_POST['password'];

$db = getDatabaseConnection();

$user = User::getUserWithPassword($db, $username, $password);

if ($user) {
    $session->setId($user->id);
    $session->setUserName($user->username);
    $session->addMessage('success', 'Login successful');
} else {
    $session->addMessage('error', 'Wrong password!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>