<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/department.class.php');
    $db = getDatabaseConnection();
?>

<?php function output_profile($session, $user) {
    global $db; ?>
    <main>
        <article id="profile_main">
            <img src="<?= $user->userImage ?>" alt="profile image" id="profile_picture">

            <div id="profile_user">
                <p><?= $user->actualName ?></p>
                <p><?= $user->username ?></p>
                <?php if ($user->isAdmin($db)) { ?>
                    <p>Admin</p>
                <?php } elseif ($user->isAgent($db)) { ?>
                    <p>Agent</p>
                <?php } else { ?>
                    <p>Client</p>
                <?php } ?>
                <?php 
                    if ($user->isAgent($db) || $user->isAdmin($db)) { ?>
                        <p class="agent_profile_dep"> <?= $user->getDepartment($db) ?> </p>
                    <?php }
                ?>
                <p><?= $user->email ?></p>
            </div>
            <div id="bio">
                <p><?= $user->bio ?></p>
                <p>Gender: <?= $user->gender ?></p>
                <p>Born on: <?= date("d/m", $user->birthDate) ?></p>
            </div>
            
            <?php if (isset($_SESSION['id']) && $_SESSION['id'] === $user->id) { ?>
            <a href="/settings.php" id="profile_editor_button">
                Edit profile
            </a>
            <?php } ?>

            <?php if ($session->isAdmin()) { ?>
                <?php 
                    if ($user->isAgent($db) && ! $user->isAdmin($db)) { ?>
                        <form action="/../actions/action_promote_to_admin.php" method="post">
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <button type="submit" class="admin_promoter_profile">Promote to Admin</button>
                        </form>
                    <?php }    
                ?>
                <?php
                    if(! $user->isAgent($db) && ! $user->isAdmin($db)) { ?>
                        <form action="/../actions/action_promote_to_agent.php" method="post" class="agent_promotion">
                            <select name="department" class="department_selector">
                                <option value="" selected>Choose department</option>
                                <?php foreach(Department::getAllDepartments($db) as $dep) { ?> 
                                    <option value="<?= $dep->id ?>"> <?= $dep->name ?> </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <button type="submit" class="agent_promoter_profile">Promote</button>
                        </form>
                    <?php }
                ?>
            <?php } ?>
        </article>
    </main>
<?php } ?>