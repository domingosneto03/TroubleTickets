<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");

    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_POST['id']);

    $user->makeAdmin($db);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>