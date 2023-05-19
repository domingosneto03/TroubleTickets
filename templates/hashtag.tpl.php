<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/hashtag.class.php");

    $db = getDatabaseConnection();
?>

<?php function output_hashtag(Session $session, Hashtag $hashtag) { ?>
    <div>
        <a href="" class="ticket_tag">#<?= $hashtag->name; ?></a>
        <?php  if ($session->isAgent()) { ?>
        <button>x</button>
        <?php } ?>
    </div>
<?php  } ?>

<?php function output_hashtag_list(Session $session, array $hashtags) { ?>
    <label for="edit_tags">Edit tags</label>
    <input type="checkbox" name="edit_tags" id="edit_tags">
    <div class="focused_ticket_tags">
        <?php foreach ($hashtags as $hashtag) {
            output_hashtag($session, $hashtag);
        } ?>
        <input name="tags" list="tag_list" placeholder="Choose tag(s)">
        <datalist id="tag_list">
            <?php
                global $db; 
                foreach (Hashtag::getAllTags($db) as $hashtag) { ?>
                <option value="<?= $hashtag->name; ?>">
            <?php } ?>
        </datalist>
        <button id="tag_adder">Add tag</button>
    </div>
<?php } ?>