<?php
require "../client/header.php";
require "dbhandler.php";
if (isset($_SESSION['userId'])){
    $query_check_album_name = "SELECT * FROM albums WHERE name=? AND userId=?";
    $statement_check_album_name = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement_check_album_name, $query_check_album_name)) {
        header("Location: ../client/index.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($statement_check_album_name, "si", $_POST['album-name'], $_SESSION['userId']);
    mysqli_stmt_execute($statement_check_album_name);
    $result_albums = mysqli_stmt_get_result($statement_check_album_name);
    $number_of_albums = mysqli_num_rows($result_albums);
    if ($number_of_albums > 0) {
        header("Location: ../client/albums.php?error=albumnameerror");
        exit();
    }

    $query_images_id = "SELECT image_instances.id FROM images INNER JOIN image_instances ON images.id=image_instances
    .image_id
    WHERE user_id=? AND (DATE(timestamp) BETWEEN ? AND ?) ORDER BY timestamp ASC";
    $statement_images_id = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement_images_id, $query_images_id)) {
        header("Location: ../client/index.php?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($statement_images_id, "iss", $_SESSION['userId'], $_POST['start-date'], $_POST['end-date']);
        mysqli_stmt_execute($statement_images_id);
        $result = mysqli_stmt_get_result($statement_images_id);
        $number_of_pictures = mysqli_num_rows($result);
        if ($number_of_pictures > 0) {
            mysqli_begin_transaction($conn);
            mysqli_autocommit($conn, FALSE);
            $query_create_album = "INSERT INTO albums (name, description, createdAt, userId) VALUES (?, ?, NOW(), ?)";
            $statement_create_album = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statement_create_album, $query_create_album)) {
                header("Location: ../client/index.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($statement_create_album, "ssi", $_POST['album-name'], $_POST['description'],
            $_SESSION['userId']);
            mysqli_stmt_execute($statement_create_album);
            $last_album_id = mysqli_insert_id($conn);
            $query_add_image = "INSERT INTO album_images (image_instance_id, album_id) VALUES (?, ?)";
            $statement_add_image = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statement_add_image, $query_add_image)) {
                header("Location: ../client/index.php?error=sqlerror");
                exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                mysqli_stmt_bind_param($statement_add_image, "ii", $row[0], $last_album_id);
                mysqli_stmt_execute($statement_add_image);
            }
            mysqli_commit($conn);
            header("Location: ../client/albums.php");
        }
        else{
            header("Location: ../client/albums.php?error=dateerror");
        }
    }
}

?>