<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $priority = (int)$_POST['priority'];
    $department = (int)$_POST['department'];
    $deadline = time();

    $db = getDatabaseConnection();

    try {
        Ticket::edit_ticket($db, $id, $title, $body, $priority, $department, $deadline);
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

    header('Location: /ticket.php?id=' . $id);

?>