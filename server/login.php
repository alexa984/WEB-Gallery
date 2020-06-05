<?php
if (isset($_POST['login-submit'])){
    require 'dbhandler.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    # Check if any of the fields is empty
    if (empty($username) || empty($password)){
        header("Location: ../client/index.php?error=emptyfields");
        exit();
    }
    else {
        # Check matching username and password
        $sql = "SELECT * FROM users WHERE username=?";
        $statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            header("Location: ../client/index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $passwordCheck = password_verify($password, $row['password']);
                if ($passwordCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['userUsername'] = $row['username'];

                    header("Location: ../client/index.php?success=login");
                    exit();
                }
                else {
                    # Wrong password
                    header("Location: ../client/index.php?error=wrongpassword");
                    exit(); 
                }

            }
            else {
                # No such user exists
                header("Location: ../client/index.php?error=nouser");
            exit();
            }
        }
    }

}
else {
    # Login the right way using the form
    header("Location: ../client/index.php");
    exit();
}