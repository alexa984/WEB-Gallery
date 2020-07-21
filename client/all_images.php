<?php 
    require "header.php";
?>

<main class="container">
    <h1>All Images</h1>
    <div class="gallery">
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])){
        $query = "SELECT * FROM images WHERE id IN (SELECT image_id FROM image_instances WHERE user_id=?) ORDER BY
        timestamp DESC";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            exit();
        } 
        else {
            mysqli_stmt_bind_param($statement, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            require "display_gallery.php";
            display_gallery($result);
        }
    }
    ?>
    </div>
</main>

<?php 
    require "footer.php";
?>