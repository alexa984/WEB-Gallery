<?php 
    require "header.php";
?>

<main class="container">
    <h1>My Albums</h1>
    <?php
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])){
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
            echo '<div style="display: grid; grid-template-columns: 20% 20% 20% 20%; grid-gap: 3%;">';
            while($row = mysqli_fetch_assoc($result)){
                echo '<flex style="text-align: center;"><img src="./images/folder.png"/>'.$row['name'].'</flex> ';
            }
            echo '</div>';
        }
    }
    ?>
</main>

<?php 
    require "footer.php";
?>