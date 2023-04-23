<?php
require_once(__DIR__ . "/../database/connection.php");

function register_user($username, $email, $password) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("INSERT into user VALUES (?, ?, ?)");
    $options = ['cost' => 12];
    $stmt->execute(array(
        $username,
        password_hash($password, PASSWORD_DEFAULT, $options),
        $email
    ));
}

function edit_user($new_username, $new_email, $new_password) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE user SET username = ?, password = ?, email = ?");
    $options = ['cost' => 12];
    $stmt->execute(array(
        $new_username,
        password_hash($new_password, PASSWORD_DEFAULT, $options),
        $new_email
    ));
}

function delete_user($username, $password) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT FROM user WHERE username = ?");
    $stmt->execute(array($username));
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $stmt = $db->prepare("DELETE FROM user WHERE username = ?");
        $stmt->execute(array($username));
    }
}

?>