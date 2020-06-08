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
            // TODO: The following steps should be implemented right after we understand how to parse the metadata and hash the image content
            // NOTE: Leave the steps from this comment after implementing this
            // 1. Hash the image content
            // 2. Check whether the hash is present on the server. For the check -> we have a JSON file storing the info in
            //    { image_hash: path_to_image, ...} format
            // 3.1. If image content is not present, upload the file to the server and take the path from there
            //      Parse the meta data so that we can give the information to the Image model
            //      Create an Image and ImageInstance with the expected data
            // 3.2. If image content is present, take the image path from the JSON by the hash key
            //      Get the Image instance which has this path. Create new ImageInstance with FK to this Image. 
            //      Increase number_instances of the Image
            
            
            // Upload the file to server
            $filenameNew = uniqid($realFilename.'_').'.'.$fileExt;
            $fileDestination = './images/'.$filenameNew;

            move_uploaded_file($fileTmpName, $fileDestination);
            header("Location: ../client/index.php?success=uploaded");

        } else {
            echo "There was an error uploading your file.";
        }

    } else {
        echo "This file format is not allowed.";
    }
}