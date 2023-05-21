<?php 
    declare(strict_types = 1);
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/department.class.php");
    $db = getDatabaseConnection();

?>

<?php function output_login_form($session) { ?>
    <main>
        <section id="login">
            <h2>Login</h2>
            <?php 
                if (end($session->getMessages())['type'] == 'error'){
                 ?> <p class="error_message">Invalid Credentials! Please try again.</p> <?php
                }
            ?>
            <form>
                <label>Username
                    <input type="text" name="username" placeholder="Type your username or email" autofocus>
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

<?php function output_register_form($session) { ?>
    <main>
        <section id="register">
            <h2>Register</h2>
            <?php 
                if ($session->getMessages()['text'] == 'username already exists!'){
                    ?> <p class="error_message">Username already exists! Please choose another one.</p> <?php
                } else if($session->getMessages()['text'] == 'passwords do not match') {
                    ?> <p class="error_message">Passwords don't match!</p> <?php  
                } else if($session->getMessages()['text'] == 'password is too short') {
                    ?> <p class="error_message">This password is too short. Please try another one.</p> <?php  
                }
            ?>
            <form enctype="multipart/form-data">
                <label>Username <span class="required">*</span>
                    <input type="text" id="username" name="username" placeholder="Create a username" autofocus required>
                    <span id="usernameError"></span>
                </label>
                <label>Name <span class="required">*</span>
                    <input type="text" id="actualName" name="actualName" placeholder="Your real name" required>
                </label>
                <label>Birth Date <span class="required">*</span>
                    <input type="date" name="birthDate" id="birthDate" required>
                </label>
                <label>Gender <span class="required">*</span>
                    <input type="text" name="gender" id="gender" required>
                </label>
                <label>E-mail <span class="required">*</span>
                    <input type="email" name="email" placeholder="Type your email" required>
                </label>
                <label>Password <span class="required">*</span>
                    <input type="password" id="password" name="password" placeholder="Create your password" required>
                    <span id="passwordError"></span>
                </label>
                <label>Confirm Password <span class="required">*</span>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    <span id="confirmPasswordError"></span>
                </label>
                <label>
                    <input type="text" name="bio" placeholder="Write a short bio about yourself" max="55">
                </label>
                <label>Image
                    <input type="file" name="userImage" id="user_image_upload">
                </label>
                <button formaction="/actions/action_register.php" formmethod="post">Register</button>
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
                <textarea name="body" id="ticket_text" cols="30" rows="20" required><?php if (!is_null($ticket)) { echo $ticket->body; } ?></textarea>
            </div>
            <label for="ticket_file_upload">Add files/images:</label>
            <input type="file" name="file[]" id="ticket_file_upload" multiple>
            <div id="thing">
                <div id="department">
                    <label for="departments">Department:</label>
                    <select name="department" id="departments">
                        <option value="1">Select a department</option>
                        <?php foreach (Department::getAllDepartments($db) as $department) { 
                            if ($department->id != 1) { ?>
                                <option value="<?= $department->id ?>" <?php if ($department->id === $ticket->department) { echo "selected"; } ?>><?= $department->name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div id="priority">
                    <label for="priorities">Priority:</label>
                    <select name="priority" id="priorities">
                        <option value="4">Low</option>
                        <option value="3">Medium</option>
                        <option value="2">High</option>
                        <option value="1">Urgent</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php if (!is_null($ticket)) { echo $ticket->id; } ?>">
            <input type="submit" value="<?php if (!is_null($ticket)) { echo "Confirm"; } else { echo "New Ticket"; } ?>" id="sub_button">
            <a href="/../ticket_list.php" class="cancel_ticket">Cancel</a>
        </form>
    </main>


<?php } ?>