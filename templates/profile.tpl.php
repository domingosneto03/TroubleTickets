<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();
?>

<?php function output_profile($session, $user) {
    global $db; ?>
    <main>
        <article id="profile_main">
            <img src="<?= $user->userImage ?>" alt="profile image" id="profile_picture">

            <div id="profile_user">
                <p><?= $user->username ?></p>
                <?php if ($user->isAdmin($db)) { ?>
                    <p>Admin</p>
                <?php } elseif ($user->isAgent($db)) { ?>
                    <p>Agent</p>
                <?php } else { ?>
                    <p>Client</p>
                <?php } ?>
                <p><?= $user->email ?></p>
            </div>
            <div id="bio">
                <p><?= $user->bio ?></p>
            </div>
            
            <?php if (isset($_SESSION['id']) && $_SESSION['id'] === $user->id) { ?>
            <a href="" id="profile_editor_button">
                Edit profile
            </a>
            <?php } ?>

            <?php if ($session->isAdmin()) { ?>
            <button class="admin_promoter_profile">Promote to Admin</button>
            <?php 
                if ($user->isAgent($db) || $user->isAdmin($db)){}
                
                else { ?>
                    <button class="agent_promoter_profile">Promote to Agent</button>
                <?php }
            ?>
            
            <?php } ?>
        </article>
    </main>
<?php } ?>