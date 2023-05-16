<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/database/connection.php");
    require_once(__DIR__ . "/database/user.class.php");
    require_once(__DIR__ . "/templates/common.tpl.php");
    require_once(__DIR__ . "/templates/profile.tpl.php");

    $db = getDatabaseConnection();

    $id = (int)$_GET['id'];
    $user = User::getUserById($db, $id);
    $title = $user->username . "'s profile";

    output_header($session, $title);
    output_sidebar($session);
    output_profile($session, $user);
    output_footer();

?>