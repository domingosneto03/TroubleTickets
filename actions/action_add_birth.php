<?php 

    require_once(__DIR__ . "/../utils/session.php");

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/personal.class.php");

    $db = getDatabaseConnection();

    $birth = $_POST['birthday'];

?>