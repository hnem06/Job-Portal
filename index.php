<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

header("Location: home.php");
exit();
?>
