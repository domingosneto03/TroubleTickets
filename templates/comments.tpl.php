<?php require_once(__DIR__ . "/../database/comment.class.php"); ?>

<?php function output_comment($comment) { ?>
    <article class="focused_ticket_comment">
        <div class="focused_ticket_comment_top">
            <h5 class="focused_ticket_comment_poster"><?= $comment->username ?></h5>
            <p class="focused_ticket_comment_date"><?= date('d-m-Y H:i', $comment->createdAt) ?></p>
        </div>
        <p class="focused_ticket_comment_text"><?= $comment->body ?></p>
    </article>
<?php } ?>


<?php function output_comment_section($comments) { ?>
    <div class="focused_ticket_comments">
        <h4>Discussion</h4>
        <!-- comments go from newest at the top to oldest at the bottom -->
        <?php if (isset($_SESSION['id'])) { ?>
        <form action="../actions/action_comment.php" class="comment_maker" method="post">
            <label for="comment_maker_input">Comment: </label>
            <input type="text" name="body" id="comment_maker_input">
            <input type="hidden" name="ticketId" value="<?= htmlspecialchars($_GET['id']) ?>">
            <input type="submit" value="Post">
        </form>
        <?php } foreach ($comments as $comment) {
            output_comment($comment);
        } ?>
    </div>
<?php } ?>