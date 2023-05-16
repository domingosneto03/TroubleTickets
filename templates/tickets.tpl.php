<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/comments.tpl.php");
    require_once(__DIR__ . "/hashtag.tpl.php");

    $db = getDatabaseConnection();
?>

<?php function output_ticket_card(Ticket $ticket) {
    global $db; ?>
    <article class="ticket">
        <a href="" class="ticket_user_img"><img src="Group 1.png" alt="florzinha uau"></a>
        <div class="ticket_info_top">
            <div>
                <a href="<?= "/ticket.php?id=" . $ticket->id ?>" class="ticket_title"><h4><?= $ticket->title ?></h4></a> <!-- link para o ticket -->
            </div>
            <p class="ticket_deadline">Deadline: <?= date("d-m-Y", $ticket->deadline) ?></p>
        </div>
        <div class="ticket_info_bottom">
            <a href="" class="ticket_user"><p><?= $ticket->getClientName($db) ?></p></a>
            <p class="ticket_date">Created at <?=  date("d-m-Y", $ticket->getCreationDate($db)) ?></p>
            <p class="ticket_department"><?= $ticket->getDepartment($db) ?></p>
            <p class="ticket_status"><?= $ticket->status ?></p>
            <?php $agent = $ticket->getAgentName($db); ?>
            <?php if (is_null($agent)) { ?>
                <p class="ticket_agent">Not assigned</p>
            <?php } else { ?>
                <a href="" class="ticket_agent"><p><?= $agent ?></p></a>
            <?php } ?>
        </div>
        <!-- <button class="ticket_destroyer">Delete</button> -->
    </article>
<?php } ?>

<?php function output_ticket_card(Ticket $ticket) { ?>
    <article class="ticket">
        <a href="" class="ticket_user_img"><img src="Group 1.png" alt="florzinha uau"></a>
        <div class="ticket_info_top">
            <div>
                <a href="placeholder_ticket_info.html" class="ticket_title"><h4><?= $ticket->title ?></h4></a> <!-- link para o ticket -->
                <p class="ticket_tags"><?php 
                    $tags = get_tags()
                ?></p>
            </div>
            <p class="ticket_deadline">2/7/2022</p>
        </div>
        <div class="ticket_info_bottom">
            <a href="" class="ticket_user"><p>Carlos</p></a>
            <p class="ticket_date">25/6/2022</p>
            <p class="ticket_department">Tech</p>
            <p class="ticket_status">Assigned</p>
            <a href="" class="ticket_agent"><p>Frederico</p></a>
        </div>
        <!-- <button class="ticket_destroyer">Delete</button> -->
    </article>
<?php } ?>

<?php function output_ticket_list($session, $tickets) { ?>
    <main id="ticket_list_main">
        <div class="top_bar">
            <h2 class="main_title">Tickets</h2>
            <div>
                <form action="" id="search_bar">
                    <label for="search_bar_id" class="material-symbols-outlined">search</label>
                    <input type="text" name="search_bar" id="search_bar_id" placeholder="Search here">
                </form>
                <a href="new_ticket.php" class="top_bar_button">
                    New Ticket
                </a>
            </div>
        </div>
        
        <div id="tickets_main">
            <article id="tickets">
            <?php foreach ($tickets as $ticket) {
                output_ticket_card($ticket);
            } ?>
            </article>
            <article id="outer_filters">
                <label for="my_tickets_button" class="filter_checker">My tickets</label>
                <input type="checkbox" name="my_tickets" id="my_tickets_button">
                <label for="tracked_tickets_button" class="filter_checker">Tracked tickets</label>
                <input type="checkbox" name="tracked_tickets" id="tracked_tickets_button">
                <form id="filters">
                    <label for="orderer">Sort:</label>
                    <select name="" id="orderer">
                        <option value="htl_priority">High-Low Priority</option>
                        <option value="lth_priority">Low-High Priority</option>
                        <option value="most_recent">Newest</option>
                        <option value="least_recent">Oldest</option>
                        <option value="ending_soon">Ending Sooner</option>
                    </select>
                    <label for="sel_priority">Priority:</label>
                    <select name="" id="sel_priority">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <label for="sel_department">Department:</label>
                    <select name="" id="sel_department">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                    <label for="sel_tags">Tags:</label>
                    <select name="" id="sel_tags">
                        <option value="tech">Tech</option>
                        <option value="auto">Auto</option>
                        <option value="health">Health</option>
                    </select>
                    <label for="sel_date_start">From:</label>
                    <input type="date" name="" id="sel_date_start">
                    <label for="sel_date_end">To:</label>
                    <input type="date" name="" id="sel_date_end">
                    <input type="submit" value="Apply" id="submit_sort">
                </form>
            </article>
        </div>
    </main>
<?php } ?>

