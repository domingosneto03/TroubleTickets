<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $title = $_POST['title'];
    $body = $_POST['body'];
    $clientId = (int)$_SESSION['id'];
    $priority = $_POST['priority'];
    $department = (int)$_POST['department'];
    $deadline = time();

    $db = getDatabaseConnection();

    try {
        Ticket::create_ticket($db, $title, $body, $clientId, $priority, $department, $deadline);
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

    header('Location: /ticket_list.php');
?>