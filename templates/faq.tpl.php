<?php require_once(__DIR__ . "/../database/faq.class.php"); ?>

<?php function output_faq_body($faqs) { ?>
    <main>
        <h2 class="main_title">FAQs</h2>
    <?php foreach ($faqs as $faq) {
        output_faq($faq);
    } ?>
    </main>
<?php } ?>

<?php function output_faq(FAQ $faq) { ?>
    <article>
        <h3><?= $faq->question() ?></h3>
        <p><?= $faq->answer() ?></p>
    </article>    
<?php } ?>
