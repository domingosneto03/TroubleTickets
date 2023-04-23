<?php

function output_header($title) { ?>
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title ?></title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="home.css">
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
                <a href="login.html">
                    <form action="" id="login_button">
                        <input type="button" value="Login"> <!-- changes to image of user when logged in, with red dot if there
                    are new notifications -->
                    </form>  
                </a>
                
            </article>
        </header>
<?php } 

function output_sidebar() { ?>
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
<?php } 

function output_footer() { ?>
    <footer id="main_footer">
            <p>João Ribeiro, Xavier Santos, Domingos Neto @ FEUP</p>
            <p>&copy 2023</p>
        </footer>
    </body>
</html>
<?php } ?>