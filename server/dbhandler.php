<?php
    $server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "web_gallery";

    # create connection

    $conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }