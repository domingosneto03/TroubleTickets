<?php 
    declare(strict_types = 1);
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/department.class.php");
    $db = getDatabaseConnection();
?>

<?php function output_login_form() { ?>
    <main>
        <section id="login">
            <h2>Login</h2>
            <form>
                <label>Username
                    <input type="text" name="username" placeholder="Type your username or email">
                </label>
                <label>Password
                    <input type="password" name="password" placeholder="Type your password">
                </label>
                <button formaction="actions/action_login.php" formmethod="post">Login</button>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </form>
            </section>
    </main>
<?php } ?>

<?php function output_register_form() { ?>
    <main>
        <section id="register">
            <h2>Register</h2>
            <form enctype="multipart/form-data">
                <label>Username
                    <input type="text" id="username" name="username" placeholder="Create a username">
                    <span id="usernameError"></span>
                </label>
                <label>E-mail
                    <input type="email" name="email" placeholder="Type your email">
                </label>
                <label>Password
                    <input type="password" id="password" name="password" placeholder="Create your password">
                    <span id="passwordError"></span>
                </label>
                <label>Confirm Password
                    <input type="password" id="confirmPassword" name="confimPassword" placeholder="Confirm your password">
                    <span id="confirmPasswordError"></span>
                </label>
                <label>
                    <input type="text" name="bio" placeholder="Write a short bio about yourself" max="55">
                </label>
                <label>Image
                    <input type="file" name="userImage" id="user_image_upload">
                </label>
                <button formaction="../actions/action_register.php" formmethod="post">Register</button>
            </form>
        </section>
    </main>
<?php } ?>

<?php function output_new_ticket_form(?Ticket $ticket = null) {
    global $db; ?>
    <main>
        <div class="top_bar">
            <h2 class="main_title"><?php if (!is_null($ticket)) { echo "Edit ticket"; } else { echo "New ticket"; } ?></h2>
        </div>
        <?php 
            $newTicket = "../actions/action_new_ticket.php";
            $editTicket = "../actions/action_edit_ticket.php";
        ?>
        <form action=<?php if (!is_null($ticket)) { echo $editTicket; } else { echo $newTicket; } ?> method="post" id="new_ticket_form" enctype="multipart/form-data">
            <div id="title">
                <label for="ticket_title" id="title_label">Ticket title:</label>
                <input type="text" name="title" id="ticket_title" required maxlength="55" <?php if (!is_null($ticket)) { ?>value="<?php echo htmlspecialchars($ticket->title, ENT_QUOTES); } ?>">
            </div>
            <div id="text">
                <label for="ticket_text" id="text_label">Ticket description:</label>
                <!-- tags go as #tag in the text box, boa sorte para implementar essa merda Ribeiro -->
                <!-- depois o sql convém ter uma secção de texto composta pelas tags separadas por vírgulas para
                as poder mostrar depois no ticket -->
                <textarea name="body" id="ticket_text" cols="30" rows="20" required><?php if (!is_null($ticket)) { echo $ticket->body; } ?></textarea>
            </div>
            <label for="ticket_file_upload">Add files/images:</label>
            <input type="file" name="file[]" id="ticket_file_upload" multiple>
            <div id="thing">
                <div id="department">
                    <label for="departments">Department:</label>
                    <select name="department" id="departments">
                        <option value="">Select a department</option>
                        <?php foreach (Department::getAllDepartments($db) as $department) { ?>
                        <option value="<?= $department->id ?>" <?php if ($department->id === $ticket->department) { echo "selected"; } ?>><?= $department->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div id="priority">
                    <label for="priorities">Priority:</label>
                    <select name="priority" id="priorities">
                        <option value="3">Low</option>
                        <option value="2">Medium</option>
                        <option value="1">High</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php if (!is_null($ticket)) { echo $ticket->id; } ?>">
            <input type="submit" value="<?php if (!is_null($ticket)) { echo "Confirm"; } else { echo "New Ticket"; } ?>" id="sub_button">
            <a href="ticket_list.html" class="cancel_ticket">Cancel</a>
        </form>
    </main>


<?php } ?>