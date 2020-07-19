<?php
if (isset($_POST['register-submit'])){
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
        # Attach errors for invalid email
        header("Location: ../client/register.php?error=invalidemail&username=".$username);
        exit();
    }
    else if ($password !== $passwordConfirm) {
        # Attach errors for invalid username
        header("Location: ../client/register.php?error=passwordcheck&email=".$email."&username=".$username);
        exit();
    }
    else {
        # Check if user with such username already exists
        $sqlUsername = "SELECT username FROM users WHERE username=?";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $sqlUsername)) {
            header("Location: ../client/register.php?error=sqlerror");
            exit();
        } 
        else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $resultCheck = mysqli_stmt_num_rows($statement);

            if ($resultCheck > 0) {
                # If such user exists, return error
                header("Location: ../client/register.php?error=usertaken");
                exit();
            }
            else {
                # Check if user with such email already exists
                $sqlEmail = "SELECT email FROM users WHERE email=?";
                $emailStatement = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($emailStatement, $sqlEmail)) {
                    header("Location: ../client/register.php?error=sqlerror");
                    exit();
                } 
                else {
                    mysqli_stmt_bind_param($emailStatement, "s", $email);
                    mysqli_stmt_execute($emailStatement);
                    mysqli_stmt_store_result($emailStatement);
                    $resultCheckEmail = mysqli_stmt_num_rows($emailStatement);
                
                    if ($resultCheckEmail > 0) {
                        header("Location: ../client/register.php?error=emailtaken&username=".$username);
                        exit();
                    }
                    else {
                        # Otherwise create new record in the DB
                        $sqlInsert = "INSERT INTO users (username, email, password, date_registered) VALUES (?, ?, ?, ?)";
                        $insertStatement = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($insertStatement, $sqlInsert)) {
                            header("Location: ../client/register.php?error=sqlerror");
                            exit();
                        } 
                        else {
                            # Everything went well. Creating the user
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            mysqli_stmt_bind_param($insertStatement, "ssss", $username, $email, $hashedPassword, date("Y-m-d"));
                            mysqli_stmt_execute($insertStatement);
                            mysqli_stmt_store_result($insertStatement);

                            header("Location: ../client/index.php?success=register");
                            exit();
                        }
                    }
                } 
            }
        }
    }

    # Close DB connections
    mysqli_stmt_close($statement);
    mysqli_stmt_close($emailStatement);
    mysqli_stmt_close($insertStatement);

    mysqli_close($conn);
}
else {
    # Register the right way using form
    header("Location: ../client/register.php");
    exit();
}