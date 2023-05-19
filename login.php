<?php
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/forms.tpl.php");
    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();
    $title = "Mango Tickets - Login";

    output_header($session, $title);
    if(isset($_SESSION['id'])){
        output_sidebar($session);
    }
    else{
        output_alt_sidebar();
    }
    output_login_form($session);
    output_footer();
?>