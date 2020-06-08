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
            // Upload the file
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