<?php 

    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/settings.tpl.php");
    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();
    $title = "Mango Tickets - Settings";

    output_header($session, $title);
    output_sidebar($session);
    output_settings($session);
    output_footer();


?>