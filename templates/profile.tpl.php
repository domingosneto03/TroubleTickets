<?php
    declare(strict_types = 1);
?>

<?php function output_profile($session, $user) { ?>
    <main>
        <article id="profile_main">
            <img src="<?= $user->userImage ?>" alt="profile image" id="profile_picture">

            <div id="profile_user">
                <p><?= $user->username ?></p>
                <?php if ($session->isAdmin()) { ?>
                    <p>Admin</p>
                <?php } else if ($session->isAgent()) { ?>
                    <p>Agent</p>
                <?php } else { ?>
                    <p>Client</p>
                <?php } ?>
                <p><?= $user->email ?></p>
            </div>
            <div id="bio">
                <p><?= $user->bio ?></p>
            </div>
            
            <?php if (isset($_SESSION['id'])) { ?>
            <a href="" id="profile_editor_button">
                Edit profile
            </a>
            <?php } ?>

            <!-- choose which of these to display using php magic -->
            <!-- these options only appear to Admins visiting the page -->
            <button class="admin_promoter_profile">Promote to Admin</button>
            <button class="agent_promoter_profile">Promote to Agent</button>
        </article>
    </main>
<?php } ?>