<?php
    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/database/connection.php");
    require_once(__DIR__ . "/database/ticket.class.php");
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/tickets.tpl.php");

    $db = getDatabaseConnection();

    $title = "MangoTicket - Ticket List";
    $tickets = Ticket::getTickets($db);

    output_header($session, $title);
    output_sidebar();

    output_ticket_list($session, $tickets);

    output_footer();

?>