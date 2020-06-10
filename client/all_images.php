<?php 
    require "header.php";
?>

<main class="container">
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])){
        $query = "SELECT * FROM images WHERE id IN (SELECT image_id FROM image_instances WHERE user_id=?)";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            exit();
        } 
        else {
            mysqli_stmt_bind_param($statement, "i", $_SESSION['userId']);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            while($row = mysqli_fetch_assoc($result)){
                echo '<span><img width="30%" style="margin: 1%;" src="../server/images/'.$row['path'].'"></span>';
            }
        }
    }
    ?>
</main>

<?php 
    require "footer.php";
?>