<?php
    require_once(__DIR__ . "/database/ticket.class.php");
    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/database/connection.php");
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/tickets.tpl.php");

    $db = getDatabaseConnection();

    $title = "MangoTickets - Ticket List";

    output_header($session, $title);
    output_sidebar($session);

    if (isset($_SESSION['filtered_tickets'])) {
        output_ticket_list($session, $_SESSION['filtered_tickets']);
    } else {
        output_ticket_list($session, Ticket::getTickets($db));
    }
    unset($_SESSION['filtered_tickets']);

    output_footer();

?>