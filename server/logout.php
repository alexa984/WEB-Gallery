<?php
# Clear session data and redirect to home page
session_start();
unset($_SESSION['start_time']);
session_unset();
session_destroy();
header("Location: ../client/index.php");