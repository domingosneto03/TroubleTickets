<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/connection.php");
    $db = getDatabaseConnection();

    $tickets = Ticket::getMyTickets($db, $session->getId());
    $_SESSION['filtered_tickets'] = $tickets;

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>