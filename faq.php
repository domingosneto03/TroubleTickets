<?php
require_once(__DIR__ . "/utils/session.php");
$session = new Session();

require_once(__DIR__ . "/database/connection.php");
require_once(__DIR__ . "/database/faq.class.php");
require_once(__DIR__ . "/templates/common.tpl.php");
require_once(__DIR__ . "/templates/faq.tpl.php");

$db = getDatabaseConnection();
$faqs = FAQ::getFaqs($db);

$title = "Mango Tickets - FAQs";

output_header($session, $title);
output_sidebar($session);
output_faq_body($session, $faqs);
output_footer();

?>