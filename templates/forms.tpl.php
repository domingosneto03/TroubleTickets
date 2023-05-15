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
                <p>Don't have an account? <a href="register.html">Register here</a></p>
            </form>
            </section>
    </main>
<?php } ?>

<?php function output_register_form() { ?>
    <main>
        <section id="register">
            <h2>Register</h2>
            <form>
                <label>Username
                    <input type="text" id="username" name="username" placeholder="Create an username">
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
                <button formaction="../actions/action_register.php" formmethod="post">Register</button>
            </form>
        </section>
    </main>
<?php } ?>

<?php function output_new_ticket_form() {
    global $db; ?>
    <main>
        <div class="top_bar">
            <h2 class="main_title">New Ticket</h2>
        </div>

        <form action="../actions/action_new_ticket.php" method="post" id="new_ticket_form" enctype="multipart/form-data">
            <div id="title">
                <label for="ticket_title" id="title_label">Ticket title:</label>
                <input type="text" name="title" id="ticket_title" required maxlength="55">
            </div>
            <div id="text">
                <label for="ticket_text" id="text_label">Ticket description:</label>
                <!-- tags go as #tag in the text box, boa sorte para implementar essa merda Ribeiro -->
                <!-- depois o sql convém ter uma secção de texto composta pelas tags separadas por vírgulas para
                as poder mostrar depois no ticket -->
                <textarea name="body" id="ticket_text" cols="30" rows="20" required></textarea>
            </div>
            <label for="ticket_file_upload">Add files/images:</label>
            <input type="file" name="file[]" id="ticket_file_upload" multiple>
            <div id="thing">
                <div id="department">
                    <label for="departments">Department:</label>
                    <select name="department" id="departments">
                        <?php foreach (Department::getAllDepartments($db) as $department) { ?>
                        <option value="<?= $department->id ?>"><?= $department->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div id="priority">
                    <label for="priorities">Priority:</label>
                    <select name="priority" id="priorities">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Create Ticket" id="sub_button">
            <a href="ticket_list.html" class="cancel_ticket">Cancel</a>
        </form>
    </main>


<?php } ?>