<?php
    function display_gallery($result) {
        $number_of_pictures = mysqli_num_rows($result);
        $picture_index = 0;
        $modal_gallery = '<div id="gallery-modal">
             <span class="close" onclick="closeGalleryModal()">&times;</span>';

        echo '<div id="delete-modal">
                            <div class="modal-header">
                                <div class="title">Delete image</div>
                                <span class="close" id="basic-modal" onclick="closeDeleteModal()">&times;</span>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <p>Are you sure you want to delete this image?</p>
                                    <div>
                                        <button type="submit" name="submit" onclick="closeDeleteModal()"
                                        class="form-button">Yes</button>
                                        <button name="no" onclick="closeDeleteModal()" class="form-button">No</button>
                                    </div>
                                </form>
                            </div>
                       </div>';

        echo '<div id="modify-modal">
                            <div class="modal-header">
                                <div class="title">Modify image details</div>
                                <span class="close" id="basic-modal" onclick="closeModifyModal()">&times;</span>
                            </div>
                            <div class="modal-body">
                                <form id="modify-details-form" method="POST" enctype="multipart/form-data">
                                    <label for="date-taken">Date taken:</label><br>
                                    <input class="modal-form" name="date-taken" type="date" min="1970-01-0" max='.date
                                    ('Y-m-d').'><br>
                                    <label for="author">Author:</label><br>
                                    <input class="modal-form" name="author" type="text"><br>
                                    <label for="description">Description:</label><br>
                                    <textarea class="modal-form" id="description" name="description" type="text"></textarea><br>
                                    <input class="form-button" type="submit" onclick="closeModifyModal()"
                                    value="Modify">
                                    <input class="form-button" type="submit" onclick="closeModifyModal()"
                                    value="Cancel">
                                </form>
                            </div>
                       </div>';

        while($row = mysqli_fetch_assoc($result)){
            echo '<img class="small-image" onclick="openGalleryModal(); currentSlide('.($picture_index + 1).')" src="../server/images/'.$row['path'].'">
                <img class="delete" onclick="openDeleteModal()" src="./images/delete.png">
                <img class="modify" onclick="openModifyModal()" src="./images/modify.png">';
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
?>