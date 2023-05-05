<?php
    require_once(__DIR__ . "/../database/ticket.class.php");
?>


<?php function output_ticket_card(Ticket $ticket) { ?>
    <a href="placeholder_ticket_info.html" class="ticket">
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


<?php function output_ticket_list($tickets) { ?>
    <main>
        <article id="ticket_listing">
            <div id="top_bar">
                <h2 class="main_title">Tickets</h2>
                <a href="new_ticket.html" id="new_ticket">
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