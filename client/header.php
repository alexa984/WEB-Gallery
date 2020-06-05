<html>

<head>
    <meta charset='utf-8'>
    <title></title>
    <link rel="stylesheet" href="nav.css">
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
                    <form action="includes/login.inc.php" method="post">
                        <input type="text" name="username" value="" placeholder="Username">
                        <input type="password" name="password" value="" placeholder="Password">
                        <button type="submit" name="login" class="form-button">Login</button>
                        <a href="signup.php" id="signup-link">Register</a>
                    </form>
                    <form action="includes/logout.inc.php" method="post">
                        <button type="submit" name="login" class="form-button">Logout</button>
                    </form>
                </li>
        </nav>
    </header>
</body>

</html>