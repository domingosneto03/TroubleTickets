<?php require_once(__DIR__ . "/../database/faq.class.php"); ?>

<?php function output_faq_body(Session $session, $faqs) { ?>
    <main>
        <div class="top_bar">
            <h2 class="main_title">FAQs</h2>
            <?php if ($session->isAgent()) { ?>
            <button id="new_faq_button" class="top_bar_button">
                New FAQ
            </button>
            <?php } ?>
        </div>
        <form action="/../actions/action_new_faq.php" method="post" id="new_faq_form" class="new_faq_hidden">
            <label for="faq_question">Question:</label>
            <input type="text" name="faq_question" id="faq_question">
            <label for="faq_answer">Answer:</label>
            <textarea name="faq_answer" id="faq_answer" cols="" rows="8"></textarea>
            <div>
                <input type="submit" value="Publish">
                <input type="button" value="Cancel">    
            </div>
        </form>
        <?php foreach ($faqs as $faq) {
            output_faq($faq);
        } ?>
    </main>
<?php } ?>

<?php function output_faq(FAQ $faq) { ?>
    <article class="faq_faq">
        <div class="faq_faq_header">
            <h3><?= $faq->question() ?></h3>
            <a href="#<?= $faq->question() ?>" class="material-symbols-outlined">share</a>
        </div>
        <p><?= $faq->answer() ?></p>
    </article>    
<?php } ?>
