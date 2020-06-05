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
        <button type="submit" name="register-submit" class="form-button">Register</button>
    </form>
</main>

<?php 
    require "footer.php";
?>