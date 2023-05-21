<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/department.class.php");
    require_once(__DIR__ . "/../database/hashtag.class.php");
    require_once(__DIR__ . "/../database/user.class.php");
    require_once(__DIR__ . "/comments.tpl.php");
    require_once(__DIR__ . "/hashtag.tpl.php");

    $db = getDatabaseConnection();
?>

<?php function output_ticket_card(Ticket $ticket) {
    global $db; 
    $user = User::getUserById($db, $ticket->clientId);?>
    <article class="ticket">
        <a href="<?= "/profile.php?id=" . $ticket->clientId ?>" class="ticket_user_img"><img src="<?= $user->userImage ?>" alt="florzinha uau"></a>
        <div class="ticket_info_top">
            <div>
                <a href="<?= "/ticket.php?id=" . $ticket->id ?>" class="ticket_title"><h4><?= $ticket->title ?></h4></a> <!-- link para o ticket -->
                <p class="priority">Priority:</p>
                <p class="<?= $ticket->getPriority() ?>"><?= $ticket->getPriority() ?></p>
            </div>
            <p class="ticket_deadline">Deadline: <?= date("d-m-Y", $ticket->deadline) ?></p>
        </div>
        <div class="ticket_info_bottom">
            <p class="ticket_user">Created by <a href="<?= "/profile.php?id=" . $ticket->clientId ?>" class="ticket_user"><?= $ticket->getClientName($db) ?></a></p>
            <p class="ticket_date">Created at <?=  date("d-m-Y", $ticket->createdAt ) ?></p>
            
            <p class="ticket_department"><?= $ticket->getDepartment($db) ?></p>
            
            <p class="ticket_status"><?= $ticket->status ?></p>
            <?php $agent = $ticket->getAgentName($db); ?>
            <?php if (is_null($agent)) { ?>
                <p class="ticket_agent">Not assigned</p>
            <?php } else { ?>
                <a href="<?= "/profile.php?id=" . $ticket->assigned ?>" class="ticket_agent"><p><?= $agent ?></p></a>
            <?php } ?>
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
            <?php if(empty($tickets)) { ?>
                <p id="not_found">Oops! We could not find any tickets to match your criteria!</p>
            <?php } ?>
            <?php foreach ($tickets as $ticket) {
                output_ticket_card($ticket);
            } ?>
            </article>
            <?php output_ticket_filters($session); ?>
        </div>
    </main>
<?php } ?>

<?php function output_ticket_filters($session) { 
    global $db; ?>
    <article id="outer_filters">
        <form method="post" action="../actions/action_my_tickets.php">
            <label for="my_tickets_button" class="filter_checker">My tickets</label>
            <input type="submit" name="my_tickets" id="my_tickets_button">
        </form>
        <?php  if ($session->isAgent() || $session->isAdmin()) { ?>
        <form method="post" action="../actions/action_tracked_tickets.php">
            <label for="tracked_tickets_button" class="filter_checker">Tracked tickets</label>
            <input type="submit" name="tracked_tickets" id="tracked_tickets_button">
        </form>
        <?php } ?>
        <form id="filters" method="post" action="/../actions/action_filter_tickets.php">
            <label for="orderer">Sort:</label>
            <select name="ordering" id="orderer">
                <option value="">Select an option</option>
                <option value="htl_priority">High-Low Priority</option>
                <option value="lth_priority">Low-High Priority</option>
                <option value="most_recent">Newest</option>
                <option value="least_recent">Oldest</option>
            </select>
            <label for="sel_priority">Priority:</label>
            <select name="filter[priority]" id="sel_priority">
                <option value="">Select a priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
            </select>
            <label for="sel_department">Department:</label>
            <select name="filter[department]" id="sel_department">
                <option value="">Select a department</option>
                <?php $departments = Department::getAllDepartments($db); 
                    foreach ($departments as $department) { ?>
                <option value="<?= $department->id ?>"><?= $department->name ?></option>
                <?php } ?>
            </select>
            <label for="sel_tags">Tags:</label>
            <select name="filter[tag]" id="sel_tags">
                <option value="">Select a tag</option>
                <?php $hashtags = Hashtag::getAllTags($db);
                    foreach ($hashtags as $hashtag) { ?>
                <option value="<?= $hashtag->id ?>"><?= $hashtag->name ?></option>
                <?php } ?>
            </select>
            <label for="sel_date_start">From:</label>
            <input type="date" name="date_start" id="sel_date_start">
            <label for="sel_date_end">To:</label>
            <input type="date" name="date_end" id="sel_date_end">
            <input type="submit" value="Apply" id="submit_sort">
        </form>
    </article>
<?php } ?>

