<?php 
    require "header.php";
?>

<main class="container">
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])){
        if (isset($_GET['id']) && $_GET['id']!="" && $_GET['name']!="") {
            // Detail of selected album
            $query = "SELECT * FROM images WHERE id IN (SELECT image_id FROM image_instances WHERE user_id=? AND id IN (SELECT image_id FROM album_images WHERE album_id=?))";
            $statement = mysqli_stmt_init($conn);
    
            if (!mysqli_stmt_prepare($statement, $query)) {
                header("Location: index.php?error=sqlerror");
                exit();
            } 
            else {
                mysqli_stmt_bind_param($statement, "ii", $_SESSION['userId'], $_GET['id']);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                
                echo '<h1>'.$_GET['name'].'</h1>';
                while($row = mysqli_fetch_assoc($result)){
                    echo '<span><img width="30%" style="margin: 1%;" src="../server/images/'.$row['path'].'"></span>';
                }
            }

        } else {
            // List all albums with their names
            $query = "SELECT * FROM albums WHERE userId=?";
            $statement = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($statement, $query)) {
                header("Location: index.php?error=sqlerror");
                exit();
            } 
            else {
                mysqli_stmt_bind_param($statement, "i", $_SESSION['userId']);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                echo '<h1>My Albums</h1>';
                echo '<div style="display: grid; grid-template-columns: 20% 20% 20% 20%; grid-gap: 3%;">';
                while($row = mysqli_fetch_assoc($result)){
                    echo '<flex style="text-align: center;"><a href="?id='.$row['id'].'&name='.$row['name'].'"><img src="./images/folder.png"/>'.$row['name'].'</a></flex> ';
                }
                echo '</div>';
            }
        }
    }
    ?>
</main>

<?php 
    require "footer.php";
?>