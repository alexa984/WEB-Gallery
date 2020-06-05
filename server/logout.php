<?php
# Clear session data and redirect to home page
session_start();
session_unset();
session_destroy();
header("Location: ../client/index.php");