<?php function output_full_ticket($session, $ticket) { ?>
    <?php $db = getDatabaseConnection(); ?>
    <main>
        <div id="ticket_info_main">
            <div class="top_bar_info">
                <div>
                    <h3><?= $ticket->title ?></h3>
                    <p><?= $ticket->getDepartment($db) ?></p>
                </div>
                
                <div>
                    <p>Deadline: <?= date("d-m-Y", $ticket->deadline) ?></p> <!--change to color red if already due, yellow if due in 2/3 days idk-->

                    <?php if ((isset($_SESSION['id']) && $ticket->clientId === $session->getId()) && $ticket->status != "closed") { ?>
                    <a href=<?= "/edit_ticket.php?id=" . $_GET['id']; ?> id="edit_ticket">
                        Edit Ticket
                    </a>
                    <?php } ?>
                    <?php
                        if (($session->isAdmin() || ($session->getId()==($ticket->clientId || $ticket->assigned))) && $ticket->status != "closed") { ?>
                            <form action="/../actions/action_close_ticket.php" method="post">
                                <input type="hidden" value="<?= $ticket->id ?>" name="ticket_id">
                                <button type="submit" id="ticket_closer">Close Ticket</button>
                            </form>
                        <?php }
                    ?>
                    <?php 
                        if (($session->isAdmin() || ($session->isAgent() && User::getUserById($db, $session->getId())->department==$ticket->department)) && $ticket->status!="closed") { ?>
                            <form action="/../actions/action_change_ticket_department.php" method="post">
                                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                                <select name="new_department" id="new_department">
                                    <option value="">Choose a new Department</option>
                                    <?php 
                                        foreach (Department::getAllDepartments($db) as $dep){
                                            if ($dep->id != $ticket->department) { ?>
                                                <option value="<?= $dep->id ?>"><?= $dep->name ?></option>
                                            <?php }
                                        }
                                    ?>
                                </select>
                                <button type="submit" id="dep_changer">Change department</button>
                            </form>
                        <?php }
                    ?>
                </div>
            </div>

            <p class="focused_ticket_text"><?= $ticket->body ?></p>

            <div class="focused_ticket_images">
                <div class="thumbnail-container">
                    <?php foreach ($ticket->getFiles($db) as $file) { ?>
                        <img id="ticket_image" src="<?= $file ?>" class="ticket_image thumbnail">
                    <?php } ?>
                </div>
                <div class="image-overlay" id="imageOverlay">
                    <span id="closeButton" class="close-button">&times;</span>
                    <img src="" class="expanded-image" id="expandedImage">
                </div>
            </div>
                
            <div class="outer_tags">
                <?php output_hashtag_list($session, $ticket); ?>
            </div>
            
            <div class="focused_ticket_info">
                <p>Ticket created by <a href="<?= "/profile.php?id=" . $ticket->clientId ?>"><?= $ticket->getClientName($db) ?></a> on <?= date("d-m-Y", $ticket->createdAt )?> </p>
                
                <div>
                    <p>Status: <?php if ($ticket->status === "open") { 
                        ?>Open<?php } 
                        elseif ($ticket->status === "closed") { 
                        ?>Closed<?php } 
                        else/* if ($ticket->status === "assigned") */ { 
                        ?>Assigned to agent <a href="<?= "/profile.php?id=" . $ticket->assigned ?>"><?= $ticket->getAgentName($db) ?></a><?php } ?>
                    </p>

                    <?php if (($ticket->status == "open" || $ticket->assigned == $session->getId()) && (User::getUserById($db, $session->getId())->department == $ticket->department || $session->isAdmin())) { ?>
                        <form action="/../actions/action_assign_ticket.php" method="post">
                            <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                            <select name="agent_to_assign" id="agent_to_assign">
                                <option value="">Choose Agent</option>
                                <?php 
                                    foreach(Department::getDepartment($db, $ticket->department)->getAllAgentsOfDepartment($db) as $list_agent) {
                                        if ($list_agent->id == $session->getId()) {
                                            ?> <option value=" <?= $list_agent->id ?> ">Myself</option> <?php
                                        }
                                        else {
                                            ?> <option value=" <?= $list_agent->id ?> "><?= $list_agent->username ?></option> <?php
                                        }
                                    }
                                ?>
                            </select>
                            <button type="submit">Assign</button>
                        </form>
                    <?php } ?>
                </div>
                
            </div>

            <?php output_comment_section($session, $ticket) ?>
        </div>
    </main>

<?php } ?>