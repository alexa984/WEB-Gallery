<?php 
    require "header.php";
?>

<?php
    if (isset($_GET['success'])){
        if ($_GET['success'] == 'register') {
            echo '<div class="success-msg">You have successfully created your profile.</div>';
        } else if ($_GET['success'] == 'uploaded') {
            echo '<div class="success-msg">You have successfully uploaded your image.</div>';
        }
    }
?>
<main class="container">
    <form action="../server/upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <div>
            <button type="submit" name="submit" class="form-button">Upload your image</button>
        </div>
    </form>
</main>

<?php 
    require "footer.php";
?>