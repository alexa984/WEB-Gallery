<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Image gallery</title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script type="text/javascript">
    const loadMessagesCss = () => {
        let newStyleSheet = document.createElement('link');
        newStyleSheet.rel = 'stylesheet';
        newStyleSheet.href = 'css/messages.css';
        document.getElementsByTagName("head")[0].appendChild(newStyleSheet);
    }
    window.addEventListener('load', loadMessagesCss);
    </script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                    if (isset($_SESSION['userId'])) {
                        echo '<li><a href="albums.php">Albums</a></li>
                        <li><a href="all_images.php">All Images</a></li>
                        <li><a href="#">Profile</a></li>
                        <li id="inline-login">';
                    } 
                ?>
                <?php
                    if (isset($_SESSION['userId'])) {     
                        echo "
                        <form action='../server/logout.php' method='post'>
                            <button type='submit' name='logout-submit' class='form-button'>Logout</button>
                        </form>";
                    } 
                    else {
                        echo "
                        <form action='../server/login.php' method='post'>
                            <input type='text' name='username' value='' placeholder='Username' class='form-input'>
                            <input type='password' name='password' value='' placeholder='Password' class='form-input'>
                            <button type='submit' name='login-submit' class='form-button'>Login</button>
                            <a href='register.php' id='register-link'>Register</a>
                        </form>";
                    }
                    ?>
                </li>
        </nav>
    </header>