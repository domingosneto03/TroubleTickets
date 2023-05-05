<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $title = $_POST['title'];
    $body = $_POST['body'];
    $status = $_POST['status'];
    $assigned = $_POST['assigned'];
    $clientId = $_POST['clientId'];
    $priority = $_POST['priority'];
    $department = $_POST['department'];

    $db = getDatabaseConnection();

    Ticket::create_ticket($db, $title, $body, $status, $assigned, $lcientId, $priority, $department);

    header('Location: /ticket_list.php')

?>