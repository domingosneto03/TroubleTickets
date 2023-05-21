<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $ticket = Ticket::getTicket($db, $_POST['ticket_id']);
    if ($_POST['agent_to_assign'] != '') {
        $ticket->assignTicket($db, $_POST['agent_to_assign']);
    }

    header("Location: " . $_SERVER["HTTP_REFERER"]);

?>