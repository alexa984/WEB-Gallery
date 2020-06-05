<?php 
    require "header.php";
?>

<main class="container">
    <?php
        if (isset($_SESSION['userId'])) {     
            echo '<p>You are logged in!</p>';
        }
        else {
            echo '<p>You are logged out! Please log in.</p>';
        }
    ?>
</main>

<?php 
    require "footer.php";
?>