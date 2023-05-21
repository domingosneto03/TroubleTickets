<?php 

    require_once(__DIR__ . "/../utils/session.php");

    require_once(__DIR__ . "/../database/connection.php");

    $db = getDatabaseConnection();

    $name = $_POST['name'];

    

?>