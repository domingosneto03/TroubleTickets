<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $ticket = Ticket::getTicket($db, $_POST['ticket_id']);

    $ticket->closeTicket($db, $_POST['ticket_id']);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>