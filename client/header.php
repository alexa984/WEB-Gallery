<html>

<head>
    <meta charset='utf-8'>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Albums</a></li>
                <li><a href="#">All Images</a></li>
                <li><a href="#">Profile</a></li>
                <li id="inline-login">
                    <form action="server/login.php" method="post">
                        <input type="text" name="username" value="" placeholder="Username" class="form-input">
                        <input type="password" name="password" value="" placeholder="Password" class="form-input">
                        <button type="submit" name="login-submit" class="form-button">Login</button>
                        <a href="register.php" id="register-link">Register</a>
                    </form>
                    <form action="server/logout.php" method="post">
                        <button type="submit" name="logout-submit" class="form-button">Logout</button>
                    </form>
                </li>
        </nav>
    </header>