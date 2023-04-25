<?php
require_once(__DIR__ . "/templates/common.tpl.php");
require_once(__DIR__ . "/templates/forms.tpl.php");
require_once(__DIR__ . "/utils/session.php");
$session = new Session();
$title = "Mango Tickets - Login";

foreach ($session->getMessages() as $message) {
    echo $message['text'];
}

output_header($session, $title);
output_sidebar();
output_login_form();
output_footer();
?>