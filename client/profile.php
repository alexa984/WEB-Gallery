<?php 
    require "header.php";
?>

<main class="container">
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])) {
        $query = "SELECT * FROM users WHERE id=?";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            exit();
        } 
        else {
            mysqli_stmt_bind_param($statement, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement)->fetch_assoc();
            echo '<p> <em>Username: </em>'.$result['username'].'</p>';
            echo '<p> <em>Email: </em>'.$result['email'].'</p>';
            date_default_timezone_set('Europe/Sofia');
            echo '<p> <em>Logged at: </em>'.date('Y-m-d H:i:s', $_SESSION['start_time']).'</p>';
        }
    }
?>


</main>

<?php 
    require "footer.php";
?>