<?php function output_full_ticket($session, $ticket) { ?>
    <?php $db = getDatabaseConnection(); ?>
    <main>
        <div id="ticket_info_main">
            <div class="top_bar_info">
                <h3><?= $ticket->title ?></h3>
                <div>
                    <p>Deadline: <?= date("d-m-Y", $ticket->deadline) ?></p> <!--change to color red if already due, yellow if due in 2/3 days idk-->

                    <?php if ($ticket->clientId === $session->getId()) { ?>
                    <a href=<?= "/new_ticket.php?id=" . $_GET['id']; ?> id="edit_ticket">
                        Edit Ticket
                    </a>
                    <?php } ?> <!-- PHP: only visible to the user who created the ticket -->
                    <!-- takes the user to the new_ticket.html but with the fields already filled with the ticket's info -->
                    <!-- and instead of "Create ticket" it has two buttons: "Save" and "Cancel" -->
                    <!-- not really sure how to do this -->
                </div>
            </div>

            <p class="focused_ticket_text"><?= $ticket->body ?></p>

            <div class="focused_ticket_images">
                <div class="thumbnail-container">
                    <?php foreach ($ticket->getFiles($db) as $file) { ?>
                        <img id="ticket_image" src="<?= $file ?>" class="ticket_image thumbnail">
                    <?php } ?>
                <!-- append images here with php magic -->
                <!-- <a href="" target="_blank" class="focused_ticket_image" rel="noopener noreferrer"><img src="" alt=""></a> -->
                <!-- clicking on an image opens it in another tab, might have to juggle the html to show just the picture or smth -->
                <!-- o "rel="noopener noreferrer"" serve para evitar phishing, bastante útil -->
                </div>
                <div class="image-overlay" id="imageOverlay">
                    <span id="closeButton" class="close-button">&times;</span>
                    <img src="" class="expanded-image" id="expandedImage">
                </div>
            </div>

            <?php output_hashtag_list($session, $ticket->getHashtags($db)); ?>
            
            <div class="focused_ticket_info">
                <p>Ticket created by <a href=""><?= $ticket->getClientName($db) ?></a> on <?= date("d-m-Y", $ticket->getCreationDate($db))?> </p>
                <p> Status: Assigned to agent <a href=""><?= $ticket->getAgentName($db) ?></a></p> <!-- 
                    use php to get status, if assigned use css after "Assigned" to add "to agent Frederico" or smth
                    -->
            </div>

            <div class="focused_ticket_docs">
                <!-- vão aqui os docs -->
            </div>

            <!-- aqui tem de ter uma função para os comentários aparecerem como o exemplo abaixo -->
            <!-- 
                <div class="focused_ticket_comments">
                    <h4>Discussion</h4>

                    <form action="" class="comment_maker">
                        <label for="comment_maker_input">Add a comment: </label>
                        <input type="text" name="comment_maker_input" id="comment_maker_input">
                        <input type="submit" value="Post">
                    </form>

                    <article class="focused_ticket_comment">
                        <div class="focused_ticket_comment_top">
                            <h5 class="focused_ticket_comment_poster">Adalberto</h5>
                            <p class="focused_ticket_comment_date">insert date and time here</p>   
                        </div>
                        <p class="focused_ticket_comment_text">i love html so much &lt;333333 </p>
                    </article>
                </div>
             -->
        </div>
    </main>

<?php } ?>