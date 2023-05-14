<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $title = $_POST['title'];
    $body = $_POST['body'];
    $clientId = $_SESSION['id'];
    $priority = $_POST['priority'];
    $department = $_POST['department'];
    $deadline = time();

    $db = getDatabaseConnection();

    Ticket::create_ticket($db, $title, $body, $clientId, $priority, $department, $deadline);

    header('Location: /ticket_list.php');
?>