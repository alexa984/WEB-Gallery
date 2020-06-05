<?php 
    require "header.php";
?>

<main class="container" id="register">
    <h1>Register</h1>
    <form action="includes/register.inc.php" method="post">
        <input type="text" name="username" value="" placeholder="Username" class="form-input">
        <input type="email" name="email" value="" placeholder="Email" class="form-input">
        <input type="password" name="password" value="" placeholder="Password" class="form-input">
        <input type="password" name="password-cnf" value="" placeholder="Confirm password" class="form-input">
        <button type="submit" name="register-submit" class="form-button">Register</button>
    </form>
</main>

<?php 
    require "footer.php";
?>