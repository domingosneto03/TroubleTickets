<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/department.class.php");

    $db = getDatabaseConnection();

    $new_department_name = $_POST['add_department'];

    Department::createDepartment($db, $new_department_name);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>