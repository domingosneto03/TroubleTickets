<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/database/connection.php");
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/database/ticket.class.php");
    require_once(__DIR__ . "/templates/tickets.tpl.php");

    $db = getDatabaseConnection();

    $title = "Mango Tickets - Ticket #" . $_GET["id"];
    $ticket = Ticket::getTicket($db, (int)$_GET["id"]);

    output_header($session, $title);
    output_sidebar();
    output_full_ticket($session, $ticket);
    output_footer();
    

?>