<?php 
    require "header.php";
?>

<?php
    if (isset($_GET['success'])){
        if ($_GET['success'] == 'register') {
            echo '<div class="success-msg">You have successfully created your profile.</div>';
        }
    }
?>
<main class="container">
    <?php
        if (isset($_SESSION['userId'])) {     
            echo '<p>You are logged in!</p>';
        }
        else {
            echo '<p>You are currently logged out. Please log in.</p>';
        }
    ?>
</main>

<?php 
    require "footer.php";
?>