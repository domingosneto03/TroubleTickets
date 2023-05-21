<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/hashtag.class.php");
    require_once(__DIR__ . "/../database/ticket.class.php");

    $db = getDatabaseConnection();
?>

<?php function output_hashtag(Session $session, Hashtag $hashtag, int $ticketId) { ?>
    <div id="<?= "tag_" . $hashtag->id ?>">
        <a href="" class="ticket_tag">#<?= $hashtag->name; ?></a>
        <?php  if ($session->isAgent()) { ?>
        <button class="x_button" data-tag="<?= $hashtag->id ?>" data-ticket="<?= $ticketId ?>">x</button>
        <?php } ?>
    </div>
<?php  } ?>

<?php function output_hashtag_list(Session $session, Ticket $ticket) {
    global $db; ?>
    <?php if($ticket->status !== "closed") { ?>
    <label for="edit_tags">Edit tags</label>
    <input type="checkbox" name="edit_tags" id="edit_tags">
    <?php } ?>
    <div class="focused_ticket_tags" id="tag_container">
        <?php foreach ($ticket->getHashtags($db) as $hashtag) {
            output_hashtag($session, $hashtag, $ticket->id);
        } ?>
        <input id="tag_input" type="text" name="tags" list="tag_list" placeholder="Choose tag(s)">
        <datalist id="tag_list">
            <?php
                foreach (Hashtag::getAllTags($db) as $hashtag) { ?>
                <option value="<?= $hashtag->name; ?>"><?= $hashtag->name; ?></option>
            <?php } ?>
        </datalist>
        <button id="tag_adder" data-ticket="<?= $ticket->id ?>">Add tag</button>
    </div>
    
<?php } ?>