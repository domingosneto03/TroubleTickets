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
        <form action="" class="comment_maker">
            <label for="comment_maker_input">Comment: </label>
            <input type="text" name="comment_maker_input" id="comment_maker_input">
            <input type="submit" value="Post">
        </form>
        <?php foreach ($comments as $comment) {
            output_comment($comment);
        } ?>
    </div>
<?php } ?>