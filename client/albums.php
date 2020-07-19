<?php 
    require "header.php";
?>

<main class="container">
    <h1>My Albums</h1>
    <div>
    <!-- TODO make the plus prettier -->
        <button onclick="openModal()" class="form-button">&plus; | Create new album</button>
    </div>
    <div id="modal">
        <div class="modal-header">
            <div class="title">Create new album</div>
            <button onclick="closeModal()" class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse quod alias ut illo doloremque eum ipsum obcaecati distinctio debitis reiciendis quae quia soluta totam doloribus quos nesciunt necessitatibus, consectetur quisquam accusamus ex, dolorum, dicta vel? Nostrum voluptatem totam, molestiae rem at ad autem dolor ex aperiam. Amet assumenda eos architecto, dolor placeat deserunt voluptatibus tenetur sint officiis perferendis atque! Voluptatem maxime eius eum dolorem dolor exercitationem quis iusto totam! Repudiandae nobis nesciunt sequi iure! Eligendi, eius libero. Ex, repellat sapiente!
        </div>
    </div>
    <div id="overlay"></div>

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