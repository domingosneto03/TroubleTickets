<?php
function output_login_form() { ?>
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