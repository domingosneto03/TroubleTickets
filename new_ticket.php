<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/forms.tpl.php");

    $title = "Mango Tickets - new Ticket";

    output_header($session, $title);
    output_sidebar($session);
    output_new_ticket_form();
    output_footer();

?>