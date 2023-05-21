<?php 
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();
    $session = new Session();
?>

<?php function output_settings($session) { 
    global $db; ?>
    <main id="settings_main">
        <aside id="settings_sidebar">
            <nav class="selections">
                <a onclick="piShow()" class="active">
                    <span class="material-symbols-outlined">person</span>
                    Personal Info
                </a> 
                <a onclick="accShow()">
                    <span class="material-symbols-outlined">key</span>
                    Account
                </a> 
            </nav>
        </aside>
        <section id="settings">
            <div class="personal_info">
                <h2>Personal Info</h2>
                <?php 
                        if (end($session->getMessages())['text'] == 'username already exists!'){
                            ?> <p class="error_message">Username already exists! Please choose another one.</p> <?php
                        } if (end($session->getMessages())['text'] == 'old password do not match'){
                            ?> <p class="error_message">Username already exists! Please choose another one.</p> <?php
                        } if(end($session->getMessages())['text'] == 'passwords do not match') {
                            ?> <p class="error_message">Passwords don't match!</p> <?php  
                        } if(end($session->getMessages())['text'] == 'password is too short') {
                            ?> <p class="error_message">This password is too short. Please try another one.</p> <?php  
                        }
                    ?>
                <div>
                    <h3>Name</h3>
                    <form action="/../actions/action_add_name.php" method="post">
                        <input type="text" name="actualName" id="actualName" value="<?= User::getUserById($db, $session->getId())->actualName ?>">
                        <button type="submit">Save</button>
                    </form>
                    <h3>Date of Birth</h3>
                    <form action="/../actions/action_add_birth.php" method="post">
                        <input type="date" name="birthDate">
                        <button type="submit">Save</button>
                    </form>
                    <h3>Gender</h3>
                    <form action="/../actions/action_add_gender.php" method="post">
                        <input type="text" value="<?= User::getUserById($db, $session->getId())->gender ?>" name="gender">
                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
            <div class="account">
                <h2>Account</h2>
                <h3>Change Username</h3>
                <div class="show" id="change_username">
                    <button>Change Username</button>
                </div>
                <form class="hide" id="new_username">
                    New Username
                    <input type="text" name="new_username" value="<?= User::getUserById($db, $session->getId())->username ?>">
                    <button  formaction="actions/action_change_username.php" formmethod="post">Save</button>
                </form>
                <h3>Change Password</h3>
                <div id="change_password">
                    <form>
                        <label>
                            Old Password
                            <input type="password" name="old_password" placeholder="Type your old password">
                        </label>
                        <label>
                            New Password
                            <input type="password" name="new_password" placeholder="Type your new password">
                        </label>
                        <label>
                            Confirm Password 
                            <input type="password" name="confirmPassword" placeholder="Confirm your password">
                        </label>
                        <button formaction="actions/action_change_password.php" formmethod="post">Update Password</button>
                    </form> 
                </div>
            </div>
        </section>
    </main>
<?php } ?>