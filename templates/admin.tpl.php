<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    $db = getDatabaseConnection();
?>

<?php function output_admin_section(Session $session, $agents, $clients) { ?>
    <main id="admin_main">
        <div class="top_bar">
            <h2 class="main_title">Administrator Management</h2>
        </div>

        <div id="management_main">
            <?php output_agent_list($agents) ?>
            <?php output_client_list($clients) ?>
    
            <div id="management_right_side">
                <?php output_admin_options(); ?>
                <?php output_admin_statistics(); ?>
            </div>  
        </div>
    </main>
<?php } ?>

<?php function output_agent_list($agents) { ?>
    <div id="agent_list">
        <!-- a mesma cena mas para clientes -->
        <p>Agents</p>
        <div>
            <?php foreach ($agents as $agent) { ?>
            <!-- aqui sim vai a lista de clientes -->
            <article class="agent_list_item">
                <a href="<?php "/profile.php?id=" . $agent->id; ?>" class="agent_list_item_img"><img src="<?= $agent->userImage ?>" alt="profile_pic"></a><!-- perfil do gajo -->
                <a href="<?php "/profile.php?id=" . $agent->id; ?>" class="agent_list_item_name">
                    <?= $agent->username; ?>
                </a>
                <div class="agent_list_item_department">
                    <p>Department:&nbsp</p>
                    <p> <?= $agent->department ?> </p>
                </div>
            </article>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php function output_client_list($clients) { ?>
    <div id="client_list">
        <!-- a mesma cena mas para clientes -->
        <p>Clients</p>
        <div>
            <?php foreach ($clients as $client) { ?>
            <!-- aqui sim vai a lista de clientes -->
            <article class="client_list_item">
                <a href="<?php "/profile.php?id=" . $client->id; ?>" class="client_list_item_img"><img src="<?= $client->userImage ?>" alt="profile_pic"></a><!-- perfil do gajo -->
                <a href="<?php "/profile.php?id=" . $client->id; ?>" class="client_list_item_name">
                    <?= $client->username; ?>
                </a>
            </article>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php function output_admin_options() { 
    global $db; ?>
    <div id="manage_buttons">
        <label for="manage_departments_button">Manage Departments</label>
        <input type="checkbox" name="manage_departments_button" id="manage_departments_button">
        <div>
            <p>Departments</p>
            <ul class="department_list_admin">
                <?php  foreach(Department::getAllDepartments($db) as $department) { ?>
                    <?php if ($department->name != "None") {
                        ?> <li class="department_list_admin_item"><?= $department->name ?></li> <?php 
                    } ?>
                <?php } ?>
            </ul>
            <form action="/../actions/action_add_department.php" method="post">
                <input type="text" name="add_department" id="add_department" maxlength="15" placeholder="Add department name">
                <input type="submit" value="Add">
            </form>
        </div>

        <!-- <label for="manage_statuses_button">Create New Status</label>
        <input type="checkbox" name="manage_statuses_button" id="manage_statuses_button">
        <div>
            <p>Statuses</p>
            <ul class="status_list_admin">
                <li class="status_list_admin_item">Open</li>
                <li class="status_list_admin_item">Assigned</li>
                <li class="status_list_admin_item">Closed</li>
            </ul>
            <form action="">
                <input type="text" name="add_status" id="add_status" maxlength="15" placeholder="Enter department name">
                <input type="submit" value="Add status">
            </form>
        </div> -->
    </div>
<?php } ?>

<?php function output_admin_statistics() {
    global $db; ?>
    <div id="statistics">
        <p>New users in the last week: <?= User::getNewUsersWeek($db); ?></p>
        <p>New users in the last month: <?= User::getNewUsersMonth($db); ?></p>
        <p>New tickets in the last week: <?= Ticket::getNewTicketsWeek($db); ?></p>
        <p>New tickets in the last month: <?= Ticket::getNewTicketsMonth($db); ?></p>
        <p>Tickets closed in the last week: <?= Ticket::getClosedTicketsWeek($db); ?></p>
        <p>Tickets closed in the last month: <?= Ticket::getClosedTicketsMonth($db); ?></p>
    </div>
<?php } ?>