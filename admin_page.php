<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/utils/session.php');
    $session = new Session();

    if (!isset($_SESSION['id']) || !$session->isAdmin()) {
        header('Location: /no_access.php');
    }

    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/admin.tpl.php");
    require_once(__DIR__ . "/database/connection.php");

    $db = getDatabaseConnection();

    /*
    $agents = User::getBestAgents($db);
    $clients = User::getBestClients($db);*/

    $title = "Admin Page";
    output_header($session, $title);
    output_sidebar($session);
    output_admin_section($session, $agents, $clients);
    output_footer();
?>