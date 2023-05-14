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
        <link rel="stylesheet" href="CSS/styling.css">
        <link rel="stylesheet" href="CSS/positioning.css">
        <link rel="stylesheet" href="CSS/lettering.css">
        <link rel="stylesheet" href="CSS/home.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
        <script src="javascript/script.js" defer></script>
    </head>
    <body>
        <header id="main_header">
            <a href="template.html"><img src="/images/logo.png" id="logo"></a>
            <article id="right_side">
                <a href="login.html"></a>
                </form>
                <?php 
                if ($session->isLoggedIn()) drawLogoutSection($session);
                else drawLoginSection();
                ?>
            </article>
        </header>
<?php } ?>

<?php function output_sidebar() { ?>
    <aside id="side_bar">
        <a href="template.html">
            <span class="material-symbols-outlined">
                home
            </span>
        </a>
        <a href="ticket_list.html">
            <span class="material-symbols-outlined">
                credit_card
            </span>
        </a>
        <a href="new_ticket.html">
            <span class="material-symbols-outlined">
                add_card
            </span>
        </a>
        <a href="faq.php">
            <span class="material-symbols-outlined">
                help_center
            </span>
        </a>
        <a href="">
            <span class="material-symbols-outlined">
                mail
            </span>
        </a>
        <a href="">
            <span class="material-symbols-outlined">
                settings
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
        <a href="profile.php"><?=$session->getUsername()?></a>
        <button type="submit">Logout</button> 
    </form>
<?php } ?>

<?php function drawLoginSection() { ?>
    <a href="login.php">
        <button>Login</button>
    </a>
<?php } ?>
    