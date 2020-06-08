<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileNameAndExt = explode('.', $fileName);
    $realFilename = $fileNameAndExt[0];
    $fileExt = strtolower($fileNameAndExt[1]);

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            // TODO: Database changes should be made on upload right after we understand how to parse the metadata
            
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
                $fileDestination = 'images/'.$filenameNew;

                move_uploaded_file($fileTmpName, $fileDestination);

                // Append {hash: path_to_image} to the JSON
                $json_assoc[$hash] = $filenameNew;
                $json_data = json_encode($json_assoc);
                file_put_contents('./images/image_map.json', $json_data);
            }

            // 3.2. If image content is present, take the image path from the JSON by the hash key
            //      Get the Image which has this path. Create new ImageInstance with FK to this Image. 
            //      Increase number_instances of the Image
            
            else {
                $fileDestination = $json_assoc[$hash];
            }
            
            header("Location: ../client/index.php?success=uploaded");

        } else {
            echo "There was an error uploading your file.";
        }

    } else {
        echo "This file format is not allowed.";
    }
}