<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
?>

<?php function output_header($session, $title) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title ?></title>
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" href="CSS/lettering.css">
        <link rel="stylesheet" href="CSS/positioning.css">
        <link rel="stylesheet" href="CSS/styling.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <script src="javascript/script.js" defer></script>
        <script src="javascript/settings.js" defer></script>
        <script src="javascript/faqs.js" defer></script>
        <script src="javascript/tags.js" defer></script>
    </head>
    <body>
        <header id="main_header">
            <?php if($session->isLoggedIn()) { ?>
                <a href="ticket_list.php"><img src="/images/logo.png" id="logo"></a>
            <?php  } else { ?>
                <a href="login.php"><img src="/images/logo.png" id="logo"></a>
                <?php } ?>
            <article id="right_side">
                <?php if ($session->isLoggedIn()) drawLogoutSection($session);
                    else drawLoginSection();
                ?>
            </article>
        </header>
<?php } ?>

<?php function output_sidebar($session) { ?>
    <aside id="side_bar">
        <a href="ticket_list.php" title="Ticket List">
            <span class="material-symbols-outlined">
                credit_card
            </span>
        </a>
        <?php if (isset($_SESSION['id'])) { ?>
        <a href="new_ticket.php" title="New Ticket">
        <?php } else {
            $session->addMessage("error", "You need to log in before you submit a new ticket") ?>
            <a href="ticket_list.php">
        <?php } ?>
            <span class="material-symbols-outlined">
                add_card
            </span>
        </a>
        <a href="faq.php" title="FAQs">
            <span class="material-symbols-outlined">
                help_center
            </span>
        </a>
        <a href="settings.php" title="Settings">
            <span class="material-symbols-outlined">
                settings
            </span>
        </a>
        <?php if ($session->isAdmin()) { ?>
        <a href="admin_page.php">
            <span class="material-symbols-outlined">
                manage_accounts
            </span>
        </a>
        <?php } ?>
    </aside>
<?php } ?>

<?php function output_alt_sidebar() { ?>
    <aside id="side_bar">
        <a href="faq.php" title="FAQs">
            <span class="material-symbols-outlined">
                help_center
            </span>
        </a>
    </aside>
<?php } ?>

<?php function output_footer() { ?>
    <footer id="main_footer">
            <p>João Ribeiro, Xavier Santos, Domingos Neto @ FEUP</p>
            <p>&copy 2023</p>
        </footer>
    </body>
</html>
<?php } ?>

<?php function drawLogoutSection(Session $session) { ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="<?= "profile.php?id=" . $session->getId() ?>"><img src="<?= $session->getProfilePic() ?>" alt="profile_pic" id="profile_pic"></a>
        <a href="<?= "profile.php?id=" . $session->getId() ?>" id="username"><?= $session->getUsername() ?></a>
        <button type="submit">Logout</button> 
    </form>
<?php } ?>

<?php function drawLoginSection() { ?>
    <a href="login.php" id="login_button">Login</a>
<?php } ?>
    