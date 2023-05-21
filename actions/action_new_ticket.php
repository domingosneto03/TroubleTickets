<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $title = $_POST['title'];
    $body = $_POST['body'];
    $clientId = (int)$_SESSION['id'];
    $priority = (int)$_POST['priority'];
    $department = (int)$_POST['department'];
    $deadline = time();

    if ($priority == 4) {
        $deadline = $deadline + 10*24*60*60;
    }
    elseif ($priority == 3) {
        $deadline = $deadline + 5*24*60*60;
    }
    elseif ($priority == 2) {
        $deadline = $deadline + 3*24*60*60;
    }
    else {
        $deadline = $deadline + 24*60*60;
    }

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