<?php 
    require "header.php";
    require "../server/dbhandler.php";
?>

<main class="container">
    <div class="flex">
        <h1 id="albums-title" class="inline-flex">My Albums</h1>
        <div class="inline-flex">
            <button onclick="openModal()" class="form-button" id="create-album-btn">Create new album</button>
            <button onclick="openMergeModal()" class="form-button" id="merge-album-btn">Merge existing
                albums</button>
        </div>
    </div>
    <div class="modal" id="create-modal">
        <div class="modal-header">
            <div class="title">Create new album</div>
            <span class="close" id="basic-modal" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="create_album.php" enctype="multipart/form-data">
                <label for="start-date">Start date:</label><br>
                <input class="modal-form" name="start-date" required type="date" min="1970-01-01" max='<?php echo
                 date('Y-m-d');?>'><br>
                <label for="end-date">End date:</label><br>
                <input class="modal-form" name="end-date" required type="date" min="1970-01-01" max='<?php echo date('Y-m-d');?>'><br>
                <label for="album-name">Album name:</label><br>
                <input class="modal-form" name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea class="modal-form" id="description" name="description" type="text"></textarea><br>
                <input class="form-button" type="submit" value="Create">
            </form>
        </div>
    </div>
    <div class="modal" id="merge-modal">
        <div class="modal-header">
            <div class="title">Merge existing albums</div>
            <span class="close" id="basic-modal" onclick="closeMergeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="../server/merge_albums.php"
            enctype="multipart/form-data">
                <label for="start-date">Start date merge criteria:</label><br>
                <input class="modal-form" name="start-date" type="date" min="1970-01-01" max='<?php echo date
                ('Y-m-d');?>'><br>
                <label for="end-date">End date merge criteria:</label><br>
                <input class="modal-form" name="end-date" type="date" min="1970-01-01" max='<?php echo date
                ('Y-m-d');?>'><br>
                <label for="albums">Choose albums to merge:</label><br>
                <select class="modal-form" name="albums[]" id="albums" multiple>
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
                </select></br>
                <label for="album-name">Album name:</label><br>
                <input class="modal-form" name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea class="modal-form" id="description" name="description" type="text"></textarea><br>
                <input class="form-button" id="merge-button" type="submit" value="Merge albums">
            </form>
        </div>
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

                echo '<h2>'.$_GET['name'].'</h2>';
                require "display_gallery.php";
                display_gallery($result);
            }

        } else {
            if (isset($_GET['error']) && $_GET['error']=="dateerror" ) {
                echo '<p id="album-date-error"> You have no images from the date range you have selected!</p>';
            }
            if (isset($_GET['error']) && $_GET['error']=="albumnameerror" ) {
                 echo '<p id="album-date-error"> You already have an album with the same name!</p>';
            }
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
                echo '<div style="display: grid; grid-template-columns: 20% 20% 20% 20%; grid-gap: 7%;">';
                while($row = mysqli_fetch_assoc($result)){
                    echo '<flex style="text-align: center;"><a href="?id='.$row['id'].'&name='.$row['name'].'"><img
                    class="folder" src="./images/folder.png"/>'.$row['name'].'</a></flex> ';
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