<?php
# Check if user has clicked the register button
if (isset($_POST['register-submit'])) {
    # Create connection to the db
    require 'dbhandler.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-cnf'];

    # Check if any of the fields is empty
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)){
        # Redirect back to the registration form
        # Attach errors + username and email which were already put in
        header("Location: ../client/register.php?error=emptyfields&username=".$username."&email=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        # Redirect back to the registration form
        # Attach errors for invalid email
        header("Location: ../client/register.php?error=invalidemail&username=".$username);
        exit();
    }

}