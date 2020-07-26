<?php 
    require "header.php";
?>

<?php
    if (isset($_GET['success'])){
        if ($_GET['success'] == 'register') {
            echo '<div class="success-msg">You have successfully created your profile. Please login.</div>';
        } else if ($_GET['success'] == 'uploaded') {
            echo '<div class="success-msg">You have successfully uploaded your image.</div>';
        }
    }

    echo '<main class="container">';
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])) {
        echo '<h1>Welcome to your own Image Gallery!</h1>
            <p>You can now upload new images or view your existing ones. :)</p>';
        echo '<form action="../server/upload.php" method="POST" enctype="multipart/form-data">
                  <input type="file" name="file" required style="margin:20px 0px;"/>
                  <div>
                  <button type="submit" name="submit" class="form-button">Upload your image</button>
                </div>

              </form>';
        for ($i = 1; $i <= 50; $i++) {
            $todayYearsAgo = date("Y-m-d", strtotime("-$i years"));
            $query = "SELECT path FROM images WHERE
                        id IN (SELECT image_id FROM image_instances WHERE user_id=?
                        AND DATE(timestamp)=?)";
            $statement = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($statement, $query)) {
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($statement, "is", $_SESSION['userId'], $todayYearsAgo);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                $number_of_pictures = mysqli_num_rows($result);
                $picture_index = 0;
                $modal_gallery = '<div id="gallery-modal">
                    <span class="close" onclick="closeGalleryModal()">&times;</span>';
                if (mysqli_num_rows($result) > 0) {
                    $years = "year";
                    if ($i > 1) {
                        $years .= "s";
                    }
                    echo "<h2>You have memories from this day $i $years ago. Check them out:<h2>";
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<img class="small-image" onclick="openGalleryModal(); currentSlide('.($picture_index + 1).')"src="../server/images/'.$row['path'].'">';
                        $picture_data = '';
                        if(!empty($row['timestamp'])){
                            $picture_data .= 'Date: '.date('F j, Y', strtotime($row['timestamp'])).'<br />';
                        }
                        if(!empty($row['author'])){
                            $picture_data .= ' Author: '.$row['author'].'<br />';
                        }
                        if(!empty($row['description'])){
                            $picture_data .= ' Description: '.$row['description'].'<br />';
                        }
                        if(!empty($row['gps_longitude']) && !empty($row['gps_latitude'])){
                            $picture_data .= 'Place taken: '.'<a class="white" target="_blank" href="https://maps.google.com/?q='.$row['gps_latitude'].','.$row['gps_longitude'].'">'.$row['address'].'</a><br />';
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
        }
    }
    else {
        echo '<h1>Welcome to Image Gallery!</h1>
            <p>Please log into your profile or register to be able to upload pictures and generate galleries!</p>';
    }
    echo '</main>';
?>

<?php 
    require "footer.php";
?>