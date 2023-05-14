<?php
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/hashtag.tpl.php");
?>

<?php function output_ticket_card(Ticket $ticket) { ?>
    <a href='<?= "/ticket.php?id=" . $ticket->id ?>' class="ticket">
        <article>
            <h4 class="ticket_title"><?= $ticket->title ?></h4>
            <img src="Group 1.png" alt="florzinha uau" class="ticket_user_img">
            <p class="ticket_text"><?= $ticket->body ?></p>
            <p class="ticket_date">25/6/2022</p>
            <p class="ticket_user"><?= $ticket->clientId ?></p>
            <p class="ticket_agent"><?= $ticket->assigned ?></p>
            <p class="ticket_status"><?= $ticket->status ?></p>
            <p class="ticket_deadline">2/7/2022</p>
            <p class="ticket_tags"> #tech #printer</p>
            <p class="ticket_department"><?= $ticket->department ?></p>
        </article>
    </a>
<?php } ?>


<?php function output_ticket_list($session, $tickets) { ?>
    <main>
        <article id="ticket_listing">
            <div id="top_bar">
                <h2 class="main_title">Tickets</h2>
                <a href="new_ticket.php" id="new_ticket">
                    <div>
                        <p>New Ticket</p>
                    </div>
                </a>
            </div>
            
            <div id="tickets_main">
                <article id="tickets">
                <?php foreach ($tickets as $ticket) {
                    output_ticket_card($ticket);
                } ?>
                </article>
                <form id="filters">
                    <input type="button" value="My tickets">
                    <input type="button" value="Tracked tickets"> <!-- enables if user is agent/admin -->
                    <label for="orderer">Sort:</label>
                    <select name="" id="orderer">
                        <option value="htl_priority">High-Low Priority</option>
                        <option value="lth_priority">Low-High Priority</option>
                        <option value="most_recent">Newest</option>
                        <option value="least_recent">Oldest</option>
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
            </div>  
    </article>
</main>
<?php } ?>

<?php function output_full_ticket($session, $ticket) { ?>
    <?php $db = getDatabaseConnection(); ?>
    <main>
        <div class="top_bar">
            <h3><?= $ticket->title ?></h3>
            <div>
                <p>Deadline: <?= date("d-m-Y", $ticket->deadline) ?></p> <!--change to color red if already due, yellow if due in 2/3 days idk-->

                <?php if ($ticket->clientId === $session->getId()) { ?>
                <a href=<?= "/new_ticket.php?id=" . $_GET['id']; ?> class="top_bar_button">
                    Edit Ticket
                </a>
                <?php } ?> <!-- PHP: only visible to the user who created the ticket -->
                <!-- takes the user to the new_ticket.html but with the fields already filled with the ticket's info -->
                <!-- and instead of "Create ticket" it has two buttons: "Save" and "Cancel" -->
                <!-- not really sure how to do this -->
            </div>
        </div>
        
        <p class="focused_ticket_text"><?= $ticket->body ?></p>

        <div class="focused_ticket_docs">
            <!-- i don't really know how to show the files but it's whatever, not necessary, 
            will probably do this later -->
        </div>

        <div class="focused_ticket_images">
            <!-- append images here with php magic -->
            <!-- <a href="" target="_blank" class="focused_ticket_image" rel="noopener noreferrer"><img src="" alt=""></a> -->
            <!-- clicking on an image opens it in another tab, might have to juggle the html to show just the picture or smth -->
            <!-- o "rel="noopener noreferrer"" serve para evitar phishing, bastante útil -->
        </div>

        <?php output_hashtag_list($session, $ticket->getHashtags($db)); ?>
        
        <div class="focused_ticket_info">
            <p>Ticket created by <a href=""><?= $ticket->getClientName($db) ?></a> on <?= date("d-m-Y", $ticket->getCreationDate($db))?></p>
            <p>Status: Assigned to agent <a href=""><?= $ticket->getAgentName($db) ?></a></p> <!-- 
                use php to get status, if assigned use css after "Assigned" to add "to agent Frederico" or smth
                -->
        </div>
        
        <?php output_comment_section($ticket->getComments($db)); ?>
    </main>


<?php } ?>