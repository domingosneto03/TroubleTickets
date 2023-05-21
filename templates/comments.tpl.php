<?php 
    require_once(__DIR__ . "/../database/comment.class.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/connection.php");
    $db = getDatabaseConnection();
?>

<?php function output_comment(Comment $comment) { 
    global $db; ?>
    <article class="focused_ticket_comment">
        <a href="<?= "profile.php?id=" . $comment->userId ?>"><img src="<?= User::getUserById($db, $comment->userId)->userImage ?>" alt="comment_pfp" class="comment_pfp"></a>
        
        <div class="focused_ticket_comment_top">
            <a class="focused_ticket_comment_poster" href="<?= "profile.php?id=" . $comment->userId ?>"><?= $comment->username ?></a>
            <p class="focused_ticket_comment_date"><?= date('d-m-Y H:i', $comment->createdAt) ?></p>
        </div>
        <p class="focused_ticket_comment_text"><?= $comment->body ?></p>
    </article>
<?php } ?>


<?php function output_comment_section(Session $session, Ticket $ticket) {
    global $db; ?>
    <div class="focused_ticket_comments">
        <h4>Discussion</h4>
        <!-- comments go from newest at the top to oldest at the bottom -->
        <?php if (isset($_SESSION['id']) && $ticket->status !== "closed") {
            if (($session->isAdmin()) ||
                ($session->isAgent() && $_SESSION['id'] === $ticket->assigned) ||
                (!$session->isAdmin() && $_SESSION['id'] === $ticket->clientId))  ?>
        <form action="../actions/action_comment.php" class="comment_maker" method="post">
            <label for="comment_maker_input">Comment: </label>
            <input type="text" name="body" id="comment_maker_input">
            <input type="hidden" name="ticketId" value="<?= htmlspecialchars($_GET['id']) ?>">
            <input type="submit" value="Post">
        </form>
        <?php } foreach ($ticket->getComments($db) as $comment) {
            output_comment($comment);
        } ?>
    </div>
<?php } ?>