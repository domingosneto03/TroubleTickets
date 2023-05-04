<?php
require_once(__DIR__ . "/templates/common.tpl.php");
require_once(__DIR__ . "/templates/forms.tpl.php");
require_once(__DIR__ . "/utils/session.php");
$session = new Session();
$title = "Mango Tickets - Login";

output_header($session, $title);
output_sidebar();
output_login_form();
output_footer();
?>