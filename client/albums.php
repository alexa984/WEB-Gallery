<?php 
    require "header.php";
    require "../server/dbhandler.php";
?>

<main class="container">
    <div class="flex">
        <h1 id="albums-title" class="inline-flex">My Albums</h1>
        <div class="inline-flex">
            <button onclick="openModal()" class="form-button" id="create-album-btn">&plus; | Create new album</button>
            <button onclick="openMergeModal()" class="form-button" id="merge-album-btn">Merge existing
                albums</button>
        </div>
    </div>
    <div id="modal">
        <div class="modal-header">
            <div class="title">Create new album</div>
            <button onclick="closeModal()" class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="create_album.php" enctype="multipart/form-data">
                <label for="start-date">Start date:</label><br>
                <input name="start-date" required type="date" min="1970-01-01" max='<?php echo date('Y-m-d');?>'><br>
                <label for="end-date">End date:</label><br>
                <input name="end-date" required type="date" min="1970-01-01" max='<?php echo date('Y-m-d');?>'><br>
                <label for="album-name">Album name:</label><br>
                <input name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea name="description" type="text"></textarea><br>
                <input id="create-button" type="submit" value="Create">
            </form>
        </div>
    </div>
    <div id="merge-modal">
        <div class="modal-header">
            <div class="title">Merge existing albums</div>
            <button onclick="closeMergeModal()" class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="merge_albums.php" enctype="multipart/form-data">
                <label for="start-date">Start date merge criteria:</label><br>
                <input name="start-date" required type="date" min="1970-01-01" max='<?php echo date('Y-m-d');?>'><br>
                <label for="end-date">End date merge criteria:</label><br>
                <input name="end-date" required type="date" min="1970-01-01" max='<?php echo date('Y-m-d');?>'><br>
                <label for="cars">Choose albums to merge:</label>
                <select name="cars" id="cars" multiple>
                    <?php
                        
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
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
                            }
                        }
                      ?>
                </select>
                <label for="album-name">Album name:</label><br>
                <input name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea name="description" type="text"></textarea><br>
                <input id="merge-button" type="submit" value="Merge albums">
            </form>
        </div>
        <div id="overlay"></div>

        <?php
    if (isset($_SESSION['userId'])){
        if (isset($_GET['id']) && $_GET['id']!="" && $_GET['name']!="") {
            // Detail of selected album
            $query = "SELECT * FROM images WHERE id IN (SELECT image_id FROM image_instances WHERE user_id=? AND id IN (SELECT image_instance_id FROM album_images WHERE album_id=?))";
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