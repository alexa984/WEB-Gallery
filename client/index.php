<?php 
    require "header.php";
?>

<?php
    if (isset($_GET['success'])){
        if ($_GET['success'] == 'register') {
            echo '<div class="success-msg">You have successfully created your profile. Please login.</div>';
        } else if ($_GET['success'] == 'uploaded') {
            echo '<div class="success-msg">You have successfully uploaded your image.</div>';
        }
    }

    echo '<main class="container">';
    require "../server/dbhandler.php";
    if (isset($_SESSION['userId'])) {
        echo '<form action="../server/upload.php" method="POST" enctype="multipart/form-data">
                  <input type="file" name="file">
                  <div>
                    <button type="submit" name="submit" class="form-button">Upload your image</button>
                  </div>
              </form>';
        for ($i = 1; $i <= 10; $i++) {
            $todayYearsAgo = date("Y-m-d", strtotime("-$i years"));
            $query = "SELECT path FROM images WHERE
                        id IN (SELECT image_id FROM image_instances WHERE user_id=?
                        AND DATE(timestamp)=?)";
            $statement = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($statement, $query)) {
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($statement, "is", $_SESSION['userId'], $todayYearsAgo);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                if (mysqli_num_rows($result) > 0) {
                    echo "<h2>You have memories from this day $i years ago. Check them out:<h2>";
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<span><img width="30%" style="margin: 1%;" src="../server/images/'.$row['path'].'"></span>';
                    }
                }

            }
        }
    }
    else {
        echo '<p>Welcome to Image Gallery! Please log into your profile or register to be able to upload pictures and
         generate galleries!</p>';
    }
    echo '</main>';
?>

<?php 
    require "footer.php";
?>