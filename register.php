<?php 
require_once(__DIR__ . "/templates/common.tpl.php");
require_once(__DIR__ . "/templates/forms.tpl.php");
require_once(__DIR__ . "/utils/session.php");

$session = new Session();
$title = "Mango Tickets - register user";

output_header($session, $title);
output_sidebar($session);
output_register_form($session);
output_footer();
?>