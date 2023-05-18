<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/utils/session.php');
    $session = new Session();

    require_once(__DIR__ . "/templates/common.tpl.php");

    $title = "Mango Tickets - No Access";
    output_header($session, $title);
    output_sidebar($session);
?>
<main>
    <div class="no_access">
        <h3 id="no_access_title">This page is reserved for admins of the website</h3>
        <p id="no_access_message">Go back to <a href="/ticket_list.php">home page</a></p>
    </div>
</main>


<?php
    output_footer();
?>