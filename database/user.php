<?php
require_once(__DIR__ . '/connection.php');

function get_user($username) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->execute($username);
    return $stmt->fetch();
}

function create_user($username, $email, $password) {
    $db = getDatabaseConnection();
    $stmt = $db-> prepare("INSERT INTO user ")
}

?>