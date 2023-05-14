<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/templates/common.tpl.php");
~
    $title = "Mango Tickets - new Ticket";
    $id = isset($_GET["id"]) ? $_GET["id"] : null; // if id is set, use it, otherwise use null

    output_header($session, $title);
    output_sidebar();
    output_new_ticket_form($id);
    output_footer();

?>