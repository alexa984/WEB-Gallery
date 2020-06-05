<?php 
    require "header.php";
?>

<script src="js/validate_register.js"></script>
<main class="container" id="register">
    <h1>Register</h1>
    <form action="../server/register.php" method="post">
        <input type="text" minlenght="6" maxlength="128" required name="username" value="" placeholder="Username"
            class="form-input">
        <input type="email" required name="email" value="" placeholder="Email" class="form-input">
        <input type="password" required name="password" minlength="8" value="" placeholder="Password" class="form-input"
            onkeyup="validateConfirmPassword()">
        <input type="password" required name="password-cnf" minlength="8" value="" placeholder="Confirm password"
            class="form-input" onkeyup="validateConfirmPassword()">
        <div id='message'></div>

        <!-- Show server errors -->
        <?php
            if (isset($_GET['error'])){
                if ($_GET['error'] == 'emptyfields') {
                    echo "<div class='err-message'>Fill in all fields.</div>";
                }
                if ($_GET['error'] == 'invalidemail') {
                    echo "<div class='err-message'>Please enter a valid email address.</div>";
                }
                if ($_GET['error'] == 'passwordcheck') {
                    echo "<div class='err-message'>Passwords does not match.</div>";
                }
                if ($_GET['error'] == 'sqlerror') {
                    echo "<div class='err-message'>A DB error occured. Sorry for the inconvinience.</div>";
                }
                if ($_GET['error'] == 'usertaken') {
                    echo "<div class='err-message'>This username is already taken.</div>";
                }
                if ($_GET['error'] == 'emailtaken') {
                    echo "<div class='err-message'>User with this email already exists.</div>";
                }
            }
        ?>
        <button type="submit" name="register-submit" class="form-button">Register</button>
    </form>
</main>

<?php 
    require "footer.php";
?>