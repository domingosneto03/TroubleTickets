<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");

    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_POST['id']);
    $dep = $_POST['department'];
    if($dep != '') {
        $user->makeAgent($db, $dep);
    }
    
    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>