<?php
include ("../config.php");
$configs = new Config();

    # create connection
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }


    # Some helper functions for easier image management
    
    function create_image_instance($conn, $user_id, $image_id) {
        $sqlInsertImageInstance = "INSERT INTO image_instances (user_id, image_id) VALUES (?, ?)";
        $imageInsertStatement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($imageInsertStatement, $sqlInsertImageInstance)) {
            header("Location: ../client/index.php?error=sqlerror1");
            exit();
        } else {
            mysqli_stmt_bind_param($imageInsertStatement, "ii", $user_id, $image_id);
            mysqli_stmt_execute($imageInsertStatement);
            mysqli_stmt_store_result($imageInsertStatement);
        }    
        mysqli_stmt_close($imageInsertStatement);
    }

    function increase_image_number_instances($conn, $image_id, $current_number_instances){
        $sqlUpdateImage = "UPDATE images SET number_instances=? WHERE id=?";
        $imageUpdateStatement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($imageUpdateStatement, $sqlUpdateImage)) {
            header("Location: ../client/index.php?error=sqlerror2");
            exit();
        } else {
            $num_instanes = $current_number_instances + 1;
            mysqli_stmt_bind_param($imageUpdateStatement, "ii", $num_instanes, $image_id);
            mysqli_stmt_execute($imageUpdateStatement);
            mysqli_stmt_store_result($imageUpdateStatement);
        }
        mysqli_stmt_close($imageUpdateStatement);
    }