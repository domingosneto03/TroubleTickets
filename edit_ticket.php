<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/database/connection.php");
    require_once(__DIR__ . "/database/ticket.class.php");
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/forms.tpl.php");

    $db = getDatabaseConnection();
    $ticket = Ticket::getTicket($db, (int)$_GET["id"]);

    $title = "Mango Tickets - edit Ticket #" . $ticket->id;
    output_header($session, $title);
    output_sidebar($session);
    output_new_ticket_form($ticket);
    output_footer();
?>