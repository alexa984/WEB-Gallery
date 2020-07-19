<?php 
    require "header.php";
?>

<main class="container">
    <h1>All Images</h1>
    <div class="gallery">
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
            $number_of_pictures = mysqli_num_rows($result);
            $picture_index = 0;
            $modal_gallery = '<div id="gallery-modal">
                <span class="close" onclick="closeGalleryModal()">&times;</span>';

            while($row = mysqli_fetch_assoc($result)){
                echo '<img class="small-image" onclick="openGalleryModal(); currentSlide('.($picture_index + 1).')"
                src="../server/images/'
                .$row['path'].'">';
                $picture_data = '';
                if(!empty($row['timestamp'])){
                    $picture_data .= 'Date: '.date('F j, Y', strtotime($row['timestamp']));
                }
                if(!empty($row['author'])){
                    $picture_data .= ' Author: '.$row['author'];
                }
                if(!empty($row['description'])){
                    $picture_data .= ' Description: '.$row['description'];
                }
                $modal_gallery .= '
                <div class="slides">
                    <div class="image-slide-part">
                        <img class="gallery-image" src="../server/images/'.$row['path'].'">
                    </div>
                    <div class="data-slide-part">
                        <div class="image-indexes">'.($picture_index + 1).' / '.$number_of_pictures.'</div>
                        <div class="data">'.$picture_data.'</div>
                    </div>
                </div>';
                $picture_index = $picture_index + 1;
            }

            $modal_gallery .= '<a class="previous" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <div id="overlay"></div>';

            echo $modal_gallery;
        }
    }
    ?>
    </div>
</main>

<?php 
    require "footer.php";
?>