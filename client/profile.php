<?php
    require "header.php";
?>

<main class="container">
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])) {
        $query_basic_details = "SELECT * FROM users WHERE id=?";
        $statement_basic_details = mysqli_stmt_init($conn);
        $query_albums_count = "SELECT COUNT(id) FROM albums WHERE userId=?";
        $statement_albums_count = mysqli_stmt_init($conn);
        $query_images_count = "SELECT COUNT(id) FROM image_instances WHERE user_id=?";
        $statement_images_count = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement_basic_details, $query_basic_details) or
             !mysqli_stmt_prepare($statement_albums_count, $query_albums_count) or
             !mysqli_stmt_prepare($statement_images_count, $query_images_count)) {
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($statement_basic_details, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement_basic_details);
            $result_basic_details = mysqli_stmt_get_result($statement_basic_details)->fetch_assoc();
            echo '<h1>My Profile Details</h1>';
            echo '<p> <em>Username: </em>'.$result_basic_details['username'].'</p>';
            echo '<p> <em>Email: </em>'.$result_basic_details['email'].'</p>';
            echo '<p> <em>Member since: </em>'.date('F d, Y', strtotime($result_basic_details['date_registered'])).'</p>';

            echo '<p> <em>Last login: </em>'.date('F d, Y h:mA', $_SESSION['start_time']).'</p>';

            mysqli_stmt_bind_param($statement_images_count, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement_images_count);
            $result_images_count = mysqli_stmt_get_result($statement_images_count)->fetch_array();
            echo '<p> <em>Total image count: </em>'.$result_images_count[0].'</p>';

            mysqli_stmt_bind_param($statement_albums_count, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement_albums_count);
            $result_albums_count = mysqli_stmt_get_result($statement_albums_count)->fetch_array();
            echo '<p> <em>Total album count: </em>'.$result_albums_count[0].'</p>';
        }
    }
?>


</main>

<?php
    require "footer.php";
?>