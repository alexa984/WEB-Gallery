<?php
if (isset($_POST['login-submit'])){
    # Create connection to the db
    require 'dbhandler.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

}
else {
    # Login the right way using the form
    header("Location: ../client/index.php");
    exit();
}