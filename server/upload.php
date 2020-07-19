<?php
session_start();
if (isset($_POST['submit'])){
    $file = $_FILES['file'];
    $originalFilename = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileNameAndExt = explode('.', $originalFilename);
    $realFilename = $fileNameAndExt[0];
    $fileExt = strtolower($fileNameAndExt[1]);

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            require 'dbhandler.php';

            $user_id= $_SESSION['userId'];
                     
            // 1. Hash the image content
            $hash = hash_file('sha256', $fileTmpName);

            // 2. Check whether the hash is present on the server. For the check -> we have an image_map.json file storing the info in
            //    { image_hash: path_to_image, ...} format
            $image_map = file_get_contents('./images/image_map.json');
            $json_assoc = json_decode($image_map, true);

            // 3.1. If image content is not present, upload the file to the server and take the path from the newly uploaded
            //      Parse the meta data so that we can give the information to the Image model
            //      Create an Image and ImageInstance with the expected data
            if (!isset($json_assoc[$hash])) {
                // Upload the file to server
                $filenameNew = uniqid($realFilename.'_').'.'.$fileExt;
                $fileDestination = './images/'.$filenameNew;

                move_uploaded_file($fileTmpName, $fileDestination);

                // Append {hash: path_to_image} to the JSON
                $json_assoc[$hash] = $filenameNew;
                $json_data = json_encode($json_assoc);
                file_put_contents('./images/image_map.json', $json_data);

                // Parse the meta and exif data from image
                $meta = get_meta_tags($fileDestination);
                $exif = exif_read_data($fileDestination);
                if (isset($meta['author'])) {
                    $author = $meta['author'];
                } else {
                    $author = '';
                }
                if (isset($meta['description'])) {
                    $description = $meta['description'];
                } else {
                    $description = '';
                }

                $sqlInsertImage = "INSERT INTO images (path, original_filename, number_instances, timestamp, filesize, author, description) 
                                   VALUES (?, ?, '1', FROM_UNIXTIME(?), ?, ?, ?)";

                $imageInsertStatement = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($imageInsertStatement, $sqlInsertImage)) {
                    header("Location: ../client/index.php?error=sqlerror3");
                    exit();
                } else {
                    // Create an Image
                    mysqli_stmt_bind_param(
                        $imageInsertStatement, "ssiiss", 
                        $filenameNew, 
                        $originalFilename,
                         $exif['DateTime'],
                         $exif['FileSize'], 
                         $author, 
                         $description
                    );
                    mysqli_stmt_execute($imageInsertStatement);
                    mysqli_stmt_store_result($imageInsertStatement);
                    
                    // Get the ID of the image we just uploaded
                    $imageId = mysqli_insert_id($conn);

                    create_image_instance($conn, $user_id, $imageId);
                }
            }

            // 3.2. If image content is present, take the image path from the JSON by the hash key
            //      Get the Image which has this path. Create new ImageInstance with FK to this Image. 
            //      Increase number_instances of the Image
            
            else {
                $path_to_image = $json_assoc[$hash];
                $sqlGetImage = "SELECT * FROM images WHERE path=?";
                $imageGetStatement = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($imageGetStatement, $sqlGetImage)) {
                    header("Location: ../client/index.php?error=sqlerror4");
                    exit();
                } 
                else {
                    mysqli_stmt_bind_param($imageGetStatement, "s", $path_to_image);
                    mysqli_stmt_execute($imageGetStatement);
                    $image = mysqli_stmt_get_result($imageGetStatement);
                    $imageRow = mysqli_fetch_assoc($image);

                    create_image_instance($conn, $user_id, $imageRow['id']);

                    $currNumInstances = $imageRow['number_instances'];
                    
                    increase_image_number_instances($conn, $imageRow['id'], $currNumInstances);
                }
            }
            
            header("Location: ../client/index.php?success=uploaded");
            mysqli_close($conn);
            
        } else {
            echo "There was an error uploading your file.";
        }

    } else {
        echo "This file format is not allowed.";
    }

}