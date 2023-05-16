<?php
declare(strict_types = 1);

require_once(__DIR__ . "/templates/common.tpl.php");
require_once(__DIR__ . "/utils/session.php");

$session = new Session();
$title = "Mango tickets - a simpler way of trouble ticketing";

output_header($session, $title);
output_sidebar($session); 
?>

<main id="home_main">
    <img src="components/background2.jpg" alt="background">
    <section id="phrase">
        <h2>A Simpler Way of Trouble Ticketing</h2>
        <a href="">
            <button formaction="#" formmethod="post">Visit more</button>
        </a>
    </section>
</main>

<?php output_footer(); ?>