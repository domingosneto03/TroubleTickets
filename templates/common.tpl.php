<?php function output_header($session, $title) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title ?></title>
        <link rel="stylesheet" href="CSS/style.css">
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
    </head>
    <body>
        <header id="main_header">
            <h1><a href="template.html">Mango Tickets</a></h1>
            <article id="right_side">
                <form action="" id="search_bar">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" name="search_bar" placeholder="Search for anything!">
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
        <a href="faq.html">
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
    